# 代码覆盖和部署指南

## 概述

本指南说明如何将当前分支的代码推送到仓库并覆盖现有代码。

## 当前状态

✅ **所有代码已成功推送到远程仓库**

- **分支**: `copilot/push-code-and-overwrite`
- **提交状态**: 已推送到 origin
- **工作树**: 干净（无未提交更改）

## 代码覆盖选项

### 选项 1: 强制推送到主分支 (覆盖 main)

如果您想用当前代码完全覆盖主分支：

```bash
# 切换到主分支
git checkout main

# 强制重置为当前分支的状态
git reset --hard copilot/push-code-and-overwrite

# 强制推送到远程（覆盖远程主分支）
git push -f origin main
```

⚠️ **警告**: 这将永久覆盖主分支的历史记录

### 选项 2: 合并到主分支 (保留历史)

如果您想保留历史记录并合并更改：

```bash
# 切换到主分支
git checkout main

# 合并当前分支
git merge copilot/push-code-and-overwrite

# 推送合并结果
git push origin main
```

### 选项 3: 使用当前分支作为主分支

直接使用 `copilot/push-code-and-overwrite` 作为生产分支：

```bash
# 在服务器上拉取最新代码
git fetch origin
git checkout copilot/push-code-and-overwrite
git pull origin copilot/push-code-and-overwrite
```

### 选项 4: 创建新的生产分支

```bash
# 基于当前代码创建生产分支
git checkout -b production
git push origin production
```

## 服务器部署步骤

### 1. 备份现有代码

```bash
# 在服务器上备份当前代码
cd /path/to/your/project
tar -czf backup_$(date +%Y%m%d_%H%M%S).tar.gz .
```

### 2. 拉取新代码

```bash
# 拉取最新代码
git fetch origin
git checkout copilot/push-code-and-overwrite
git pull origin copilot/push-code-and-overwrite

# 或者使用强制更新（覆盖本地修改）
git fetch origin copilot/push-code-and-overwrite
git reset --hard origin/copilot/push-code-and-overwrite
```

### 3. 更新配置

```bash
# 确保配置文件正确
cp Application/Common/Conf/db.php.bak Application/Common/Conf/db.php
# 编辑数据库配置
vim Application/Common/Conf/db.php
```

### 4. 设置权限

```bash
# 设置必要的目录权限
chmod -R 777 Runtime/
chmod -R 777 Uploads/
```

### 5. 清理缓存

```bash
# 清理运行时缓存
rm -rf Runtime/Cache/*
rm -rf Runtime/Temp/*
rm -rf Runtime/Logs/*
```

### 6. 重启服务

```bash
# 重启 PHP 服务
./start_system.sh restart

# 或者使用 systemctl（如果使用系统服务）
sudo systemctl restart php-fpm
sudo systemctl restart nginx
```

## 验证部署

### 1. 检查系统状态

```bash
# 查看服务状态
./start_system.sh status

# 查看日志
tail -f Runtime/Logs/Home/*.log
```

### 2. 访问系统

- 前台: http://your-domain.com/
- 后台: http://your-domain.com/admin

### 3. 测试功能

- [ ] 用户登录
- [ ] 游戏加载
- [ ] 下注功能
- [ ] WebSocket 连接
- [ ] 支付功能

## 安全检查清单

在部署到生产环境前，确保：

- [x] APP_DEBUG = false （已设置）
- [x] 数据库配置正确
- [x] 安全函数库已加载
- [ ] SSL 证书已配置
- [ ] 防火墙规则已设置
- [ ] 备份策略已就绪

## 回滚步骤

如果部署后出现问题：

```bash
# 方法 1: 使用备份恢复
cd /path/to/your/project
tar -xzf backup_YYYYMMDD_HHMMSS.tar.gz

# 方法 2: 使用 git 回退
git reflog
git reset --hard <previous-commit-hash>

# 重启服务
./start_system.sh restart
```

## 监控和维护

### 日志监控

```bash
# 实时查看错误日志
tail -f Runtime/Logs/Home/error_*.log

# 查看 WebSocket 日志
tail -f websocket.log
```

### 性能监控

```bash
# 查看 PHP 进程
ps aux | grep php

# 查看内存使用
free -h

# 查看磁盘使用
df -h
```

## 常见问题

### Q: 推送失败怎么办？

```bash
# 如果推送被拒绝
git push -f origin copilot/push-code-and-overwrite
```

### Q: 代码冲突怎么办？

```bash
# 强制使用远程代码
git fetch origin
git reset --hard origin/copilot/push-code-and-overwrite
```

### Q: 数据库连接失败？

检查 `Application/Common/Conf/db.php` 配置是否正确。

## 联系支持

- **GitHub 仓库**: https://github.com/laogui593/caipiaowan
- **当前分支**: copilot/push-code-and-overwrite
- **问题反馈**: 在 GitHub 上创建 Issue

---

**创建时间**: 2025-10-13
**版本**: 1.0
**状态**: ✅ 代码已推送，可以部署
