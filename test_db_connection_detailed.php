<?php
header('Content-Type: text/html; charset=utf-8');

$host = '202.189.7.196';
$user = 'root';
$pass = 'Fagp@1908!';
$dbname = 'root';
$port = 3306;

echo "<h1>数据库连接详细测试</h1>";
echo "<pre>";

echo "配置信息：\n";
echo "服务器: $host:$port\n";
echo "数据库: $dbname\n";
echo "用户名: $user\n";
echo "密码: " . str_repeat('*', strlen($pass)) . "\n\n";

echo "测试1: 检查PHP MySQL扩展\n";
echo "mysqli扩展: " . (extension_loaded('mysqli') ? '✓ 已安装' : '✗ 未安装') . "\n";
echo "pdo_mysql扩展: " . (extension_loaded('pdo_mysql') ? '✓ 已安装' : '✗ 未安装') . "\n\n";

echo "测试2: 尝试连接数据库（超时设置：10秒）\n";
ini_set('default_socket_timeout', 10);
ini_set('mysql.connect_timeout', 10);

$start_time = microtime(true);

try {
    echo "正在连接...\n";
    $mysqli = @new mysqli($host, $user, $pass, $dbname, $port);
    
    $connect_time = microtime(true) - $start_time;
    
    if ($mysqli->connect_error) {
        echo "✗ 连接失败\n";
        echo "错误代码: " . $mysqli->connect_errno . "\n";
        echo "错误信息: " . $mysqli->connect_error . "\n";
        echo "连接耗时: " . round($connect_time, 2) . " 秒\n\n";
        
        echo "可能的原因：\n";
        echo "1. 数据库服务器防火墙未开放 3306 端口\n";
        echo "2. MySQL 未配置允许远程连接\n";
        echo "3. 网络连接问题\n";
        echo "4. 数据库用户权限不足\n\n";
        
        echo "建议检查：\n";
        echo "1. 在数据库服务器上执行: firewall-cmd --list-ports\n";
        echo "2. 检查MySQL配置: grep bind-address /etc/my.cnf\n";
        echo "3. 测试网络连通: telnet $host $port\n";
        echo "4. 检查用户权限: SELECT user,host FROM mysql.user WHERE user='root';\n";
        
    } else {
        echo "✓ 连接成功！\n";
        echo "连接耗时: " . round($connect_time, 2) . " 秒\n";
        echo "MySQL版本: " . $mysqli->server_info . "\n\n";
        
        // 测试查询
        echo "测试3: 查询数据库表\n";
        $result = $mysqli->query("SHOW TABLES");
        
        if ($result) {
            $table_count = $result->num_rows;
            echo "✓ 查询成功，共有 $table_count 个表\n\n";
            
            echo "前20个表：\n";
            $index = 1;
            while ($row = $result->fetch_array() and $index <= 20) {
                $table = $row[0];
                
                // 获取表记录数
                $count_result = $mysqli->query("SELECT COUNT(*) as count FROM `$table`");
                if ($count_result) {
                    $count_row = $count_result->fetch_assoc();
                    printf("  %2d. %-40s %8d 条记录\n", $index, $table, $count_row['count']);
                }
                $index++;
            }
            
            if ($table_count > 20) {
                echo "  ... 还有 " . ($table_count - 20) . " 个表\n";
            }
            
            echo "\n测试4: 检查关键数据表\n";
            $key_tables = ['think_admin', 'think_user', 'think_config_one', 'think_lottery', 'think_caiji'];
            foreach ($key_tables as $table) {
                $count_result = $mysqli->query("SELECT COUNT(*) as count FROM `$table`");
                if ($count_result) {
                    $count_row = $count_result->fetch_assoc();
                    echo "  $table: " . $count_row['count'] . " 条记录";
                    
                    if ($count_row['count'] == 0) {
                        echo " ⚠️ 表为空！";
                    } else {
                        echo " ✓";
                    }
                    echo "\n";
                } else {
                    echo "  $table: 表不存在或查询失败\n";
                }
            }
            
        } else {
            echo "✗ 查询失败: " . $mysqli->error . "\n";
        }
        
        $mysqli->close();
    }
    
} catch (Exception $e) {
    $connect_time = microtime(true) - $start_time;
    echo "✗ 异常错误\n";
    echo "错误信息: " . $e->getMessage() . "\n";
    echo "连接耗时: " . round($connect_time, 2) . " 秒\n\n";
    
    if (strpos($e->getMessage(), 'timed out') !== false) {
        echo "诊断：连接超时\n\n";
        echo "这说明：\n";
        echo "1. 网络可能无法到达数据库服务器\n";
        echo "2. 防火墙可能阻止了连接\n";
        echo "3. 数据库服务器可能未运行\n\n";
        
        echo "当前 /load/initial 接口的数据来源：\n";
        echo "由于数据库无法连接，LoadController 返回的是模拟数据\n";
        echo "这就是为什么接口能正常返回数据，但数据是模拟的\n\n";
        
        echo "解决方法：\n";
        echo "1. 在数据库服务器上开放防火墙端口\n";
        echo "2. 配置MySQL允许远程连接\n";
        echo "3. 授权用户远程访问权限\n";
    }
}

echo "</pre>";
