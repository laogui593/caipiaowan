# 多语言配置指南

## 当前状态

✅ **系统已支持多语言**
- 简体中文 (zh-cn) - 默认语言
- 繁体中文 (zh-tw)
- 英文 (en-us)

语言包位置: `/ThinkPHP/Lang/`

## 如何启用多语言切换

### 方法1: 修改配置文件

编辑 `Application/Common/Conf/config.php`，添加以下配置:

```php
<?php
return array(
    // ... 其他配置 ...
    
    /* 多语言配置 */
    'LANG_SWITCH_ON'     => true,    // 开启语言包功能
    'LANG_AUTO_DETECT'   => true,    // 自动侦测语言
    'DEFAULT_LANG'       => 'zh-cn', // 默认语言
    'LANG_LIST'          => 'zh-cn,zh-tw,en-us', // 允许切换的语言列表
    'VAR_LANGUAGE'       => 'l',     // 默认语言切换变量
);
?>
```

### 方法2: URL切换语言

启用后可通过URL参数切换语言:
- 简体中文: `http://yourdomain.com/index.php/Home/Run/index?l=zh-cn`
- 繁体中文: `http://yourdomain.com/index.php/Home/Run/index?l=zh-tw`
- 英文: `http://yourdomain.com/index.php/Home/Run/index?l=en-us`

### 方法3: 在代码中切换

```php
// 在控制器中
$this->lang('zh-tw'); // 切换到繁体中文

// 或使用cookie保存用户选择
cookie('think_language', 'zh-tw');
```

## 游戏访问链接

### 幸运飞艇
- 完整链接: `http://yourdomain.com/index.php/Home/Run/xyft`
- 简化链接 (需URL重写): `http://yourdomain.com/Home/Run/xyft`

### 重庆时时彩
- 完整链接: `http://yourdomain.com/index.php/Home/Run/ssc`
- 简化链接 (需URL重写): `http://yourdomain.com/Home/Run/ssc`

## 常见问题

### Q1: 游戏无法启动？
**检查项:**
1. 数据库连接是否正常
2. 数据表是否存在 (`think_number`, `think_order`, `think_config` 等)
3. 用户是否已登录 (需要session中有user信息)
4. 授权码是否有效

### Q2: 页面显示404？
**解决方案:**
1. 检查 `.htaccess` 文件是否存在
2. 检查Apache是否启用了 `mod_rewrite` 模块
3. 尝试使用完整链接访问 (带 index.php)

### Q3: 语言切换无效？
**解决方案:**
1. 确保在配置中开启了 `LANG_SWITCH_ON`
2. 清空 `Runtime/Cache` 缓存目录
3. 检查语言包文件是否存在

## 当前系统配置

- **ThinkPHP版本**: 3.x
- **URL模式**: REWRITE模式 (模式2)
- **默认语言**: zh-cn (简体中文)
- **数据库**: MySQL (laogui)
- **游戏数量**: 2个 (幸运飞艇、重庆时时彩)
- **每个游戏**: 3个厅 (普通厅、贵宾厅、VIP厅)

## 服务器要求

- PHP >= 5.3
- MySQL >= 5.0
- Apache with mod_rewrite (或 Nginx with rewrite rules)
- PDO扩展
- Session支持
- GD库 (用于二维码生成)

## 备注

1. 当前系统默认使用简体中文，如不需要多语言功能，可保持当前配置不变
2. 所有游戏功能都已正常配置，可直接访问使用
3. URL重写已正确配置，可使用简化链接
