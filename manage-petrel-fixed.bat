@echo off
REM 一键启动/停止所有 jar，无变量冲突

set "registerjar=petrel-kernel-register-1.0-SNAPSHOT-boot.jar"
set "userjar=petrel-kernel-user-1.0-SNAPSHOT-boot.jar"
set "gamejar=petrel-kernel-game-1.0-SNAPSHOT-boot.jar"
set "lobbyjar=petrel-game-lobby-1.0-SNAPSHOT-boot.jar"
set "slotsjar=petrel-game-slots-1.0-SNAPSHOT-boot.jar"
set "webjar=petrel-cms-web-1.0-SNAPSHOT.war"

REM 启动所有服务
if /i "%1"=="start" (
    if /i "%2"=="ALL" (
        call :start_service "%registerjar%" "-Xmn200m -Xms400m -Xmx400m"
        call :start_service "%userjar%" "-Xmn512m -Xms1024m -Xmx1024m"
        call :start_service "%gamejar%" "-Xmn512m -Xms1024m -Xmx1024m"
        call :start_service "%lobbyjar%" "-Xmn512m -Xms1024m -Xmx1024m --zebra.ip.out=122.114.55.213 --zebra.port=8989"
        call :start_service "%slotsjar%" "-Xmn512m -Xms1024m -Xmx1024m --zebra.ip.out=122.114.55.213"
        call :start_service "%webjar%" "-Xmn512m -Xms1024m -Xmx1024m"
        echo All services started!
        exit /b 0
    )
    if /i "%2"=="register" call :start_service "%registerjar%" "-Xmn200m -Xms400m -Xmx400m"
    if /i "%2"=="user" call :start_service "%userjar%" "-Xmn512m -Xms1024m -Xmx1024m"
    if /i "%2"=="game" call :start_service "%gamejar%" "-Xmn512m -Xms1024m -Xmx1024m"
    if /i "%2"=="lobby" call :start_service "%lobbyjar%" "-Xmn512m -Xms1024m -Xmx1024m --zebra.ip.out=122.114.55.213 --zebra.port=8989"
    if /i "%2"=="slots" call :start_service "%slotsjar%" "-Xmn512m -Xms1024m -Xmx1024m --zebra.ip.out=122.114.55.213"
    if /i "%2"=="web" call :start_service "%webjar%" "-Xmn512m -Xms1024m -Xmx1024m"
    exit /b 0
)

REM 停止所有服务
if /i "%1"=="stop" (
    if /i "%2"=="ALL" (
        call :stop_service "%registerjar%"
        call :stop_service "%userjar%"
        call :stop_service "%gamejar%"
        call :stop_service "%lobbyjar%"
        call :stop_service "%slotsjar%"
        call :stop_service "%webjar%"
        echo All services stopped!
        exit /b 0
    )
    if /i "%2"=="register" call :stop_service "%registerjar%"
    if /i "%2"=="user" call :stop_service "%userjar%"
    if /i "%2"=="game" call :stop_service "%gamejar%"
    if /i "%2"=="lobby" call :stop_service "%lobbyjar%"
    if /i "%2"=="slots" call :stop_service "%slotsjar%"
    if /i "%2"=="web" call :stop_service "%webjar%"
    exit /b 0
)

REM 用法提示
echo Usage: manage-petrel.bat start|stop ALL|register|user|game|lobby|slots|web
exit /b 1

:start_service
REM 启动服务（参数1是jar，参数2是jvm参数+其它）
echo Starting %~1 ...
start "" java %~2 -jar %~1 --spring.profiles.active=prod
goto :eof

:stop_service
REM 关闭服务（根据 jar 文件名，单独 kill）
set "PROC_NAME=%~1"
for /f "tokens=2" %%a in ('wmic process where "CommandLine like '%%%PROC_NAME%%%' and not CommandLine like '%%wmic%%'" get ProcessId ^| findstr [0-9]') do (
    taskkill /PID %%a /F
    echo %PROC_NAME% killed!
)
goto :eof
