# Petrel Services Deployment Example

## Directory Structure

Place the `manage-petrel.bat` script in the same directory as your JAR/WAR files:

```
petrel-services/
├── manage-petrel.bat
├── petrel-kernel-register-1.0-SNAPSHOT-boot.jar
├── petrel-kernel-user-1.0-SNAPSHOT-boot.jar
├── petrel-kernel-game-1.0-SNAPSHOT-boot.jar
├── petrel-game-lobby-1.0-SNAPSHOT-boot.jar
├── petrel-game-slots-1.0-SNAPSHOT-boot.jar
└── petrel-cms-web-1.0-SNAPSHOT.war
```

## Quick Start Guide

### Step 1: Prepare the Environment

1. Install Java JRE 8 or higher
2. Verify Java installation:
   ```batch
   java -version
   ```

### Step 2: Deploy JAR/WAR Files

1. Create a deployment directory (e.g., `C:\petrel-services`)
2. Copy all JAR/WAR files to this directory
3. Copy `manage-petrel.bat` to the same directory

### Step 3: Start Services

Open Command Prompt in the deployment directory and run:

```batch
cd C:\petrel-services
manage-petrel.bat start ALL
```

Expected output:
```
Starting petrel-kernel-register-1.0-SNAPSHOT-boot.jar ...
Starting petrel-kernel-user-1.0-SNAPSHOT-boot.jar ...
Starting petrel-kernel-game-1.0-SNAPSHOT-boot.jar ...
Starting petrel-game-lobby-1.0-SNAPSHOT-boot.jar ...
Starting petrel-game-slots-1.0-SNAPSHOT-boot.jar ...
Starting petrel-cms-web-1.0-SNAPSHOT.war ...
All services started!
```

### Step 4: Verify Services are Running

Check running Java processes:
```batch
wmic process where "CommandLine like '%petrel%'" get ProcessId,CommandLine
```

Or use Task Manager to view Java processes.

### Step 5: Stop Services

When you need to stop the services:

```batch
manage-petrel.bat stop ALL
```

Expected output:
```
petrel-kernel-register-1.0-SNAPSHOT-boot.jar killed!
petrel-kernel-user-1.0-SNAPSHOT-boot.jar killed!
petrel-kernel-game-1.0-SNAPSHOT-boot.jar killed!
petrel-game-lobby-1.0-SNAPSHOT-boot.jar killed!
petrel-game-slots-1.0-SNAPSHOT-boot.jar killed!
petrel-cms-web-1.0-SNAPSHOT.war killed!
All services stopped!
```

## Common Scenarios

### Starting Services One by One

Useful for debugging or gradual deployment:

```batch
REM Start register service first (required by others)
manage-petrel.bat start register
timeout /t 10

REM Start user service
manage-petrel.bat start user
timeout /t 10

REM Start game service
manage-petrel.bat start game
timeout /t 10

REM Start lobby and slots
manage-petrel.bat start lobby
manage-petrel.bat start slots

REM Start web interface
manage-petrel.bat start web
```

### Restart a Single Service

```batch
REM Stop the service
manage-petrel.bat stop user

REM Wait a few seconds
timeout /t 5

REM Start it again
manage-petrel.bat start user
```

### Check Service Status

Create a simple status check script (`check-status.bat`):

