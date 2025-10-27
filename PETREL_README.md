# Petrel Services Management for Windows

This directory contains Windows batch scripts for managing Java-based Petrel microservices.

## Quick Start

### Start All Services
```batch
manage-petrel.bat start ALL
```

### Stop All Services
```batch
manage-petrel.bat stop ALL
```

### Manage Individual Services
```batch
manage-petrel.bat start register
manage-petrel.bat start user
manage-petrel.bat start game
manage-petrel.bat start lobby
manage-petrel.bat start slots
manage-petrel.bat start web

manage-petrel.bat stop register
manage-petrel.bat stop user
...etc
```

## Documentation

For detailed documentation, please refer to:

- **[PETREL_MANAGEMENT.md](PETREL_MANAGEMENT.md)** - Technical documentation, usage, configuration, and troubleshooting
- **[PETREL_DEPLOYMENT_GUIDE.md](PETREL_DEPLOYMENT_GUIDE.md)** - Deployment guide, examples, and best practices

## Services Managed

1. **Register Service** (`petrel-kernel-register-1.0-SNAPSHOT-boot.jar`)
2. **User Service** (`petrel-kernel-user-1.0-SNAPSHOT-boot.jar`)
3. **Game Service** (`petrel-kernel-game-1.0-SNAPSHOT-boot.jar`)
4. **Lobby Service** (`petrel-game-lobby-1.0-SNAPSHOT-boot.jar`)
5. **Slots Service** (`petrel-game-slots-1.0-SNAPSHOT-boot.jar`)
6. **Web Service** (`petrel-cms-web-1.0-SNAPSHOT.war`)

## Prerequisites

- Java Runtime Environment (JRE) 8 or higher
- Windows operating system with WMIC support
- JAR/WAR files in the same directory as the script

## Directory Structure

```
your-deployment-folder/
├── manage-petrel.bat
├── petrel-kernel-register-1.0-SNAPSHOT-boot.jar
├── petrel-kernel-user-1.0-SNAPSHOT-boot.jar
├── petrel-kernel-game-1.0-SNAPSHOT-boot.jar
├── petrel-game-lobby-1.0-SNAPSHOT-boot.jar
├── petrel-game-slots-1.0-SNAPSHOT-boot.jar
└── petrel-cms-web-1.0-SNAPSHOT.war
```

## Features

- ✅ Start/stop individual services or all at once
- ✅ Custom JVM memory settings per service
- ✅ Spring Boot production profile configuration
- ✅ Process identification using WMIC
- ✅ Special configuration for lobby and slots services
- ✅ No variable conflicts between services

## Support

For detailed help:
1. Check [PETREL_MANAGEMENT.md](PETREL_MANAGEMENT.md) for technical details
2. Check [PETREL_DEPLOYMENT_GUIDE.md](PETREL_DEPLOYMENT_GUIDE.md) for deployment help
3. Review the troubleshooting sections in the documentation

---

**Note**: This script is designed for Windows environments. For Linux/Unix systems, you would need to create equivalent shell scripts.
