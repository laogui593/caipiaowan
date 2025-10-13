# 系统导航和页面结构说明

## 底部导航栏结构

系统使用固定底部导航栏,包含5个主要功能入口:

```
┌────────┬────────┬────────┬────────┬────────┐
│  首页  │  产品  │  客服  │  走势  │  我的  │
└────────┴────────┴────────┴────────┴────────┘
```

### 1. 首页 (Home)
- **路径**: `/Home/Shou/index`
- **图标**: menu1.png
- **功能**: 系统首页,显示公告、轮播图等

### 2. 产品 (Products) ⭐ 游戏入口
- **路径**: `/Home/Run/index`
- **图标**: pay.png
- **功能**: 显示游戏产品列表
- **包含游戏**:
  - 🚁 幸运飞艇竞猜 → 点击进入 `/Home/Run/xyft`
  - ⏰ 重庆时时彩 → 点击进入 `/Home/Run/ssc`

### 3. 客服 (Customer Service)
- **路径**: 配置中的客服链接 `C('zxkf')`
- **图标**: menu3.png
- **功能**: 在线客服支持

### 4. 走势 (Trends)
- **路径**: `/Home/Run/trend`
- **图标**: menu2.png
- **功能**: 查看历史开奖走势图

### 5. 我的 (Profile)
- **路径**: `/Home/User/index`
- **图标**: menu5.png
- **功能**: 个人中心,查看资料、充值提现等

---

## 用户游戏访问流程

### 标准流程 (推荐)

```
用户登录
   ↓
点击底部"产品"按钮
   ↓
进入产品列表页面 (/Home/Run/index)
   ↓
看到两个游戏卡片:
   ├─ 幸运飞艇竞猜 (带游戏介绍和特性)
   └─ 重庆时时彩 (带游戏介绍和特性)
   ↓
点击"立即体验"按钮
   ↓
进入对应游戏大厅
   ├─ 幸运飞艇: /Home/Run/xyft
   └─ 时时彩: /Home/Run/ssc
   ↓
选择房间 (普通厅/贵宾厅/VIP厅)
   ↓
开始游戏
```

### 产品列表页面特点

**页面元素**:
1. 公告栏 - 显示系统公告
2. 轮播图 - 宣传图片
3. 滚动文字 - 显示中奖信息
4. 产品卡片网格 - 游戏选择区域

**产品卡片设计**:
- 大图标 (🚁/⏰)
- 游戏名称
- 游戏简介
- 特性列表 (✓ 标记)
- "立即体验"按钮

**响应式布局**:
- 手机: 1列 (纵向排列)
- 平板: 2列
- 电脑: 3列

---

## 游戏大厅结构

每个游戏都有3个不同的房间:

### 幸运飞艇 (xyft)
1. **普通厅** - 基础投注配置
   - 配置路径: `Admin/Site/xiazhu_xyft`
2. **贵宾厅** - 中级投注配置
   - 配置路径: `Admin/Site/xiazhu_xyftb`
3. **VIP厅** - 高级投注配置
   - 配置路径: `Admin/Site/xiazhu_xyftc`

### 重庆时时彩 (ssc)
1. **普通厅** - 基础投注配置
   - 配置路径: `Admin/Site/xiazhu_ssc`
2. **贵宾厅** - 中级投注配置
   - 配置路径: `Admin/Site/xiazhu_sscb`
3. **VIP厅** - 高级投注配置
   - 配置路径: `Admin/Site/xiazhu_sscc`

---

## 后台管理对应关系

### 数据采集菜单
```
Admin/Caiji/xyft  → 幸运飞艇开奖数据采集
Admin/Caiji/ssc   → 重庆时时彩开奖数据采集
```

### 开奖预设菜单
```
Admin/Yushe/index?type=xyft  → 幸运飞艇开奖预设
Admin/Yushe/index?type=ssc   → 重庆时时彩开奖预设
```

### 下注配置菜单
```
幸运飞艇:
  - Admin/Site/xiazhu_xyft   → 普通厅配置
  - Admin/Site/xiazhu_xyftb  → 贵宾厅配置
  - Admin/Site/xiazhu_xyftc  → VIP厅配置

重庆时时彩:
  - Admin/Site/xiazhu_ssc    → 普通厅配置
  - Admin/Site/xiazhu_sscb   → 贵宾厅配置
  - Admin/Site/xiazhu_sscc   → VIP厅配置
```

---

## 页面激活状态变量

底部导航使用 `$a` 变量控制高亮状态:

```php
$a = 1;  // 首页高亮
$a = 2;  // 走势高亮
$a = 5;  // 我的高亮
$a = 6;  // 产品高亮
```

在控制器中设置:
```php
<?php $a=6; ?>  // 产品页面
<include file="./Template/Home/Run/footer.html" />
```

---

## 重要说明

⚠️ **用户访问游戏的正确方式**:
- ✅ 点击底部"产品" → 选择游戏 → 进入大厅
- ❌ 不要直接访问游戏URL (如 /Home/Run/xyft)

⚠️ **游戏直接链接**:
- 仅供管理员测试使用
- 普通用户应通过产品列表页面进入

⚠️ **产品列表页面**:
- 是用户选择游戏的唯一入口
- 包含游戏介绍和特性说明
- 提供良好的用户体验

---

## 文件位置

### 底部导航
- 模板: `Template/Home/Run/footer.html`
- 在所有需要导航的页面中引入

### 产品列表页面
- 控制器: `Application/Home/Controller/RunController.class.php` → `index()` 方法
- 模板: `Template/Home/Run/index.html`

### 游戏大厅页面
- 控制器: `Application/Home/Controller/RunController.class.php` → `xyft()` / `ssc()` 方法
- 模板: 
  - `Template/Home/Run/xyft.html` (幸运飞艇)
  - `Template/Home/Run/ssc.html` (时时彩)

---

## 总结

1. ✅ 底部导航已正确配置5个入口
2. ✅ "产品"按钮指向产品列表页面 (`/Home/Run/index`)
3. ✅ 产品列表页面显示2个游戏卡片
4. ✅ 用户点击卡片进入对应游戏大厅
5. ✅ 每个游戏有3个房间(普通/贵宾/VIP)
6. ✅ 后台管理菜单对应游戏配置

**系统设计符合标准流程,用户通过底部导航访问游戏!**
