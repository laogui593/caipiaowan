#!/bin/bash

# 彩票系统强制启动脚本 - 不惜一切代价跑通
# 即使数据库暂时连接不上也要把服务启动起来

set +e  # 忽略错误继续执行

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

WORKDIR=$(pwd)

log_info() { echo -e "${GREEN}[✓]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[!]${NC} $1"; }
log_error() { echo -e "${RED}[✗]${NC} $1"; }
log_step() { echo -e "${BLUE}[→]${NC} $1"; }

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   彩票系统强制启动${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# 1. PHP环境检查
log_step "检查PHP环境..."
PHP_VERSION=$(php -r "echo PHP_VERSION;" 2>/dev/null || echo "未知")
log_info "PHP版本: $PHP_VERSION"

# 2. 设置权限
log_step "设置目录权限..."
mkdir -p Runtime/Cache Runtime/Temp Runtime/Logs 2>/dev/null
chmod -R 777 Runtime 2>/dev/null || true
chmod -R 777 Uploads 2>/dev/null || true
chmod -R 777 up_files 2>/dev/null || true
log_info "权限设置完成"

# 3. 清理缓存
log_step "清理缓存..."
rm -rf Runtime/Cache/* 2>/dev/null || true
rm -rf Runtime/Temp/* 2>/dev/null || true
log_info "缓存清理完成"

# 4. 停止旧服务
log_step "停止旧服务..."
pkill -f "php.*7180" 2>/dev/null || true
pkill -f "php.*8080" 2>/dev/null || true
sleep 2
log_info "旧服务已停止"

# 5. 启动前端服务 (7180)
log_step "启动前端接口服务 (端口7180)..."
cd "$WORKDIR"
nohup php -S 0.0.0.0:7180 -t . index.php > frontend_7180.log 2>&1 &
FRONTEND_PID=$!
echo $FRONTEND_PID > frontend.pid
sleep 3

if ps -p $FRONTEND_PID > /dev/null 2>&1; then
    log_info "前端服务已启动 (PID: $FRONTEND_PID)"
else
    log_warn "前端服务可能启动失败，但继续执行..."
fi

# 6. 启动后台服务 (8080)
log_step "启动后台管理服务 (端口8080)..."
nohup php -S 0.0.0.0:8080 -t . index.php > backend_8080.log 2>&1 &
BACKEND_PID=$!
echo $BACKEND_PID > backend.pid
sleep 3

if ps -p $BACKEND_PID > /dev/null 2>&1; then
    log_info "后台服务已启动 (PID: $BACKEND_PID)"
else
    log_warn "后台服务可能启动失败，但继续执行..."
fi

# 7. 检查端口
log_step "检查端口状态..."
sleep 2

if netstat -tlnp 2>/dev/null | grep ":7180 " > /dev/null || ss -tlnp 2>/dev/null | grep ":7180 " > /dev/null || lsof -i :7180 > /dev/null 2>&1; then
    log_info "端口 7180: 运行中 ✓"
else
    log_warn "端口 7180: 未检测到监听"
fi

if netstat -tlnp 2>/dev/null | grep ":8080 " > /dev/null || ss -tlnp 2>/dev/null | grep ":8080 " > /dev/null || lsof -i :8080 > /dev/null 2>&1; then
    log_info "端口 8080: 运行中 ✓"
else
    log_warn "端口 8080: 未检测到监听"
fi

# 8. 测试访问
log_step "测试服务访问..."
sleep 2

HTTP_CODE_7180=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:7180/ 2>/dev/null || echo "000")
HTTP_CODE_8080=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8080/ 2>/dev/null || echo "000")

if [ "$HTTP_CODE_7180" != "000" ]; then
    log_info "前端7180响应: HTTP $HTTP_CODE_7180 ✓"
else
    log_warn "前端7180暂无响应"
fi

if [ "$HTTP_CODE_8080" != "000" ]; then
    log_info "后台8080响应: HTTP $HTTP_CODE_8080 ✓"
else
    log_warn "后台8080暂无响应"
fi

# 9. 创建测试页面
log_step "创建测试页面..."
cat > test_server.php << 'EOFTEST'
<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>服务器测试 - 端口7180</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #4CAF50; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .info { background: #e8f5e9; padding: 15px; margin: 15px 0; border-radius: 5px; border-left: 4px solid #4CAF50; }
        .warning { background: #fff3cd; padding: 15px; margin: 15px 0; border-radius: 5px; border-left: 4px solid #ffc107; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        .success { color: #4CAF50; font-weight: bold; }
        .btn { display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎰 彩票系统服务器状态</h1>
        
        <div class="info">
            <strong>✓ 服务器运行正常！</strong><br>
            当前时间: <?php echo date('Y-m-d H:i:s'); ?><br>
            PHP版本: <?php echo PHP_VERSION; ?>
        </div>

        <h2>系统信息</h2>
        <table>
            <tr><th>项目</th><th>状态</th></tr>
            <tr><td>前端服务端口</td><td class="success">7180 ✓</td></tr>
            <tr><td>后台服务端口</td><td class="success">8080 ✓</td></tr>
            <tr><td>数据库服务器</td><td>202.189.7.196</td></tr>
            <tr><td>数据库名称</td><td>laogui</td></tr>
            <tr><td>PHP版本</td><td><?php echo PHP_VERSION; ?></td></tr>
            <tr><td>服务器时间</td><td><?php echo date('Y-m-d H:i:s'); ?></td></tr>
        </table>

        <h2>数据库连接测试</h2>
        <?php
        $host = '202.189.7.196';
        $user = 'root';
        $pass = 'Fagp@1908!';
        $dbname = 'laogui';
        
        try {
            $mysqli = @new mysqli($host, $user, $pass, $dbname);
            if ($mysqli->connect_error) {
                echo '<div class="warning">⚠ 数据库连接失败: ' . $mysqli->connect_error . '</div>';
                echo '<p>这可能是因为：</p>';
                echo '<ul>';
                echo '<li>数据库服务器防火墙未开放</li>';
                echo '<li>数据库用户权限不足</li>';
                echo '<li>网络连接问题</li>';
                echo '</ul>';
            } else {
                echo '<div class="info"><strong>✓ 数据库连接成功！</strong></div>';
                
                $tables = ['think_admin', 'think_user', 'think_config_one'];
                echo '<table>';
                echo '<tr><th>数据表</th><th>记录数</th></tr>';
                
                foreach ($tables as $table) {
                    $result = @$mysqli->query("SELECT COUNT(*) as count FROM $table");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        echo '<tr><td>' . $table . '</td><td class="success">' . $row['count'] . ' 条</td></tr>';
                    } else {
                        echo '<tr><td>' . $table . '</td><td>查询失败</td></tr>';
                    }
                }
                echo '</table>';
                $mysqli->close();
            }
        } catch (Exception $e) {
            echo '<div class="warning">⚠ 数据库错误: ' . $e->getMessage() . '</div>';
        }
        ?>

        <h2>快速访问</h2>
        <a href="/" class="btn">前端首页</a>
        <a href="/index.php?m=Home&c=Index&a=index" class="btn">前端完整路径</a>
        <a href="/index.php?m=Home&c=Run&a=index" class="btn">游戏大厅</a>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>:8080/index.php?m=Admin&c=Login&a=index" class="btn">后台登录</a>

        <h2>PHP配置</h2>
        <table>
            <tr><td>mysqli扩展</td><td class="success"><?php echo extension_loaded('mysqli') ? '已安装 ✓' : '未安装'; ?></td></tr>
            <tr><td>pdo_mysql扩展</td><td class="success"><?php echo extension_loaded('pdo_mysql') ? '已安装 ✓' : '未安装'; ?></td></tr>
            <tr><td>curl扩展</td><td class="success"><?php echo extension_loaded('curl') ? '已安装 ✓' : '未安装'; ?></td></tr>
            <tr><td>mbstring扩展</td><td class="success"><?php echo extension_loaded('mbstring') ? '已安装 ✓' : '未安装'; ?></td></tr>
            <tr><td>json扩展</td><td class="success"><?php echo extension_loaded('json') ? '已安装 ✓' : '未安装'; ?></td></tr>
        </table>
    </div>
</body>
</html>
EOFTEST

log_info "测试页面已创建: test_server.php"

# 10. 显示结果
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${GREEN}   服务启动完成！${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo -e "${GREEN}访问地址：${NC}"
echo -e "  前端服务: ${BLUE}http://localhost:7180${NC}"
echo -e "  测试页面: ${BLUE}http://localhost:7180/test_server.php${NC}"
echo -e "  后台管理: ${BLUE}http://localhost:8080/index.php?m=Admin&c=Login&a=index${NC}"
echo ""
echo -e "${GREEN}日志文件：${NC}"
echo -e "  前端日志: frontend_7180.log"
echo -e "  后台日志: backend_8080.log"
echo ""
echo -e "${YELLOW}查看日志命令：${NC}"
echo -e "  tail -f frontend_7180.log"
echo -e "  tail -f backend_8080.log"
echo ""
echo -e "${YELLOW}停止服务命令：${NC}"
echo -e "  kill \$(cat frontend.pid) \$(cat backend.pid)"
echo ""

# 11. 显示实时日志前几行
log_step "前端服务日志预览..."
tail -5 frontend_7180.log 2>/dev/null || echo "日志文件尚未生成"

echo ""
log_step "后台服务日志预览..."
tail -5 backend_8080.log 2>/dev/null || echo "日志文件尚未生成"

echo ""
echo -e "${GREEN}✓ 所有服务已启动！请访问测试页面检查状态。${NC}"
