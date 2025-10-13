<?php
/**
 * 数据库权限诊断工具
 * 专门用于诊断和修复数据库权限问题
 */

// 数据库配置
$config = array(
    'host'     => 'localhost',
    'username' => 'laogui',
    'password' => '123456',
    'database' => 'laogui',
    'port'     => 3306,
    'charset'  => 'utf8'
);

echo "<h1>数据库权限诊断工具</h1>";
echo "<hr>";

// 首先尝试以root用户连接，检查权限设置
echo "<h2>1. 权限诊断</h2>";

// 测试基本连接
try {
    echo "<h3>连接测试</h3>";
    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], '', $config['port']);
    
    if ($mysqli->connect_error) {
        echo "<p style='color:red'>❌ 连接失败: " . $mysqli->connect_error . "</p>";
        echo "<div style='background:#ffe6e6;padding:15px;border-left:4px solid #ff4444;margin:10px 0;'>";
        echo "<h4>解决方案:</h4>";
        echo "<ol>";
        echo "<li>以root用户登录MySQL</li>";
        echo "<li>执行以下命令创建用户和数据库:</li>";
        echo "</ol>";
        echo "<code style='display:block;background:#f5f5f5;padding:10px;margin:10px 0;'>";
        echo "CREATE DATABASE IF NOT EXISTS `laogui` CHARACTER SET utf8 COLLATE utf8_general_ci;<br>";
        echo "CREATE USER 'laogui'@'localhost' IDENTIFIED BY '123456';<br>";
        echo "GRANT ALL PRIVILEGES ON `laogui`.* TO 'laogui'@'localhost';<br>";
        echo "GRANT SELECT ON `information_schema`.* TO 'laogui'@'localhost';<br>";
        echo "FLUSH PRIVILEGES;";
        echo "</code>";
        echo "</div>";
        die();
    }
    
    echo "<p style='color:green'>✅ 基本连接成功</p>";
    
    // 检查用户权限
    echo "<h3>权限检查</h3>";
    $result = $mysqli->query("SHOW GRANTS FOR 'laogui'@'localhost'");
    if ($result) {
        echo "<p style='color:green'>✅ 可以查看用户权限</p>";
        echo "<div style='background:#e6ffe6;padding:15px;border-left:4px solid #44ff44;margin:10px 0;'>";
        echo "<h4>当前权限:</h4>";
        while ($row = $result->fetch_array()) {
            echo "<code>" . htmlspecialchars($row[0]) . "</code><br>";
        }
        echo "</div>";
    } else {
        echo "<p style='color:red'>❌ 无法查看用户权限: " . $mysqli->error . "</p>";
    }
    
    // 检查数据库是否存在
    echo "<h3>数据库检查</h3>";
    $result = $mysqli->query("SHOW DATABASES LIKE '{$config['database']}'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green'>✅ 数据库 '{$config['database']}' 存在</p>";
        
        // 尝试选择数据库
        if ($mysqli->select_db($config['database'])) {
            echo "<p style='color:green'>✅ 可以访问数据库</p>";
            
            // 测试权限
            echo "<h3>权限测试</h3>";
            
            // 测试SELECT权限
            $result = $mysqli->query("SELECT 1 as test");
            if ($result) {
                echo "<p style='color:green'>✅ SELECT权限正常</p>";
            } else {
                echo "<p style='color:red'>❌ SELECT权限问题: " . $mysqli->error . "</p>";
            }
            
            // 测试SHOW TABLES权限
            $result = $mysqli->query("SHOW TABLES");
            if ($result) {
                echo "<p style='color:green'>✅ SHOW TABLES权限正常</p>";
                echo "<p>表数量: " . $result->num_rows . "</p>";
                if ($result->num_rows > 0) {
                    echo "<div style='background:#f0f8ff;padding:15px;border-left:4px solid #4488ff;margin:10px 0;'>";
                    echo "<h4>数据表列表:</h4>";
                    while ($row = $result->fetch_array()) {
                        echo "<li>" . $row[0] . "</li>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p style='color:red'>❌ SHOW TABLES权限问题: " . $mysqli->error . "</p>";
            }
            
            // 测试DESCRIBE权限（这是导致错误的关键）
            $result = $mysqli->query("SHOW TABLES LIMIT 1");
            if ($result && $result->num_rows > 0) {
                $table = $result->fetch_array()[0];
                $result2 = $mysqli->query("DESCRIBE `$table`");
                if ($result2) {
                    echo "<p style='color:green'>✅ DESCRIBE权限正常</p>";
                } else {
                    echo "<p style='color:red'>❌ DESCRIBE权限问题: " . $mysqli->error . "</p>";
                    echo "<div style='background:#ffe6e6;padding:15px;border-left:4px solid #ff4444;margin:10px 0;'>";
                    echo "<h4>这是ThinkPHP错误的根本原因！</h4>";
                    echo "<p>需要授予INFORMATION_SCHEMA的SELECT权限:</p>";
                    echo "<code>GRANT SELECT ON information_schema.* TO 'laogui'@'localhost';</code>";
                    echo "</div>";
                }
            }
            
        } else {
            echo "<p style='color:red'>❌ 无法访问数据库: " . $mysqli->error . "</p>";
        }
        
    } else {
        echo "<p style='color:red'>❌ 数据库 '{$config['database']}' 不存在</p>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ 异常: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>2. 完整解决方案</h2>";
echo "<div style='background:#fff3cd;padding:20px;border-left:4px solid #ffc107;margin:15px 0;'>";
echo "<h3>请以MySQL root用户执行以下命令:</h3>";
echo "<textarea style='width:100%;height:200px;font-family:monospace;font-size:12px;'>";
echo "-- 1. 删除可能有问题的用户
DROP USER IF EXISTS 'laogui'@'localhost';

-- 2. 重新创建用户
CREATE USER 'laogui'@'localhost' IDENTIFIED BY '123456';

-- 3. 创建数据库
CREATE DATABASE IF NOT EXISTS `laogui` CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 4. 授予数据库完整权限
GRANT ALL PRIVILEGES ON `laogui`.* TO 'laogui'@'localhost';

-- 5. 授予information_schema的SELECT权限（关键！）
GRANT SELECT ON `information_schema`.* TO 'laogui'@'localhost';

-- 6. 刷新权限
FLUSH PRIVILEGES;

-- 7. 验证权限
SHOW GRANTS FOR 'laogui'@'localhost';";
echo "</textarea>";
echo "</div>";

echo "<h2>3. 执行后验证</h2>";
echo "<p>执行上述SQL后，刷新此页面检查权限是否修复。</p>";
echo "<p>如果权限正常，ThinkPHP应用就可以正常访问了。</p>";

echo "<hr>";
echo "<p style='color:#666;font-size:12px;'>诊断完成时间: " . date('Y-m-d H:i:s') . "</p>";
?>