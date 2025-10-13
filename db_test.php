<?php
/**
 * 数据库连接测试文件
 * 用于验证数据库配置是否正确
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

echo "<h2>数据库连接测试</h2>";
echo "<hr>";

// 测试MySQL连接
echo "<h3>1. 测试MySQL基础连接</h3>";
try {
    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], '', $config['port']);
    
    if ($mysqli->connect_error) {
        echo "<p style='color:red'>❌ MySQL连接失败: " . $mysqli->connect_error . "</p>";
        echo "<p><strong>可能的解决方案:</strong></p>";
        echo "<ul>";
        echo "<li>检查MySQL服务是否启动</li>";
        echo "<li>检查用户名和密码是否正确</li>";
        echo "<li>检查服务器地址和端口</li>";
        echo "</ul>";
    } else {
        echo "<p style='color:green'>✅ MySQL连接成功!</p>";
        echo "<p>MySQL版本: " . $mysqli->server_info . "</p>";
        
        // 测试数据库是否存在
        echo "<h3>2. 测试数据库是否存在</h3>";
        $result = $mysqli->query("SHOW DATABASES LIKE '{$config['database']}'");
        if ($result && $result->num_rows > 0) {
            echo "<p style='color:green'>✅ 数据库 '{$config['database']}' 存在</p>";
            
            // 选择数据库
            $mysqli->select_db($config['database']);
            
            // 检查表是否存在
            echo "<h3>3. 检查数据表</h3>";
            $tables = $mysqli->query("SHOW TABLES LIKE 'think_%'");
            if ($tables && $tables->num_rows > 0) {
                echo "<p style='color:green'>✅ 找到 " . $tables->num_rows . " 个数据表</p>";
                echo "<p><strong>表列表:</strong></p>";
                echo "<ul>";
                while ($row = $tables->fetch_array()) {
                    echo "<li>" . $row[0] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color:orange'>⚠️ 未找到数据表，需要导入数据库结构</p>";
                echo "<p><strong>解决方案:</strong></p>";
                echo "<ul>";
                echo "<li>导入数据库SQL文件</li>";
                echo "<li>或运行数据库初始化脚本</li>";
                echo "</ul>";
            }
            
        } else {
            echo "<p style='color:red'>❌ 数据库 '{$config['database']}' 不存在</p>";
            echo "<p><strong>解决方案:</strong></p>";
            echo "<p>创建数据库:</p>";
            echo "<code>CREATE DATABASE {$config['database']} CHARACTER SET utf8 COLLATE utf8_general_ci;</code>";
            
            // 尝试创建数据库
            if ($mysqli->query("CREATE DATABASE {$config['database']} CHARACTER SET utf8 COLLATE utf8_general_ci")) {
                echo "<p style='color:green'>✅ 数据库创建成功!</p>";
            } else {
                echo "<p style='color:red'>❌ 数据库创建失败: " . $mysqli->error . "</p>";
            }
        }
    }
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ 连接异常: " . $e->getMessage() . "</p>";
}

// 测试PDO连接
echo "<hr>";
echo "<h3>4. 测试PDO连接 (ThinkPHP使用)</h3>";
try {
    $dsn = "mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✅ PDO连接成功!</p>";
    
    // 测试选择数据库
    $pdo->exec("USE {$config['database']}");
    echo "<p style='color:green'>✅ 数据库选择成功!</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ PDO连接失败: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>5. PHP扩展检查</h3>";
echo "<p>MySQL扩展: " . (extension_loaded('mysql') ? '✅ 已安装' : '❌ 未安装') . "</p>";
echo "<p>MySQLi扩展: " . (extension_loaded('mysqli') ? '✅ 已安装' : '❌ 未安装') . "</p>";
echo "<p>PDO扩展: " . (extension_loaded('pdo') ? '✅ 已安装' : '❌ 未安装') . "</p>";
echo "<p>PDO_MySQL扩展: " . (extension_loaded('pdo_mysql') ? '✅ 已安装' : '❌ 未安装') . "</p>";

echo "<hr>";
echo "<p><strong>如果数据库连接成功，请删除此测试文件以确保安全!</strong></p>";
echo "<p>文件位置: " . __FILE__ . "</p>";
?>