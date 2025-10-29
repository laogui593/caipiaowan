#!/bin/bash

# 彩票系统启动脚本
# 前端接口: 7180 (支持 /load/initial 等API)
# 后台管理: 7170

set +e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

WORKDIR=$(pwd)
FRONTEND_PORT=7180
BACKEND_PORT=7170

log_info() { echo -e "${GREEN}[✓]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[!]${NC} $1"; }
log_error() { echo -e "${RED}[✗]${NC} $1"; }
log_step() { echo -e "${BLUE}[→]${NC} $1"; }

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   彩票系统完整部署${NC}"
echo -e "${BLUE}   前端API: 7180${NC}"
echo -e "${BLUE}   后台管理: 7170${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# 停止旧服务
log_step "停止旧服务..."
pkill -f "php.*7180" 2>/dev/null || true
pkill -f "php.*7170" 2>/dev/null || true
pkill -f "php.*8080" 2>/dev/null || true
sleep 2
log_info "旧服务已停止"

# 设置权限和清理
log_step "设置权限和清理缓存..."
mkdir -p Runtime/Cache Runtime/Temp Runtime/Logs 2>/dev/null
chmod -R 777 Runtime 2>/dev/null || true
rm -rf Runtime/Cache/* Runtime/Temp/* 2>/dev/null || true
log_info "完成"

# 启动前端API服务 (7180)
log_step "启动前端API服务 (端口7180)..."
cd "$WORKDIR"
nohup php -S 0.0.0.0:7180 -t . > frontend_7180.log 2>&1 &
FRONTEND_PID=$!
echo $FRONTEND_PID > frontend_7180.pid
sleep 3

if ps -p $FRONTEND_PID > /dev/null 2>&1; then
    log_info "前端API服务已启动 (PID: $FRONTEND_PID, 端口: 7180)"
else
    log_error "前端API服务启动失败"
fi

# 启动后台管理服务 (7170)
log_step "启动后台管理服务 (端口7170)..."
nohup php -S 0.0.0.0:7170 -t . > backend_7170.log 2>&1 &
BACKEND_PID=$!
echo $BACKEND_PID > backend_7170.pid
sleep 3

if ps -p $BACKEND_PID > /dev/null 2>&1; then
    log_info "后台管理服务已启动 (PID: $BACKEND_PID, 端口: 7170)"
else
    log_error "后台管理服务启动失败"
fi

# 检查端口
log_step "检查端口状态..."
sleep 2

check_port() {
    local port=$1
    if netstat -tlnp 2>/dev/null | grep ":$port " > /dev/null || \
       ss -tlnp 2>/dev/null | grep ":$port " > /dev/null || \
       lsof -i :$port > /dev/null 2>&1; then
        return 0
    else
        return 1
    fi
}

if check_port 7180; then
    log_info "端口 7180: ✓ 运行中"
else
    log_warn "端口 7180: 未检测到"
fi

if check_port 7170; then
    log_info "端口 7170: ✓ 运行中"
else
    log_warn "端口 7170: 未检测到"
fi

# 测试API访问
log_step "测试API接口..."
sleep 2

# 测试前端API
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:7180/index.php?m=Home&c=Load&a=initial" 2>/dev/null || echo "000")
if [ "$HTTP_CODE" != "000" ]; then
    log_info "前端API /load/initial 响应: HTTP $HTTP_CODE"
else
    log_warn "前端API暂无响应，可能需要数据库连接"
fi

# 测试后台
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:7170/index.php?m=Admin&c=Login&a=index" 2>/dev/null || echo "000")
if [ "$HTTP_CODE" != "000" ]; then
    log_info "后台管理响应: HTTP $HTTP_CODE"
else
    log_warn "后台暂无响应"
fi

# 创建API测试页面
log_step "创建API测试页面..."
cat > api_test_page.html << 'EOFHTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>API测试 - 7180端口</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f0f0f0; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .test-btn { background: #4CAF50; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin: 10px 5px; }
        .test-btn:hover { background: #45a049; }
        .result { background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 5px; border: 1px solid #ddd; }
        pre { background: #272822; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .success { color: #4CAF50; font-weight: bold; }
        .error { color: #f44336; font-weight: bold; }
        .info-box { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196F3; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎰 彩票系统API测试</h1>
        
        <div class="info-box">
            <strong>系统配置：</strong><br>
            前端API端口: <strong>7180</strong> (支持 /load/initial 等接口)<br>
            后台管理端口: <strong>7170</strong><br>
            数据库服务器: <strong>202.189.7.196</strong>
        </div>

        <h2>1. 测试 /load/initial 接口</h2>
        <button class="test-btn" onclick="testLoadInitial()">测试 /load/initial</button>
        <div id="load-initial-result" class="result"></div>

        <h2>2. 测试其他API接口</h2>
        <button class="test-btn" onclick="testApiIndex()">测试 API Index</button>
        <button class="test-btn" onclick="testGameList()">测试游戏列表</button>
        <div id="api-result" class="result"></div>

        <h2>3. 访问链接</h2>
        <div>
            <a href="http://localhost:7180/index.php?m=Home&c=Load&a=initial" target="_blank" class="test-btn">直接访问 /load/initial</a>
            <a href="http://localhost:7180/" target="_blank" class="test-btn">前端首页 (7180)</a>
            <a href="http://localhost:7170/index.php?m=Admin&c=Login&a=index" target="_blank" class="test-btn">后台登录 (7170)</a>
        </div>

        <h2>4. 服务状态</h2>
        <button class="test-btn" onclick="checkStatus()">检查服务状态</button>
        <div id="status-result" class="result"></div>
    </div>

    <script>
        function testLoadInitial() {
            const resultDiv = document.getElementById('load-initial-result');
            resultDiv.innerHTML = '<p>正在测试 /load/initial 接口...</p>';
            
            fetch('http://localhost:7180/index.php?m=Home&c=Load&a=initial')
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 200));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    resultDiv.innerHTML = '<p class="success">✓ 接口响应成功</p><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(error => {
                    resultDiv.innerHTML = '<p class="error">✗ 接口错误</p><pre>' + error.message + '</pre>';
                });
        }

        function testApiIndex() {
            const resultDiv = document.getElementById('api-result');
            resultDiv.innerHTML = '<p>正在测试 API...</p>';
            
            fetch('http://localhost:7180/index.php?m=Home&c=Api&a=index')
                .then(response => response.text())
                .then(data => {
                    if (data.length > 0) {
                        resultDiv.innerHTML = '<p class="success">✓ API响应成功 (' + data.length + ' 字节)</p><pre>' + data.substring(0, 500) + '...</pre>';
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = '<p class="error">✗ 错误: ' + error.message + '</p>';
                });
        }

        function testGameList() {
            const resultDiv = document.getElementById('api-result');
            resultDiv.innerHTML = '<p>正在测试游戏列表...</p>';
            
            fetch('http://localhost:7180/index.php?m=Home&c=Run&a=index')
                .then(response => response.text())
                .then(data => {
                    resultDiv.innerHTML = '<p class="success">✓ 游戏列表响应 (' + data.length + ' 字节)</p>';
                })
                .catch(error => {
                    resultDiv.innerHTML = '<p class="error">✗ 错误: ' + error.message + '</p>';
                });
        }

        function checkStatus() {
            const resultDiv = document.getElementById('status-result');
            const info = {
                '当前时间': new Date().toLocaleString('zh-CN'),
                '前端API端口': '7180',
                '后台管理端口': '7170',
                '浏览器': navigator.userAgent.split(' ').pop()
            };
            resultDiv.innerHTML = '<pre>' + JSON.stringify(info, null, 2) + '</pre>';
        }

        // 页面加载时自动检查
        window.onload = function() {
            checkStatus();
        };
    </script>
</body>
</html>
EOFHTML

log_info "API测试页面已创建: api_test_page.html"

# 显示结果
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${GREEN}   部署完成！${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo -e "${GREEN}✓ 服务地址：${NC}"
echo -e "  前端API: ${BLUE}http://localhost:7180${NC}"
echo -e "  API接口: ${BLUE}http://localhost:7180/index.php?m=Home&c=Load&a=initial${NC}"
echo -e "  后台管理: ${BLUE}http://localhost:7170${NC}"
echo -e "  后台登录: ${BLUE}http://localhost:7170/index.php?m=Admin&c=Login&a=index${NC}"
echo ""
echo -e "${GREEN}✓ 测试页面：${NC}"
echo -e "  ${BLUE}http://localhost:7180/api_test_page.html${NC}"
echo ""
echo -e "${GREEN}✓ 日志文件：${NC}"
echo -e "  前端: frontend_7180.log"
echo -e "  后台: backend_7170.log"
echo ""
echo -e "${YELLOW}管理命令：${NC}"
echo -e "  查看前端日志: tail -f frontend_7180.log"
echo -e "  查看后台日志: tail -f backend_7170.log"
echo -e "  停止所有服务: kill \$(cat frontend_7180.pid) \$(cat backend_7170.pid)"
echo ""
echo -e "${GREEN}✓ 系统已完全启动！${NC}"
