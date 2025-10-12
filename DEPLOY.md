# 彩票系统部署文档

## 系统状态

✅ **系统已修复并正常运行**

## 已修复的问题

1. ✅ 删除了冗余目录（完整系统/、新系统/、tp6_framework/）
2. ✅ 修复了 ThinkPHP/Library/Think/Db/Driver.class.php 的语法错误
   - 第122行：`parseDsn($config)(){}` → `parseDsn($config){}`
   - 第145行和198行：array_map 函数中的 `]` → `}`
3. ✅ 系统已成功启动，页面正常显示

## 当前运行状态

- **主服务**: http://localhost:8001 ✅ 运行中
- **备用服务**: http://localhost:8000 (server.php)
- **框架**: ThinkPHP 3.2.3
- **PHP版本**: PHP 8.0+
- **数据库**: SQLite

## 快速启动

### 方法1: 使用内置PHP服务器
```bash
cd /workspaces/shicai
php -S localhost:8001 index.php
```

### 方法2: 使用启动脚本
```bash
cd /workspaces/shicai
./start_system.sh start
```

## 系统维护命令

```bash
# 启动服务
./start_system.sh start

# 重启服务
./start_system.sh restart

# 查看状态
./start_system.sh status

# 停止服务
./start_system.sh stop

# 查看WebSocket日志
tail -f websocket.log
```

## 目录结构

```
/workspaces/shicai/
├── Application/          # 应用目录
│   ├── Admin/           # 后台管理
│   ├── Agent/           # 代理模块
│   ├── Common/          # 公共模块
│   └── Home/            # 前台模块
├── ThinkPHP/            # ThinkPHP框架核心
├── Public/              # 静态资源
├── Template/            # 模板文件
├── Runtime/             # 运行时缓存
├── Uploads/             # 上传文件
├── index.php            # 入口文件
└── server.php           # 备用服务器入口
```

## 数据库配置

配置文件: `Application/Common/Conf/config.php`

默认使用SQLite数据库，数据库文件位于根目录。

## WebSocket配置

WebSocket服务器配置文件:
- `workerman_server.php` - Workerman服务器
- `start_io.php` - Socket.IO启动文件

## 访问地址

- 前台: http://localhost:8001/
- 后台: http://localhost:8001/admin (需要配置)

## 注意事项

1. 确保PHP版本为8.0或更高
2. 需要SQLite扩展支持
3. 如需使用WebSocket功能，需启动Workerman服务
4. 生产环境建议使用Nginx + PHP-FPM

## 故障排除

### 1. 页面显示错误
```bash
# 查看PHP错误日志
tail -f /tmp/php8001.log

# 重启服务
pkill -f "php -S localhost:8001"
php -S localhost:8001 index.php &
```

### 2. 数据库连接错误
- 检查数据库文件是否存在
- 确认SQLite扩展已安装
- 检查配置文件中的数据库路径

### 3. 权限问题
```bash
# 设置运行时目录权限
chmod -R 777 Runtime/
chmod -R 777 Uploads/
```

## 下一步工作

- [ ] 配置正式的数据库
- [ ] 设置后台管理员账号
- [ ] 配置支付接口
- [ ] 设置WebSocket服务
- [ ] 配置域名和SSL证书

## 技术支持

如有问题，请检查:
1. PHP错误日志
2. WebSocket日志
3. 系统运行日志

---

**修复完成时间**: 2025年10月1日
**修复内容**: 清理混乱代码，修复语法错误，恢复系统正常运行