```batch
@echo off
echo Checking Petrel services status...
echo.

wmic process where "CommandLine like '%petrel-kernel-register%'" get ProcessId,CommandLine 2>nul
if %errorlevel% equ 0 (
    echo Register Service: Running
) else (
    echo Register Service: Stopped
)

wmic process where "CommandLine like '%petrel-kernel-user%'" get ProcessId,CommandLine 2>nul
if %errorlevel% equ 0 (
    echo User Service: Running
) else (
    echo User Service: Stopped
)

wmic process where "CommandLine like '%petrel-kernel-game%'" get ProcessId,CommandLine 2>nul
if %errorlevel% equ 0 (
    echo Game Service: Running
) else (
    echo Game Service: Stopped
)

wmic process where "CommandLine like '%petrel-game-lobby%'" get ProcessId,CommandLine 2>nul
if %errorlevel% equ 0 (
    echo Lobby Service: Running
) else (
    echo Lobby Service: Stopped
)

wmic process where "CommandLine like '%petrel-game-slots%'" get ProcessId,CommandLine 2>nul
if %errorlevel% equ 0 (
    echo Slots Service: Running
) else (
    echo Slots Service: Stopped
)

wmic process where "CommandLine like '%petrel-cms-web%'" get ProcessId,CommandLine 2>nul
if %errorlevel% equ 0 (
    echo Web Service: Running
) else (
    echo Web Service: Stopped
)

pause
```

## Production Deployment Tips

### 1. Create Service Startup Order

Some services may depend on others. Recommended order:
1. Register service (service registry)
2. User service
3. Game service
4. Lobby service
5. Slots service
6. Web service

### 2. Monitor Service Health

Consider adding health check endpoints and monitoring:
- Use Spring Boot Actuator endpoints
- Implement automated health checks
- Set up alerting for service failures

### 3. Log Management

Configure log locations in application.properties:
```properties
logging.file.path=C:/petrel-services/logs
logging.file.name=petrel-${spring.application.name}.log
```

### 4. Automatic Startup

To start services on Windows boot:

1. Create a scheduled task:
   ```batch
   schtasks /create /tn "Petrel Services" /tr "C:\petrel-services\manage-petrel.bat start ALL" /sc onstart /ru SYSTEM
   ```

2. Or use Windows Service Wrapper (winsw) to run as Windows Services

### 5. Backup Configuration

Regularly backup configuration files:
- application.properties
- application-prod.properties
- Database connection strings

## Troubleshooting Common Issues

### Issue: Service starts but immediately stops

**Solution**: Check the logs in the service directory. Common causes:
- Port already in use
- Database connection failure
- Missing dependencies

### Issue: "Java is not recognized"

**Solution**: Add Java to PATH:
1. Find Java installation directory (e.g., `C:\Program Files\Java\jdk1.8.0_xxx\bin`)
2. Add to System PATH environment variable
3. Restart Command Prompt

### Issue: Insufficient memory

**Solution**: Adjust JVM parameters in `manage-petrel.bat`:
```batch
REM Reduce memory for systems with less RAM
call :start_service "%userjar%" "-Xmn256m -Xms512m -Xmx512m"
```

### Issue: Services conflict with each other

**Solution**: Check port configurations in application.properties:
```properties
server.port=8081
```

Ensure each service uses a unique port.

## Performance Tuning

### Memory Settings

Current settings are optimized for:
- Register: Small, lightweight service (400MB)
- Others: Medium to large services (1GB)

Adjust based on:
- Available system RAM
- Service load/traffic
- Number of concurrent users

### JVM Tuning Options

Additional JVM parameters you might add:

```batch
REM For better garbage collection
-XX:+UseG1GC -XX:MaxGCPauseMillis=200

REM For diagnostics
-XX:+HeapDumpOnOutOfMemoryError -XX:HeapDumpPath=./dumps

REM For monitoring
-Dcom.sun.management.jmxremote -Dcom.sun.management.jmxremote.port=9010 -Dcom.sun.management.jmxremote.authenticate=false -Dcom.sun.management.jmxremote.ssl=false
```

## Security Considerations

1. **Network Configuration**: Update IP addresses in the script:
   ```batch
   --zebra.ip.out=YOUR_SERVER_IP
   ```

2. **Firewall Rules**: Ensure required ports are open

3. **File Permissions**: Restrict access to JAR/WAR files

4. **Production Profiles**: Use separate profiles for different environments

## Support

For issues specific to:
- Script functionality: Check PETREL_MANAGEMENT.md
- Service configuration: Check Spring Boot documentation
- Application issues: Check service logs
