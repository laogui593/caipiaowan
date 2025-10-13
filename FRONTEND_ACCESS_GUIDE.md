# 彩票系统前端访问问题解决方案

## 问题描述
访问前端时显示"未指定输入文件"(No input file specified)

## 原因分析
这个错误通常是由于Web服务器配置问题导致的,特别是URL重写规则没有正确生效。

## 解决方案

### 方案一:Apache服务器配置

#### 1. 确保启用了mod_rewrite模块
```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2

# CentOS/RHEL
# 编辑 /etc/httpd/conf/httpd.conf
# 取消注释: LoadModule rewrite_module modules/mod_rewrite.so
sudo systemctl restart httpd
```

#### 2. 确保Apache配置允许.htaccess
编辑虚拟主机配置文件,确保有以下设置:
```apache
<Directory "/path/to/caipiaowan">
    AllowOverride All
    Require all granted
</Directory>
```

#### 3. 检查.htaccess文件
确保根目录下的.htaccess文件存在且内容正确:
```apache
<IfModule mod_rewrite.c>
  Options +FollowSymlinks
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
</IfModule>
```

### 方案二:Nginx服务器配置

如果使用Nginx,需要配置location规则:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/caipiaowan;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }
}
```

### 方案三:使用PHP内置服务器(开发环境)

如果只是开发测试,可以使用PHP内置服务器:

```bash
cd /workspaces/caipiaowan
php -S localhost:8080 -t .
```

然后访问: http://localhost:8080

**注意**: PHP内置服务器不支持.htaccess,ThinkPHP会自动降级到兼容模式。

### 方案四:修改URL模式(临时解决)

如果无法配置Web服务器,可以临时修改ThinkPHP的URL模式:

编辑 `Application/Common/Conf/config.php`:
```php
'URL_MODEL' => 0,  // 改为0(普通模式)或3(兼容模式)
```

这样可以使用 `http://domain/index.php?m=Home&c=Index&a=index` 的方式访问。

## 访问方式

### 正确的访问方式:
- http://your-domain.com/  (根目录,会自动路由到Home/Index/index)
- http://your-domain.com/Home/Index/index  (完整路径)
- http://your-domain.com/Home/User/login  (登录页)

### 错误的访问方式:
- http://your-domain.com/index.php  (直接访问index.php会报错)

## 验证步骤

1. 首先访问测试页面验证PHP环境:
   ```
   http://your-domain.com/test_env.php
   ```

2. 检查PATH_INFO是否正确传递

3. 如果test_env.php能正常访问,但首页不能,说明是ThinkPHP路由问题

4. 检查Runtime目录权限:
   ```bash
   chmod -R 777 Runtime/
   ```

## 当前系统配置
- ThinkPHP版本: 3.2.3
- URL模式: 2 (REWRITE)
- 默认模块: Home
- 默认控制器: Index
- 默认方法: index
- URL后缀: .html

## 数据库配置
数据库配置文件已创建在 `Application/Common/Conf/db.php`:
- 数据库类型: MySQL
- 数据库地址: localhost
- 数据库名: laogui
- 用户名: laogui
- 密码: 123456
- 表前缀: think_
