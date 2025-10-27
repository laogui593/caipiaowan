# Copilot Instructions for Caipiaowan (彩票玩) Project

## Project Overview

This is a comprehensive lottery system (彩票系统) built with ThinkPHP 3.2.3 framework. The system includes:
- Frontend user interface for lottery games
- Backend administration panel
- Real-time WebSocket communication
- Multiple lottery game types (PK10, SSC, LHC, K3, 28 games, etc.)

## Project Architecture

### Framework & Technology Stack
- **Backend Framework**: ThinkPHP 3.2.3
- **PHP Version**: PHP 5.3+ (compatible with PHP 8.0+)
- **Database**: MySQL 5.7+
- **Real-time Communication**: Workerman WebSocket
- **Frontend**: jQuery, HTML5, CSS3

### Directory Structure
```
/home/runner/work/caipiaowan/caipiaowan/
├── Application/              # Main application code
│   ├── Admin/               # Backend administration module
│   │   ├── Controller/      # Admin controllers (Login, Member, System, etc.)
│   │   ├── Model/           # Admin data models
│   │   └── View/            # Admin view templates
│   ├── Home/                # Frontend user module
│   │   ├── Controller/      # Frontend controllers (User, Game, Payment, etc.)
│   │   ├── Model/           # Frontend data models
│   │   └── View/            # Frontend view templates
│   ├── Agent/               # Agent/affiliate module
│   └── Common/              # Shared common code
│       ├── Conf/            # Configuration files (config.php, database.php)
│       ├── Common/          # Common functions
│       └── Api/             # API classes
├── ThinkPHP/                # ThinkPHP framework core (DO NOT MODIFY)
├── Public/                  # Static assets (CSS, JS, images)
│   ├── Admin/              # Admin panel assets
│   ├── Home/               # Frontend assets
│   └── Common/             # Shared assets
├── Template/                # Template files
│   ├── Admin/              # Admin templates
│   ├── Home/               # Frontend templates
│   └── Agent/              # Agent templates
├── Workerman/               # WebSocket server library
├── Runtime/                 # Runtime cache and logs
├── Uploads/                 # User uploaded files
├── index.php                # Main entry point
└── start_io.php             # WebSocket server startup
```

## Coding Standards

### PHP Code Style
1. **Follow ThinkPHP conventions**: Use ThinkPHP's naming and structure patterns
2. **Controller naming**: Controllers must end with `Controller` (e.g., `LoginController.class.php`)
3. **Model naming**: Models must end with `Model` (e.g., `UserModel.class.php`)
4. **Method naming**: Use camelCase for method names (e.g., `getUserInfo()`)
5. **Database queries**: Always use ThinkPHP's M() or D() methods, never raw SQL unless absolutely necessary
6. **Security**: Always sanitize user inputs and use prepared statements

### File Naming Conventions
- Controllers: `{Name}Controller.class.php`
- Models: `{Name}Model.class.php`
- Views: lowercase with underscores (e.g., `user_info.html`)

### Comments
- Use Chinese comments where appropriate (this is a Chinese project)
- Add PHPDoc comments for classes and public methods
- Document complex logic with inline comments

## Important System Details

### Authentication System
1. **Backend Admin Login** (`Application/Admin/Controller/LoginController.class.php`):
   - **NO captcha validation** - Admin login only requires username and password
   - Password stored as MD5 hash
   - Session-based authentication
   - Default admin account: username=admin, password=123456

2. **Frontend User Registration** (`Application/Home/Controller/UserController.class.php`):
   - **DOES require captcha validation** - User registration includes image captcha
   - Validates: username, password, phone, withdrawal password, captcha

### Payment System
- The system uses **USDT cryptocurrency** for payments, NOT WeChat Pay
- Payment-related text should reference "USDT收款" not "微信支付"
- WeChat references in customer service files (kefu_wx.html) are for communication only, not payment

### WebSocket Configuration
- Each game type runs on separate WebSocket port (15531-15538)
- Configuration in `start_io.php` and game-specific Workerman controllers
- Ports:
  - PK10: 15531
  - SSC: 15532
  - LHC: 15533
  - BJ28: 15534
  - JND28: 15535
  - XYFT: 15537
  - K3: 15538

### Database Configuration
- Config file: `Application/Common/Conf/config.php`
- Use ThinkPHP's DB configuration format
- Never commit database credentials to repository

## Development Guidelines

### When Making Changes

1. **Minimal Changes**: Make the smallest possible changes to fix issues
2. **Test First**: Understand existing functionality before modifying
3. **Preserve Working Code**: Never remove or modify working functionality unless necessary
4. **Language Consistency**: Keep Chinese UI text in Chinese, don't translate to English
5. **Framework Respect**: Follow ThinkPHP conventions, don't introduce non-standard patterns

### Common Tasks

#### Adding a New Game Type
1. Create controller in `Application/Home/Controller/`
2. Create Workerman controller for WebSocket
3. Add WebSocket port configuration
4. Create templates in `Template/Home/Run/`
5. Update game configuration in `Application/Common/Conf/config.php`

#### Modifying Backend Features
1. Controllers: `Application/Admin/Controller/`
2. Templates: `Template/Admin/`
3. Ensure admin authentication is preserved
4. Test changes in admin panel

#### Database Changes
1. Never modify database structure directly in production
2. Create migration scripts if needed
3. Test with development database first
4. Update models to reflect schema changes

### Security Best Practices

1. **Input Validation**: Always validate and sanitize user inputs
2. **SQL Injection**: Use ThinkPHP's ORM methods (M(), D(), where())
3. **XSS Prevention**: Use htmlspecialchars() or ThinkPHP's I() function
4. **CSRF Protection**: Use tokens for form submissions
5. **Authentication**: Check login status in controllers using session
6. **Password Storage**: Always use MD5 or better hashing (never plain text)

## Testing

### Before Committing
1. Test the specific feature you modified
2. Check admin login still works (if you touched authentication)
3. Verify frontend user registration works (if you modified user flow)
4. Clear cache: `rm -rf Runtime/Cache/* Runtime/Temp/*`
5. Check for PHP errors in logs: `Runtime/Logs/`

### WebSocket Testing
- Start WebSocket server: `php start_io.php start`
- Test real-time functionality in browser
- Check WebSocket logs for errors

## Known Issues to Avoid

1. **Don't add captcha to admin login** - This was a previous issue that was fixed
2. **Don't change USDT to WeChat Pay** - Payment system uses USDT
3. **Don't modify ThinkPHP core** - Keep framework files unchanged
4. **Don't commit Runtime/, Uploads/** - These are in .gitignore

## Resources

- ThinkPHP 3.2.3 Documentation: http://document.thinkphp.cn/manual_3_2.html
- Workerman Documentation: http://www.workerman.net/
- Project deployment guide: See `完整部署指南.md`
- Project status: See `PROJECT_STATUS.md`

## Language Notes

- This is a Chinese project - UI text, comments, and documentation are primarily in Chinese
- Keep Chinese text intact when making changes
- English comments are acceptable for technical implementation details
- User-facing messages must remain in Chinese

## Contact & Maintenance

- Repository: https://github.com/laogui593/caipiaowan
- Maintainer: laogui593
- Current branch: Check `git branch` before making changes
- Always create feature branches for new work

---

**Last Updated**: 2025-10-13
**Version**: 1.0
**Status**: Active Development
