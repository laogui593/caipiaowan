# Nacos 服务注册说明

## 概述

彩票系统支持将服务注册到 Nacos 注册中心，实现服务发现和健康检查。

## 注册的服务

系统会将以下两个服务注册到 Nacos：

| 服务名称 | 端口 | 说明 |
|---------|------|------|
| caipiao-frontend-api | 7180 | 前端API服务 |
| caipiao-backend-admin | 7170 | 后台管理服务 |

## 配置 Nacos

### 1. 修改 Nacos 服务器地址

编辑 `nacos_register.php` 文件，修改以下配置：

```php
$nacosConfig = [
    'host' => '127.0.0.1',      // Nacos 服务器地址
    'port' => 8848,              // Nacos 端口
    'namespace' => 'public'      // 命名空间
];
```

或者编辑 `启动并注册到Nacos.sh`，修改：

```bash
NACOS_HOST="127.0.0.1"
NACOS_PORT="8848"
ENABLE_NACOS="true"  # 是否启用 Nacos 注册
```

### 2. 确保 Nacos 服务器运行

```bash
# 检查 Nacos 是否运行
curl http://127.0.0.1:8848/nacos/

# 启动 Nacos（如果未运行）
cd nacos/bin
./startup.sh -m standalone
```

## 使用方法

### 方式1: 使用完整启动脚本（推荐）

```bash
# 启动服务并自动注册到 Nacos
chmod +x 启动并注册到Nacos.sh
./启动并注册到Nacos.sh
```

这个脚本会：
1. 启动前端服务（7180）
2. 启动后台服务（7170）
3. 注册两个服务到 Nacos
4. 启动心跳守护进程

### 方式2: 手动注册

```bash
# 1. 先启动服务
./完整启动脚本.sh

# 2. 注册所有服务到 Nacos
php nacos_register.php register all

# 3. 启动心跳守护进程
nohup php nacos_register.php daemon > nacos_heartbeat.log 2>&1 &
```

## 管理命令

### 注册服务

```bash
# 注册所有服务
php nacos_register.php register all

# 仅注册前端服务 (7180)
php nacos_register.php register frontend

# 仅注册后台服务 (7170)
php nacos_register.php register backend
```

### 注销服务

```bash
# 注销所有服务
php nacos_register.php deregister all

# 注销指定服务
php nacos_register.php deregister frontend
php nacos_register.php deregister backend
```

### 查询服务状态

```bash
# 查询所有服务
php nacos_register.php query all

# 查询指定服务
php nacos_register.php query frontend
php nacos_register.php query backend
```

### 发送心跳

```bash
# 手动发送一次心跳
php nacos_register.php heartbeat

# 启动守护进程（自动每5秒发送心跳）
php nacos_register.php daemon
```

## 验证注册

### 1. 通过 Nacos 控制台

访问 Nacos 控制台：
```
http://127.0.0.1:8848/nacos/
```

进入 "服务管理" -> "服务列表"，应该能看到：
- caipiao-frontend-api
- caipiao-backend-admin

### 2. 通过脚本查询

```bash
php nacos_register.php query
```

### 3. 通过 Nacos API

```bash
# 查询前端服务
curl "http://127.0.0.1:8848/nacos/v1/ns/instance/list?serviceName=caipiao-frontend-api"

# 查询后台服务
curl "http://127.0.0.1:8848/nacos/v1/ns/instance/list?serviceName=caipiao-backend-admin"
```

## 服务元数据

注册到 Nacos 的服务包含以下元数据：

```json
{
  "version": "1.0.0",
  "service_type": "frontend/backend",
  "description": "服务描述"
}
```

## 心跳机制

- 心跳间隔：5秒
- 心跳超时：15秒（Nacos默认）
- 服务下线：连续3次心跳失败后自动下线

## 日志文件

```bash
# 查看心跳日志
tail -f nacos_heartbeat.log

# 查看服务日志
tail -f frontend_7180.log
tail -f backend_7170.log
```

## 停止服务

```bash
# 停止所有服务并从 Nacos 注销
./stop_all_services.sh

# 手动停止
kill $(cat frontend_7180.pid)
kill $(cat backend_7170.pid)
kill $(cat nacos_heartbeat.pid)

# 从 Nacos 注销
php nacos_register.php deregister all
```

## 故障排除

### 1. 无法连接到 Nacos

**错误**：`Failed to connect to 127.0.0.1 port 8848`

**解决**：
- 检查 Nacos 是否运行：`curl http://127.0.0.1:8848/nacos/`
- 检查防火墙设置
- 确认 Nacos 地址配置正确

### 2. 服务注册失败

**检查**：
- Nacos 服务器是否运行
- 网络连接是否正常
- 配置的端口是否正确

### 3. 心跳失败

**检查**：
- 服务是否仍在运行
- Nacos 连接是否正常
- 查看心跳日志：`tail -f nacos_heartbeat.log`

## 配置示例

### 开发环境

```bash
NACOS_HOST="127.0.0.1"
NACOS_PORT="8848"
```

### 生产环境

```bash
NACOS_HOST="nacos.example.com"
NACOS_PORT="8848"
NACOS_NAMESPACE="prod"
```

## API 接口

服务注册后，可以通过 Nacos 发现服务：

```bash
# 获取前端API服务地址
curl "http://nacos-server:8848/nacos/v1/ns/instance/list?serviceName=caipiao-frontend-api"

# 获取后台管理服务地址
curl "http://nacos-server:8848/nacos/v1/ns/instance/list?serviceName=caipiao-backend-admin"
```

## 注意事项

1. **Nacos 必须先启动**才能注册服务
2. **心跳守护进程**会在后台自动运行，保持服务在线
3. **停止服务时**记得从 Nacos 注销
4. **生产环境**建议配置 Nacos 集群

---

**创建时间**: 2025-10-29
**适用版本**: 彩票系统 v1.0.0
