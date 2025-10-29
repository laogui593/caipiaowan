<?php
// 数据库表结构检查脚本
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);

$db_config = array(
    'host' => '202.189.7.196',
    'user' => 'root',
    'pass' => 'Fagp@1908!',
    'name' => 'root',
    'port' => 3306
);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>数据库表检查</title>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 1400px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
table { width: 100%; border-collapse: collapse; margin: 20px 0; }
th { background: #4CAF50; color: white; padding: 12px; text-align: left; }
td { padding: 10px; border-bottom: 1px solid #ddd; }
tr:hover { background: #f5f5f5; }
.success { color: #4CAF50; font-weight: bold; }
.error { color: #f44336; font-weight: bold; }
.info { background: #e3f2fd; padding: 15px; margin: 15px 0; border-left: 4px solid #2196F3; }
pre { background: #f9f9f9; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style></head><body><div class='container'>";

echo "<h1>🗄️ 数据库表结构检查</h1>";

try {
    ini_set('default_socket_timeout', 5);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    $mysqli = @new mysqli(
        $db_config['host'], 
        $db_config['user'], 
        $db_config['pass'], 
        $db_config['name'],
        $db_config['port']
    );
    
    if ($mysqli->connect_error) {
        throw new Exception($mysqli->connect_error);
    }
    
    $mysqli->set_charset("utf8");
    
    echo "<div class='info'><strong>✓ 数据库连接成功！</strong><br>";
    echo "服务器: {$db_config['host']}<br>";
    echo "数据库: {$db_config['name']}</div>";
    
    // 获取所有表
    echo "<h2>📋 数据表列表</h2>";
    $result = $mysqli->query("SHOW TABLES");
    
    if ($result) {
        $tables = array();
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
        
        echo "<p>共找到 <strong>" . count($tables) . "</strong> 个数据表</p>";
        echo "<table>";
        echo "<tr><th>序号</th><th>表名</th><th>记录数</th><th>操作</th></tr>";
        
        $index = 1;
        foreach ($tables as $table) {
            // 获取记录数
            $count_result = $mysqli->query("SELECT COUNT(*) as count FROM `$table`");
            $count = 0;
            if ($count_result) {
                $count_row = $count_result->fetch_assoc();
                $count = $count_row['count'];
            }
            
            $is_room = (stripos($table, 'room') !== false || stripos($table, '房间') !== false);
            $highlight = $is_room ? "style='background: #fff3cd; font-weight: bold;'" : "";
            
            echo "<tr $highlight>";
            echo "<td>$index</td>";
            echo "<td>$table" . ($is_room ? " 🏠" : "") . "</td>";
            echo "<td><strong>$count</strong> 条</td>";
            echo "<td><a href='?view=$table'>查看数据</a></td>";
            echo "</tr>";
            $index++;
        }
        
        echo "</table>";
        
        // 如果有查看请求
        if (isset($_GET['view']) && in_array($_GET['view'], $tables)) {
            $view_table = $_GET['view'];
            echo "<h2>📊 表数据: $view_table</h2>";
            
            $data_result = $mysqli->query("SELECT * FROM `$view_table` LIMIT 20");
            if ($data_result && $data_result->num_rows > 0) {
                echo "<p>显示前20条记录：</p>";
                echo "<table>";
                
                // 表头
                $fields = $data_result->fetch_fields();
                echo "<tr>";
                foreach ($fields as $field) {
                    echo "<th>{$field->name}</th>";
                }
                echo "</tr>";
                
                // 数据
                while ($data_row = $data_result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($data_row as $value) {
                        $display_value = strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                        echo "<td>" . htmlspecialchars($display_value) . "</td>";
                    }
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "<p>该表没有数据或为空表。</p>";
            }
        }
        
        // 查找房间相关的表
        echo "<h2>🏠 房间相关的表</h2>";
        $room_tables = array_filter($tables, function($table) {
            return stripos($table, 'room') !== false || stripos($table, '房间') !== false;
        });
        
        if (empty($room_tables)) {
            echo "<p class='error'>未找到包含 'room' 或 '房间' 关键字的表。</p>";
            echo "<p>可能的房间管理相关表：</p>";
            echo "<ul>";
            $possible = array('think_lottery', 'think_game', 'think_config', 'think_yushe');
            foreach ($tables as $table) {
                foreach ($possible as $keyword) {
                    if (stripos($table, str_replace('think_', '', $keyword)) !== false) {
                        $count_result = $mysqli->query("SELECT COUNT(*) as count FROM `$table`");
                        $count = 0;
                        if ($count_result) {
                            $count_row = $count_result->fetch_assoc();
                            $count = $count_row['count'];
                        }
                        echo "<li><strong>$table</strong>: $count 条记录 <a href='?view=$table'>[查看]</a></li>";
                    }
                }
            }
            echo "</ul>";
        } else {
            echo "<ul>";
            foreach ($room_tables as $table) {
                $count_result = $mysqli->query("SELECT COUNT(*) as count FROM `$table`");
                $count = 0;
                if ($count_result) {
                    $count_row = $count_result->fetch_assoc();
                    $count = $count_row['count'];
                }
                echo "<li class='success'><strong>$table</strong>: $count 条记录 <a href='?view=$table'>[查看数据]</a></li>";
            }
            echo "</ul>";
        }
        
    } else {
        echo "<p class='error'>无法获取表列表</p>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<div class='error'><strong>✗ 数据库错误</strong><br>";
    echo "错误信息: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "</div></body></html>";
