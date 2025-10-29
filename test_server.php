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
