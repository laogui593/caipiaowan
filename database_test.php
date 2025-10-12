<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>数据库连接和接口测试</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        h2 {
            color: #666;
            margin-top: 30px;
        }
        .test-item {
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fafafa;
        }
        .success {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }
        .info {
            background: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 5px;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-error { background: #dc3545; color: white; }
        .badge-warning { background: #ffc107; color: black; }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 数据库连接和接口测试报告</h1>
        <p><strong>测试时间:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        
        <?php
        // 引入 ThinkPHP
        define('APP_PATH', './Application/');
        define('THINK_PATH', './ThinkPHP/');
        define('RUNTIME_PATH', './Application/Runtime/');
        define('APP_DEBUG', true);
        
        // 测试结果统计
        $tests = array(
            'total' => 0,
            'passed' => 0,
            'failed' => 0,
            'warning' => 0
        );
        
        echo "<h2>1. PHP 环境检查</h2>";
        
        // PHP 版本
        $tests['total']++;
        $phpVersion = PHP_VERSION;
        if (version_compare($phpVersion, '5.3.0', '>=')) {
            $tests['passed']++;
            echo "<div class='test-item success'>";
            echo "<span class='badge badge-success'>✓ 通过</span>";
            echo "<strong>PHP 版本:</strong> {$phpVersion} (要求 >= 5.3.0)";
            echo "</div>";
        } else {
            $tests['failed']++;
            echo "<div class='test-item error'>";
            echo "<span class='badge badge-error'>✗ 失败</span>";
            echo "<strong>PHP 版本:</strong> {$phpVersion} (要求 >= 5.3.0)";
            echo "</div>";
        }
        
        // PHP 扩展检查
        $required_extensions = array('mysqli', 'pdo', 'pdo_mysql', 'json', 'mbstring', 'curl');
        echo "<div class='test-item info'>";
        echo "<strong>PHP 扩展检查:</strong><br>";
        foreach ($required_extensions as $ext) {
            $tests['total']++;
            if (extension_loaded($ext)) {
                $tests['passed']++;
                echo "<span class='badge badge-success'>✓</span> {$ext}<br>";
            } else {
                $tests['failed']++;
                echo "<span class='badge badge-error'>✗</span> {$ext} (未安装)<br>";
            }
        }
        echo "</div>";
        
        echo "<h2>2. 数据库配置检查</h2>";
        
        // 检查配置文件
        $db_config_file = './Application/Common/Conf/db.php';
        $tests['total']++;
        if (file_exists($db_config_file)) {
            $tests['passed']++;
            echo "<div class='test-item success'>";
            echo "<span class='badge badge-success'>✓ 通过</span>";
            echo "<strong>数据库配置文件存在:</strong> {$db_config_file}";
            echo "</div>";
            
            // 读取配置
            $db_config = include $db_config_file;
            echo "<div class='test-item info'>";
            echo "<strong>当前数据库配置:</strong><br>";
            echo "<table>";
            echo "<tr><th>配置项</th><th>值</th></tr>";
            echo "<tr><td>数据库类型</td><td>" . (isset($db_config['DB_TYPE']) ? $db_config['DB_TYPE'] : '未配置') . "</td></tr>";
            echo "<tr><td>服务器地址</td><td>" . (isset($db_config['DB_HOST']) ? $db_config['DB_HOST'] : '未配置') . "</td></tr>";
            echo "<tr><td>数据库名</td><td>" . (isset($db_config['DB_NAME']) ? $db_config['DB_NAME'] : '未配置') . "</td></tr>";
            echo "<tr><td>用户名</td><td>" . (isset($db_config['DB_USER']) ? $db_config['DB_USER'] : '未配置') . "</td></tr>";
            echo "<tr><td>端口</td><td>" . (isset($db_config['DB_PORT']) ? $db_config['DB_PORT'] : '未配置') . "</td></tr>";
            echo "<tr><td>表前缀</td><td>" . (isset($db_config['DB_PREFIX']) ? $db_config['DB_PREFIX'] : '未配置') . "</td></tr>";
            echo "</table>";
            echo "</div>";
            
            // 测试数据库连接
            $tests['total']++;
            try {
                $dsn = "mysql:host=" . $db_config['DB_HOST'] . ";port=" . $db_config['DB_PORT'];
                $pdo = new PDO($dsn, $db_config['DB_USER'], $db_config['DB_PWD']);
                $tests['passed']++;
                echo "<div class='test-item success'>";
                echo "<span class='badge badge-success'>✓ 通过</span>";
                echo "<strong>数据库服务器连接成功</strong>";
                echo "</div>";
                
                // 检查数据库是否存在
                $tests['total']++;
                $stmt = $pdo->query("SHOW DATABASES LIKE '" . $db_config['DB_NAME'] . "'");
                if ($stmt->rowCount() > 0) {
                    $tests['passed']++;
                    echo "<div class='test-item success'>";
                    echo "<span class='badge badge-success'>✓ 通过</span>";
                    echo "<strong>数据库存在:</strong> " . $db_config['DB_NAME'];
                    echo "</div>";
                    
                    // 连接到具体数据库并检查表
                    $pdo = new PDO(
                        "mysql:host=" . $db_config['DB_HOST'] . ";port=" . $db_config['DB_PORT'] . ";dbname=" . $db_config['DB_NAME'],
                        $db_config['DB_USER'],
                        $db_config['DB_PWD']
                    );
                    
                    // 检查关键数据表
                    $required_tables = array('admin', 'user', 'order', 'config');
                    echo "<div class='test-item info'>";
                    echo "<strong>数据表检查:</strong><br>";
                    foreach ($required_tables as $table) {
                        $tests['total']++;
                        $full_table_name = $db_config['DB_PREFIX'] . $table;
                        $stmt = $pdo->query("SHOW TABLES LIKE '{$full_table_name}'");
                        if ($stmt->rowCount() > 0) {
                            $tests['passed']++;
                            echo "<span class='badge badge-success'>✓</span> {$full_table_name}<br>";
                        } else {
                            $tests['warning']++;
                            echo "<span class='badge badge-warning'>!</span> {$full_table_name} (不存在)<br>";
                        }
                    }
                    echo "</div>";
                } else {
                    $tests['warning']++;
                    echo "<div class='test-item warning'>";
                    echo "<span class='badge badge-warning'>! 警告</span>";
                    echo "<strong>数据库不存在:</strong> " . $db_config['DB_NAME'] . " (需要创建)";
                    echo "</div>";
                }
            } catch (PDOException $e) {
                $tests['failed']++;
                echo "<div class='test-item error'>";
                echo "<span class='badge badge-error'>✗ 失败</span>";
                echo "<strong>数据库连接失败:</strong> " . $e->getMessage();
                echo "</div>";
            }
        } else {
            $tests['failed']++;
            echo "<div class='test-item error'>";
            echo "<span class='badge badge-error'>✗ 失败</span>";
            echo "<strong>数据库配置文件不存在:</strong> {$db_config_file}";
            echo "<p>请创建此文件并配置数据库连接信息。</p>";
            echo "</div>";
        }
        
        echo "<h2>3. 接口配置检查</h2>";
        
        // 检查 site.php 配置
        $site_config_file = './Application/Common/Conf/site.php';
        $tests['total']++;
        if (file_exists($site_config_file)) {
            $tests['passed']++;
            $site_config = include $site_config_file;
            
            echo "<div class='test-item success'>";
            echo "<span class='badge badge-success'>✓ 通过</span>";
            echo "<strong>站点配置文件存在</strong>";
            echo "</div>";
            
            // 检查第三方 API 配置
            echo "<div class='test-item info'>";
            echo "<strong>第三方 API 配置:</strong><br>";
            $api_configs = array(
                '幸运飞艇_api' => '幸运飞艇采集接口',
                'xyft_api' => '幸运飞艇(2)采集接口',
                'ssc_api' => '时时彩采集接口',
                'bj28_api' => '北京28采集接口',
                'jnd28_api' => '加拿大28采集接口'
            );
            
            foreach ($api_configs as $key => $name) {
                if (isset($site_config[$key]) && !empty($site_config[$key])) {
                    echo "<span class='badge badge-success'>✓</span> {$name}: {$site_config[$key]}<br>";
                } else {
                    echo "<span class='badge badge-warning'>!</span> {$name}: 未配置<br>";
                }
            }
            echo "</div>";
            
            // 微信支付配置
            if (isset($site_config['WEIXINPAY_CONFIG'])) {
                echo "<div class='test-item info'>";
                echo "<strong>微信支付配置:</strong><br>";
                $wx_config = $site_config['WEIXINPAY_CONFIG'];
                echo "APPID: " . (isset($wx_config['APPID']) ? $wx_config['APPID'] : '未配置') . "<br>";
                echo "APPSECRET: " . (isset($wx_config['APPSECRET']) ? '已配置' : '未配置') . "<br>";
                echo "</div>";
            }
        } else {
            $tests['failed']++;
            echo "<div class='test-item error'>";
            echo "<span class='badge badge-error'>✗ 失败</span>";
            echo "<strong>站点配置文件不存在</strong>";
            echo "</div>";
        }
        
        echo "<h2>4. 文件权限检查</h2>";
        
        // 检查关键目录权限
        $writable_dirs = array(
            './Application/Runtime/',
            './Public/upload/'
        );
        
        foreach ($writable_dirs as $dir) {
            $tests['total']++;
            if (is_dir($dir)) {
                if (is_writable($dir)) {
                    $tests['passed']++;
                    echo "<div class='test-item success'>";
                    echo "<span class='badge badge-success'>✓ 通过</span>";
                    echo "<strong>目录可写:</strong> {$dir}";
                    echo "</div>";
                } else {
                    $tests['warning']++;
                    echo "<div class='test-item warning'>";
                    echo "<span class='badge badge-warning'>! 警告</span>";
                    echo "<strong>目录不可写:</strong> {$dir}";
                    echo "</div>";
                }
            } else {
                $tests['warning']++;
                echo "<div class='test-item warning'>";
                echo "<span class='badge badge-warning'>! 警告</span>";
                echo "<strong>目录不存在:</strong> {$dir}";
                echo "</div>";
            }
        }
        
        // 测试总结
        echo "<h2>📊 测试总结</h2>";
        echo "<div class='test-item info'>";
        echo "<table>";
        echo "<tr><th>测试项</th><th>数量</th><th>百分比</th></tr>";
        echo "<tr><td>总测试数</td><td>{$tests['total']}</td><td>100%</td></tr>";
        echo "<tr><td style='color: #28a745;'>通过</td><td>{$tests['passed']}</td><td>" . round($tests['passed']/$tests['total']*100, 1) . "%</td></tr>";
        echo "<tr><td style='color: #ffc107;'>警告</td><td>{$tests['warning']}</td><td>" . round($tests['warning']/$tests['total']*100, 1) . "%</td></tr>";
        echo "<tr><td style='color: #dc3545;'>失败</td><td>{$tests['failed']}</td><td>" . round($tests['failed']/$tests['total']*100, 1) . "%</td></tr>";
        echo "</table>";
        echo "</div>";
        
        // 建议
        echo "<h2>💡 建议</h2>";
        echo "<div class='test-item info'>";
        
        if ($tests['failed'] > 0 || $tests['warning'] > 0) {
            echo "<strong>需要处理的问题:</strong><ul>";
            
            if (!file_exists($db_config_file)) {
                echo "<li>创建并配置数据库配置文件: Application/Common/Conf/db.php</li>";
            }
            
            if ($tests['warning'] > 0) {
                echo "<li>检查并创建缺失的数据表</li>";
                echo "<li>确保关键目录具有写入权限</li>";
            }
            
            echo "<li>测试第三方 API 接口连通性</li>";
            echo "<li>配置微信支付参数（如果使用）</li>";
            echo "</ul>";
        } else {
            echo "<strong>✅ 系统配置完整，所有接口匹配正常！</strong>";
        }
        
        echo "</div>";
        
        echo "<h2>📖 相关文档</h2>";
        echo "<div class='test-item info'>";
        echo "<ul>";
        echo "<li><a href='DATABASE_CONNECTION_TEST.md'>数据库连接和接口验证报告</a></li>";
        echo "<li><a href='BACKEND_LOGIN_FIX_SUMMARY.md'>后台登录修复总结</a></li>";
        echo "<li><a href='PROJECT_STATUS.md'>项目状态报告</a></li>";
        echo "<li><a href='QUICK_REFERENCE.md'>快速参考指南</a></li>";
        echo "</ul>";
        echo "</div>";
        ?>
    </div>
</body>
</html>
