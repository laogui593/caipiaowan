# Petrel Services Management Script

## Overview

The `manage-petrel.bat` script provides a convenient way to start and stop all Petrel microservices on Windows systems.

## Services Managed

The script manages the following 6 Java-based services:

1. **Register Service** - `petrel-kernel-register-1.0-SNAPSHOT-boot.jar`
   - Memory: 200MB new gen, 400MB heap
   
2. **User Service** - `petrel-kernel-user-1.0-SNAPSHOT-boot.jar`
   - Memory: 512MB new gen, 1GB heap
   
3. **Game Service** - `petrel-kernel-game-1.0-SNAPSHOT-boot.jar`
   - Memory: 512MB new gen, 1GB heap
   
4. **Lobby Service** - `petrel-game-lobby-1.0-SNAPSHOT-boot.jar`
   - Memory: 512MB new gen, 1GB heap
   - Special config: zebra.ip.out=122.114.55.213, zebra.port=8989
   
5. **Slots Service** - `petrel-game-slots-1.0-SNAPSHOT-boot.jar`
   - Memory: 512MB new gen, 1GB heap
   - Special config: zebra.ip.out=122.114.55.213
   
6. **Web Service** - `petrel-cms-web-1.0-SNAPSHOT.war`
   - Memory: 512MB new gen, 1GB heap

## Prerequisites

- Java Runtime Environment (JRE) installed and available in PATH
- All JAR/WAR files must be in the same directory as the script
- Windows operating system with WMIC support
- Administrator privileges may be required for process termination

## Usage

### Start All Services

```batch
manage-petrel.bat start ALL
```

### Stop All Services

```batch
manage-petrel.bat stop ALL
```

### Start Individual Service

```batch
manage-petrel.bat start register
manage-petrel.bat start user
manage-petrel.bat start game
manage-petrel.bat start lobby
manage-petrel.bat start slots
manage-petrel.bat start web
```

### Stop Individual Service

```batch
manage-petrel.bat stop register
manage-petrel.bat stop user
manage-petrel.bat stop game
manage-petrel.bat stop lobby
manage-petrel.bat stop slots
manage-petrel.bat stop web
```

## How It Works

### Starting Services

When starting a service, the script:
1. Uses the `start` command to launch Java in a new window
2. Applies service-specific JVM memory settings
3. Runs the JAR/WAR file with Spring Boot production profile
4. Returns immediately without blocking

### Stopping Services

When stopping a service, the script:
1. Uses WMIC to find all Java processes running the specified JAR/WAR
2. Extracts the Process ID (PID) of matching processes
3. Uses `taskkill /F` to forcefully terminate the process
4. Displays confirmation when the service is killed

## Configuration

### Modifying Memory Settings

Edit the JVM parameters in the script's `:start_service` calls:
- `-Xmn`: New generation heap size
- `-Xms`: Initial heap size
- `-Xmx`: Maximum heap size

Example:
```batch
call :start_service "%userjar%" "-Xmn512m -Xms1024m -Xmx1024m"
```

### Modifying Service Configuration

Additional Spring Boot parameters can be added to the JVM parameters string:
```batch
call :start_service "%lobbyjar%" "-Xmn512m -Xms1024m -Xmx1024m --zebra.ip.out=192.168.1.100 --zebra.port=9090"
```

### Changing Spring Profile

The script uses `--spring.profiles.active=prod` by default. To change this, modify the `:start_service` subroutine.

## Troubleshooting

### Services Don't Start

- Verify Java is installed: `java -version`
- Check that JAR/WAR files exist in the script directory
- Ensure ports are not already in use
- Check if you have sufficient memory available

### Services Don't Stop

- Run Command Prompt as Administrator
- Manually find processes: `wmic process where "CommandLine like '%petrel%'" get ProcessId,CommandLine`
- Manually kill: `taskkill /PID <pid> /F`

### Process Remains After Stop

The WMIC query may need adjustment if:
- Process name contains special characters
- Multiple versions of the same JAR are running

## Technical Details

### Start Service Subroutine

```batch
:start_service
echo Starting %~1 ...
start "" java %~2 -jar %~1 --spring.profiles.active=prod
goto :eof
```

Parameters:
- `%~1`: JAR/WAR filename
- `%~2`: JVM parameters and application arguments

### Stop Service Subroutine

```batch
:stop_service
set "PROC_NAME=%~1"
for /f "tokens=2" %%a in ('wmic process where "CommandLine like '%%%PROC_NAME%%%' and not CommandLine like '%%wmic%%'" get ProcessId ^| findstr [0-9]') do (
    taskkill /PID %%a /F
    echo %PROC_NAME% killed!
)
goto :eof
```

The WMIC query:
- Finds processes where CommandLine contains the JAR/WAR name
- Excludes the WMIC process itself
- Extracts only the ProcessId column
- Filters for numeric PIDs

## License

This script is part of the Caipiaowan project.
