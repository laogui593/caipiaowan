# Database Permission Fix - Quick Reference

## 🔴 Problem

Error message:
```
SELECT command denied to user 'laogui'@'localhost' for table 'think_php'
```

## ✅ Quick Solution

### Step 1: Access Diagnostic Tool
Open in browser:
```
http://your-domain/数据库权限修复.html
```
or
```
http://your-domain/fix_permissions.php
```

### Step 2: Execute Fix Command
Login as MySQL **root** user and run:

```sql
GRANT SELECT ON `information_schema`.* TO 'laogui'@'localhost';
FLUSH PRIVILEGES;
```

### Step 3: Verify
Refresh the diagnostic tool page. All checks should show ✅

## 📁 Added Files

### Tools
- `数据库权限修复.html` - Quick fix page (Chinese UI)
- `fix_permissions.php` - Database permission diagnostic tool
- `test_handlers.php` - System test handler
- `tools.html` - Tools and documentation index

### Documentation
- `QUICKSTART_DATABASE_FIX.md` - Quick start guide (Chinese)
- `DATABASE_PERMISSION_FIX.md` - Complete guide (English)
- `DATABASE_CONFIG.md` - Database configuration guide
- `数据库权限修复指南.md` - Detailed guide (Chinese)
- `问题解决方案总结.md` - Solution summary (Chinese)

### Updated Documents
- `DEPLOY.md` - Added database fix section
- `完整部署指南.md` - Added permission fix instructions

## 🔍 Why This Fix?

ThinkPHP framework needs access to `information_schema` database to:
- Query table structures
- Get field information
- Execute DESCRIBE and SHOW COLUMNS commands
- Auto-generate model mappings

## 📝 Complete Fix (if needed)

If you need to recreate the user completely:

```sql
DROP USER IF EXISTS 'laogui'@'localhost';
CREATE USER 'laogui'@'localhost' IDENTIFIED BY '123456';
CREATE DATABASE IF NOT EXISTS `laogui` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON `laogui`.* TO 'laogui'@'localhost';
GRANT SELECT ON `information_schema`.* TO 'laogui'@'localhost';
FLUSH PRIVILEGES;
```

## 🎯 Verification

Run this command to check permissions:

```sql
SHOW GRANTS FOR 'laogui'@'localhost';
```

Expected output:
```
GRANT USAGE ON *.* TO 'laogui'@'localhost'
GRANT ALL PRIVILEGES ON `laogui`.* TO 'laogui'@'localhost'
GRANT SELECT ON `information_schema`.* TO 'laogui'@'localhost'
```

## 📞 Need Help?

If the problem persists:
1. Run the diagnostic tool and take screenshot
2. Check error logs in `Runtime/Logs/`
3. Verify MySQL version (5.5+)
4. Verify PHP mysqli extension is enabled

## 🔗 Quick Links

- [Quick Fix Page](数据库权限修复.html)
- [Diagnostic Tool](fix_permissions.php)
- [Tools Index](tools.html)
- [English Guide](DATABASE_PERMISSION_FIX.md)
- [Chinese Guide](数据库权限修复指南.md)

---

**Created**: 2025-10-13  
**Status**: ✅ Solution Deployed  
**Framework**: ThinkPHP 3.2.x
