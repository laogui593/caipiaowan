# 数据库配置说明 (Database Configuration Guide)

## 📋 部署步骤

### 1. 创建数据库配置文件

复制示例文件并修改配置：

```bash
cd Application/Common/Conf/
cp db.php.example db.php
```

### 2. 修改数据库配置

编辑 `db.php` 文件，修改以下配置：

```php
return array(
    'DB_TYPE'   => 'mysql',        // 数据库类型
    'DB_HOST'   => 'localhost',    // 数据库服务器地址
    'DB_NAME'   => 'laogui',       // 数据库名称
    'DB_USER'   => 'laogui',       // 数据库用户名
    'DB_PWD'    => '123456',       // 数据库密码 ⚠️ 请修改
    'DB_PORT'   => '3306',         // 数据库端口
    'DB_PREFIX' => 'think_',       // 数据表前缀
    'DB_CHARSET'=> 'utf8',         // 数据库编码
);
```

### 3. 执行数据库更新（如果从旧版本升级）

如果系统之前使用微信支付，需要执行以下SQL更新字段名：

```sql
USE laogui;
ALTER TABLE `user` CHANGE `wx_paycode` `usdt_paycode` VARCHAR(255);
```

### 4. 设置文件权限

```bash
chmod 644 Application/Common/Conf/db.php
```

## ⚠️ 安全提示

1. **不要将 `db.php` 文件提交到公开仓库**
2. **使用强密码**
3. **定期备份数据库**
4. **生产环境关闭数据库调试模式** (`DB_DEBUG` => `false`)

## 📊 数据库结构

系统使用的主要数据表（前缀 `think_`）：

- `think_user` - 用户表
- `think_order` - 订单表
- `think_fenadd` - 充值申请表
- `think_fenxia` - 提现申请表
- `think_caiji` - 开奖数据采集表
- `think_message` - 消息表
- `think_robot` - 机器人表
- `think_config` - 系统配置表

## 🎮 当前支持的游戏

- 幸运飞艇 (xyft) - 3个厅（普通/贵宾/VIP）
- 时时彩 (ssc) - 3个厅（普通/贵宾/VIP）

## 💰 支付系统

系统已配置USDT加密货币支付系统，替代了传统的微信支付。
