# 系统安全加固指南

## 已实施的安全措施

### 1. 调试模式关闭 ✅
- **文件**: `index.php`
- **修改**: `define('APP_DEBUG',false);`
- **说明**: 生产环境必须关闭调试模式，防止暴露系统信息

### 2. 安全函数库 ✅
- **文件**: `Application/Common/Common/security.php`
- **功能**:
  - `safe_int()` - 安全的整数验证
  - `safe_string()` - 字符串转义
  - `safe_password_hash()` - 密码哈希（推荐）
  - `safe_password_verify()` - 密码验证
  - `legacy_password_verify()` - 兼容旧MD5密码
  - `xss_clean()` - XSS防护
  - `generate_csrf_token()` - 生成CSRF令牌
  - `verify_csrf_token()` - 验证CSRF令牌
  - `safe_file_upload()` - 文件上传验证

## 需要手动修复的问题

### 🔴 高优先级

#### 1. SQL注入防护

**当前危险写法**:
```php
$user = M('user')->where("id = $id")->find();
```

**安全写法**:
```php
$id = safe_int(I('id'));  // 先验证为整数
$user = M('user')->where("id = %d", $id)->find();
// 或者
$user = M('user')->where(['id' => $id])->find();
```

**影响文件**:
- `Application/Admin/Controller/MemberController.class.php`
- `Application/Agent/Controller/MemberController.class.php`
- `Application/Admin/Controller/FenController.class.php`
- `Application/Agent/Controller/FenController.class.php`
- 其他所有Controller文件

**修复建议**:
1. 所有从用户输入获取的ID，使用 `safe_int()` 验证
2. 使用数组方式传递where条件，ThinkPHP会自动转义
3. 避免直接拼接SQL字符串

#### 2. 密码安全升级

**当前问题**: 使用MD5加密密码（已不安全）

**解决方案**:
```php
// 注册时
$password = safe_password_hash(I('password'));

// 登录验证时
$user = M('user')->where(['username' => $username])->find();
if ($user) {
    // 先尝试新的bcrypt验证
    if (safe_password_verify($input_password, $user['password'])) {
        // 登录成功
    } 
    // 兼容旧的MD5密码
    else if (legacy_password_verify($input_password, $user['password'])) {
        // 登录成功，同时升级密码
        $new_hash = safe_password_hash($input_password);
        M('user')->where(['id' => $user['id']])->save(['password' => $new_hash]);
    }
}
```

**影响文件**:
- `Application/Home/Controller/IndexController.class.php` (注册、登录)
- `Application/Admin/Controller/LoginController.class.php`
- `Application/Agent/Controller/LoginController.class.php`
- `Application/Home/Controller/UserController.class.php` (修改密码)

### 🟡 中优先级

#### 3. XSS防护

**在模板中使用**:
```html
<!-- 危险 -->
<div>{$userinfo.nickname}</div>

<!-- 安全 -->
<div>{$userinfo.nickname|htmlspecialchars}</div>
```

**在PHP中使用**:
```php
$nickname = xss_clean(I('nickname'));
```

#### 4. CSRF防护

**启用ThinkPHP的Token机制**:

在 `Application/Common/Conf/config.php` 添加:
```php
'TOKEN_ON' => true,
'TOKEN_NAME' => '__hash__',
'TOKEN_TYPE' => 'md5',
'TOKEN_RESET' => true,
```

**在表单中添加Token**:
```html
<form method="post">
    {:token()}
    <!-- 其他表单字段 -->
</form>
```

#### 5. 文件上传安全

**当前问题**: 缺少文件类型和大小验证

**安全实现**:
```php
if ($_FILES) {
    $upload = new \Think\Upload();
    $upload->maxSize = 5242880; // 5MB
    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
    $upload->rootPath = './Uploads/';
    
    // 添加自定义验证
    $file = $_FILES['file'];
    $check = safe_file_upload($file, ['image/jpeg', 'image/png', 'image/gif'], 5242880);
    
    if (!$check['status']) {
        $this->error($check['message']);
    }
    
    $info = $upload->upload();
    // ...
}
```

### 🟢 低优先级

#### 6. 会话安全

在 `Application/Common/Conf/config.php` 添加:
```php
// 会话配置
'SESSION_OPTIONS' => [
    'cookie_httponly' => true,    // 防止XSS窃取Cookie
    'cookie_secure' => false,     // HTTPS环境设为true
    'cookie_samesite' => 'Lax',   // 防止CSRF
],
```

#### 7. 错误日志

关闭调试模式后，配置错误日志:
```php
'LOG_RECORD' => true,
'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR',
'LOG_PATH' => './Runtime/Logs/',
```

#### 8. 敏感信息保护

**数据库配置文件权限**:
```bash
chmod 640 Application/Common/Conf/db.php
```

**添加到 .gitignore**:
```
Application/Common/Conf/db.php
Application/Common/Conf/site.php
Runtime/
*.log
```

## 快速修复脚本

为了快速修复最关键的SQL注入问题，可以使用以下正则表达式批量替换：

### 1. 修复 where("id = $id")
**查找**: `where\("id = \$(\w+)"\)`
**替换**: `where(["id" => safe_int($$$1)])`

### 2. 修复 where("userid = $userid")
**查找**: `where\("userid = \$(\w+)"\)`
**替换**: `where(["userid" => safe_int($$$1)])`

## 安全检查清单

部署前检查:
- [ ] APP_DEBUG 设为 false
- [ ] 数据库密码强度足够（至少12位，包含大小写字母、数字、符号）
- [ ] 所有 .php 文件权限设为 644
- [ ] 上传目录禁止执行PHP
- [ ] 开启ThinkPHP的TOKEN验证
- [ ] 所有用户输入都经过验证和转义
- [ ] 使用HTTPS（如果可能）
- [ ] 定期备份数据库
- [ ] 设置错误日志
- [ ] 限制登录失败次数

## 定期维护

1. **每周**: 检查系统日志，查看是否有异常访问
2. **每月**: 更新ThinkPHP和PHP版本（如有安全更新）
3. **每季度**: 进行安全审计，使用工具扫描漏洞
4. **每年**: 更换数据库密码和密钥

## 应急响应

如果发现安全问题:
1. 立即关闭网站（maintenance mode）
2. 备份当前数据库和文件
3. 检查入侵痕迹（查看日志）
4. 修复漏洞
5. 恢复服务
6. 通知用户修改密码（如果数据库被泄露）

## 参考资源

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [ThinkPHP 安全指南](http://www.thinkphp.cn/topic/6352.html)
- [PHP 安全最佳实践](https://www.php.net/manual/zh/security.php)
