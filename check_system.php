<?php
/**
 * 系统检查脚本
 * 检查多语言和游戏启动功能
 */

echo "=== 彩票系统检查 ===\n\n";

// 1. 检查ThinkPHP框架
echo "1. 检查ThinkPHP框架...\n";
if (file_exists('./ThinkPHP/ThinkPHP.php')) {
    echo "   ✓ ThinkPHP框架存在\n";
} else {
    echo "   ✗ ThinkPHP框架不存在\n";
}

// 2. 检查多语言支持
echo "\n2. 检查多语言支持...\n";
$langFiles = [
    './ThinkPHP/Lang/zh-cn.php' => '简体中文',
    './ThinkPHP/Lang/zh-tw.php' => '繁体中文',
    './ThinkPHP/Lang/en-us.php' => '英文',
];

foreach ($langFiles as $file => $name) {
    if (file_exists($file)) {
        echo "   ✓ {$name} 语言包存在: {$file}\n";
    } else {
        echo "   ✗ {$name} 语言包不存在: {$file}\n";
    }
}

// 3. 检查游戏控制器
echo "\n3. 检查游戏控制器...\n";
$controller = './Application/Home/Controller/RunController.class.php';
if (file_exists($controller)) {
    echo "   ✓ 游戏控制器存在\n";
    
    $content = file_get_contents($controller);
    
    // 检查游戏方法
    $games = [
        'xyft' => '幸运飞艇',
        'ssc' => '重庆时时彩',
    ];
    
    echo "\n   检查游戏方法:\n";
    foreach ($games as $method => $name) {
        if (preg_match('/public\s+function\s+' . $method . '\s*\(/', $content)) {
            echo "   ✓ {$name} 方法 ({$method}) 存在\n";
        } else {
            echo "   ✗ {$name} 方法 ({$method}) 不存在\n";
        }
    }
} else {
    echo "   ✗ 游戏控制器不存在\n";
}

// 4. 检查游戏模板文件
echo "\n4. 检查游戏模板文件...\n";
$templates = [
    './Template/Home/Run/xyft.html' => '幸运飞艇主模板',
    './Template/Home/Run/xyft_1.html' => '幸运飞艇备用模板',
    './Template/Home/Run/ssc.html' => '时时彩主模板',
    './Template/Home/Run/ssc_1.html' => '时时彩备用模板',
];

foreach ($templates as $file => $name) {
    if (file_exists($file)) {
        echo "   ✓ {$name} 存在\n";
    } else {
        echo "   ✗ {$name} 不存在\n";
    }
}

// 5. 检查数据库配置
echo "\n5. 检查数据库配置...\n";
$dbConfig = './Application/Common/Conf/db.php';
if (file_exists($dbConfig)) {
    echo "   ✓ 数据库配置文件存在\n";
    
    $config = include $dbConfig;
    if (isset($config['DB_TYPE']) && isset($config['DB_NAME'])) {
        echo "   ✓ 数据库类型: {$config['DB_TYPE']}\n";
        echo "   ✓ 数据库名称: {$config['DB_NAME']}\n";
    }
} else {
    echo "   ✗ 数据库配置文件不存在\n";
}

// 6. 检查URL配置
echo "\n6. 检查URL配置...\n";
$config = './Application/Common/Conf/config.php';
if (file_exists($config)) {
    echo "   ✓ 主配置文件存在\n";
    
    $conf = include $config;
    if (isset($conf['URL_MODEL'])) {
        echo "   ✓ URL模式: {$conf['URL_MODEL']} (";
        switch ($conf['URL_MODEL']) {
            case 0: echo "普通模式"; break;
            case 1: echo "PATHINFO模式"; break;
            case 2: echo "REWRITE模式"; break;
            case 3: echo "兼容模式"; break;
        }
        echo ")\n";
    }
}

// 7. 检查.htaccess文件
echo "\n7. 检查URL重写配置...\n";
if (file_exists('./.htaccess')) {
    echo "   ✓ .htaccess 文件存在\n";
    $htaccess = file_get_contents('./.htaccess');
    if (strpos($htaccess, 'RewriteEngine') !== false) {
        echo "   ✓ URL重写规则已配置\n";
    } else {
        echo "   ✗ URL重写规则未配置\n";
    }
} else {
    echo "   ✗ .htaccess 文件不存在\n";
}

// 8. 检查权限问题
echo "\n8. 检查目录权限...\n";
$dirs = [
    './Runtime' => 'Runtime缓存目录',
    './Uploads' => 'Uploads上传目录',
    './Public' => 'Public静态资源目录',
];

foreach ($dirs as $dir => $name) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "   ✓ {$name} 可写\n";
        } else {
            echo "   ⚠ {$name} 不可写 (可能需要chmod 777)\n";
        }
    } else {
        echo "   ✗ {$name} 不存在\n";
    }
}

echo "\n=== 检查完成 ===\n";
echo "\n建议:\n";
echo "1. 多语言功能: ThinkPHP默认使用zh-cn，如需切换语言，需在配置中开启 LANG_SWITCH_ON\n";
echo "2. 游戏启动: 确保数据库已配置并且有相应的游戏数据表 (think_number, think_order等)\n";
echo "3. URL访问: 使用 /index.php/Home/Run/xyft 或 /index.php/Home/Run/ssc 访问游戏\n";
echo "4. 如果URL重写正常，可以直接使用 /Home/Run/xyft 和 /Home/Run/ssc\n";
?>
