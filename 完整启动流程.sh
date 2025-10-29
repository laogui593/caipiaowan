#!/bin/bash

# ================================================================
# 彩票系统完整启动脚本（标准流程）
# ================================================================
#
# 启动顺序：
# 1. Redis
# 2. Nacos
# 3. Petrel 服务（多个 JAR）
# 4. PHP Web 服务（7180, 7170）
# 5. Workerman WebSocket 服务
#
# ================================================================

set +e

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
MAGENTA='\033[0;35m'
NC='\033[0m'

WORKDIR=$(pwd)

# 配置
REDIS_PORT=6379
NACOS_PORT=6878  # Nacos 自定义端口
FRONTEND_PORT=7180
BACKEND_PORT=7170

# Petrel JAR 文件
REGISTER_JAR="petrel-kernel-register-1.0-SNAPSHOT-boot.jar"
USER_JAR="petrel-kernel-user-1.0-SNAPSHOT-boot.jar"
GAME_JAR="petrel-kernel-game-1.0-SNAPSHOT-boot.jar"
LOBBY_JAR="petrel-game-lobby-1.0-SNAPSHOT-boot.jar"
SLOTS_JAR="petrel-game-slots-1.0-SNAPSHOT-boot.jar"
WEB_JAR="petrel-cms-web-1.0-SNAPSHOT.war"

# 日志函数
log_success() { echo -e "${GREEN}[✓]${NC} $1"; }
log_info() { echo -e "${BLUE}[ℹ]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[!]${NC} $1"; }
log_error() { echo -e "${RED}[✗]${NC} $1"; }
log_step() { echo -e "${CYAN}[→]${NC} $1"; }
log_header() { echo -e "${MAGENTA}$1${NC}"; }

# 显示横幅
show_banner() {
    clear
    echo -e "${MAGENTA}"
    cat << 'EOF'
╔════════════════════════════════════════════════════════════╗
║                                                            ║
║      彩票系统完整启动脚本（标准流程）                    ║
║                                                            ║
╚════════════════════════════════════════════════════════════╝
EOF
    echo -e "${NC}"
    echo -e "${CYAN}启动顺序：Redis → Nacos → Petrel → PHP → WebSocket${NC}"
    echo -e "${CYAN}时间：$(date '+%Y-%m-%d %H:%M:%S')${NC}"
    echo ""
}

# ================================================================
# 第1步：启动 Redis
# ================================================================
start_redis() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "第1步：启动 Redis"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    # 检查 Redis 是否已安装
    if ! command -v redis-server &> /dev/null; then
        log_warn "Redis 未安装，尝试安装..."
        sudo apt-get update && sudo apt-get install -y redis-server || {
            log_error "Redis 安装失败"
            log_info "请手动安装：sudo apt-get install redis-server"
            return 1
        }
    fi
    
    # 检查 Redis 是否已运行
    if pgrep -x redis-server > /dev/null; then
        log_info "Redis 已在运行"
        return 0
    fi
    
    # 启动 Redis
    log_step "启动 Redis 服务..."
    redis-server --daemonize yes --port $REDIS_PORT
    sleep 2
    
    # 验证
    if redis-cli -p $REDIS_PORT ping | grep -q PONG; then
        log_success "Redis 启动成功（端口：$REDIS_PORT）"
    else
        log_error "Redis 启动失败"
        return 1
    fi
}

# ================================================================
# 第2步：启动 Nacos
# ================================================================
start_nacos() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "第2步：启动 Nacos"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    # 查找 Nacos 目录
    NACOS_HOME=""
    if [ -d "./nacos" ]; then
        NACOS_HOME="./nacos"
    elif [ -d "../nacos" ]; then
        NACOS_HOME="../nacos"
    elif [ -d "/opt/nacos" ]; then
        NACOS_HOME="/opt/nacos"
    fi
    
    if [ -z "$NACOS_HOME" ]; then
        log_warn "Nacos 未找到"
        log_info "如果需要 Nacos，请下载并解压到当前目录或 /opt/"
        log_info "下载地址：https://github.com/alibaba/nacos/releases"
        return 1
    fi
    
    log_info "找到 Nacos：$NACOS_HOME"
    
    # 检查是否已运行
    if curl -s http://localhost:$NACOS_PORT/nacos/ > /dev/null 2>&1; then
        log_info "Nacos 已在运行"
        return 0
    fi
    
    # 启动 Nacos
    log_step "启动 Nacos 服务..."
    cd "$NACOS_HOME/bin"
    bash startup.sh -m standalone > /dev/null 2>&1 &
    cd "$WORKDIR"
    
    # 等待启动
    log_info "等待 Nacos 启动（可能需要30秒）..."
    for i in {1..30}; do
        if curl -s http://localhost:$NACOS_PORT/nacos/ > /dev/null 2>&1; then
            log_success "Nacos 启动成功（端口：$NACOS_PORT）"
            log_info "Nacos 控制台：http://localhost:$NACOS_PORT/nacos/"
            log_info "默认用户名/密码：nacos/nacos"
            return 0
        fi
        sleep 1
    done
    
    log_error "Nacos 启动超时"
    return 1
}

# ================================================================
# 第3步：启动 Petrel 服务
# ================================================================
start_petrel_services() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "第3步：启动 Petrel 服务"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    # 检查 Java 是否安装
    if ! command -v java &> /dev/null; then
        log_error "Java 未安装"
        log_info "请安装 Java：sudo apt-get install openjdk-11-jdk"
        return 1
    fi
    
    JAVA_VERSION=$(java -version 2>&1 | head -n 1)
    log_info "Java 版本：$JAVA_VERSION"
    
    # 检查 JAR 文件是否存在
    local jar_found=0
    for jar in "$REGISTER_JAR" "$USER_JAR" "$GAME_JAR" "$LOBBY_JAR" "$SLOTS_JAR" "$WEB_JAR"; do
        if [ -f "$jar" ]; then
            jar_found=1
            break
        fi
    done
    
    if [ $jar_found -eq 0 ]; then
        log_warn "未找到 Petrel JAR 文件"
        log_info "如果项目不需要 Petrel 服务，可以跳过此步骤"
        return 1
    fi
    
    # 启动各个服务
    start_jar_service() {
        local jar=$1
        local jvm_opts=$2
        local extra_opts=$3
        
        if [ ! -f "$jar" ]; then
            log_warn "文件不存在：$jar"
            return 1
        fi
        
        log_step "启动 $jar..."
        nohup java $jvm_opts -jar $jar --spring.profiles.active=prod $extra_opts > "logs/${jar%.jar}.log" 2>&1 &
        echo $! > "logs/${jar%.jar}.pid"
        log_success "$jar 已启动"
    }
    
    # 创建日志目录
    mkdir -p logs
    
    # 按顺序启动服务
    if [ -f "$REGISTER_JAR" ]; then
        start_jar_service "$REGISTER_JAR" "-Xmn200m -Xms400m -Xmx400m"
        sleep 5  # 等待注册中心启动
    fi
    
    if [ -f "$USER_JAR" ]; then
        start_jar_service "$USER_JAR" "-Xmn512m -Xms1024m -Xmx1024m"
        sleep 3
    fi
    
    if [ -f "$GAME_JAR" ]; then
        start_jar_service "$GAME_JAR" "-Xmn512m -Xms1024m -Xmx1024m"
        sleep 3
    fi
    
    if [ -f "$LOBBY_JAR" ]; then
        start_jar_service "$LOBBY_JAR" "-Xmn512m -Xms1024m -Xmx1024m" "--zebra.ip.out=122.114.55.213 --zebra.port=8989"
        sleep 3
    fi
    
    if [ -f "$SLOTS_JAR" ]; then
        start_jar_service "$SLOTS_JAR" "-Xmn512m -Xms1024m -Xmx1024m" "--zebra.ip.out=122.114.55.213"
        sleep 3
    fi
    
    if [ -f "$WEB_JAR" ]; then
        start_jar_service "$WEB_JAR" "-Xmn512m -Xms1024m -Xmx1024m"
    fi
    
    log_success "Petrel 服务启动完成"
}

# ================================================================
# 第4步：启动 PHP Web 服务
# ================================================================
start_php_services() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "第4步：启动 PHP Web 服务"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    # 设置权限
    log_step "设置目录权限..."
    mkdir -p Runtime/Cache Runtime/Temp Runtime/Logs
    chmod -R 777 Runtime Uploads up_files 2>/dev/null || true
    
    # 清理缓存
    log_step "清理缓存..."
    rm -rf Runtime/Cache/* Runtime/Temp/* 2>/dev/null || true
    
    # 启动前端服务 (7180)
    log_step "启动前端API服务（端口 $FRONTEND_PORT）..."
    nohup php -S 0.0.0.0:$FRONTEND_PORT -t . > frontend_$FRONTEND_PORT.log 2>&1 &
    echo $! > frontend_$FRONTEND_PORT.pid
    sleep 2
    log_success "前端API服务已启动"
    
    # 启动后台服务 (7170)
    log_step "启动后台管理服务（端口 $BACKEND_PORT）..."
    nohup php -S 0.0.0.0:$BACKEND_PORT -t . > backend_$BACKEND_PORT.log 2>&1 &
    echo $! > backend_$BACKEND_PORT.pid
    sleep 2
    log_success "后台管理服务已启动"
}

# ================================================================
# 第5步：启动 Workerman WebSocket 服务
# ================================================================
start_websocket_services() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "第5步：启动 Workerman WebSocket 服务"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    if [ -f "server.php" ]; then
        log_step "启动 Workerman 服务..."
        php server.php start -d
        sleep 2
        log_success "Workerman WebSocket 服务已启动"
    else
        log_warn "未找到 server.php，跳过 WebSocket 启动"
    fi
}

# ================================================================
# 第6步：注册服务到 Nacos
# ================================================================
register_to_nacos() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "第6步：注册服务到 Nacos"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    if [ -f "nacos_register.php" ]; then
        log_step "注册 PHP 服务到 Nacos..."
        php nacos_register.php register all
        
        log_step "启动 Nacos 心跳守护进程..."
        nohup php nacos_register.php daemon > nacos_heartbeat.log 2>&1 &
        echo $! > nacos_heartbeat.pid
        log_success "服务已注册到 Nacos"
    else
        log_warn "未找到 nacos_register.php，跳过 Nacos 注册"
    fi
}

# ================================================================
# 显示系统状态
# ================================================================
show_status() {
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_header "系统状态"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    echo ""
    echo -e "${GREEN}✓ 基础服务：${NC}"
    
    # Redis
    if redis-cli -p $REDIS_PORT ping 2>/dev/null | grep -q PONG; then
        echo -e "  Redis:      ${GREEN}运行中${NC} (端口：$REDIS_PORT)"
    else
        echo -e "  Redis:      ${RED}未运行${NC}"
    fi
    
    # Nacos
    if curl -s http://localhost:$NACOS_PORT/nacos/ > /dev/null 2>&1; then
        echo -e "  Nacos:      ${GREEN}运行中${NC} (端口：$NACOS_PORT)"
    else
        echo -e "  Nacos:      ${RED}未运行${NC}"
    fi
    
    echo ""
    echo -e "${GREEN}✓ PHP Web 服务：${NC}"
    echo -e "  前端API:    http://localhost:$FRONTEND_PORT"
    echo -e "  后台管理:   http://localhost:$BACKEND_PORT"
    
    echo ""
    echo -e "${GREEN}✓ 日志文件：${NC}"
    echo -e "  前端日志:   frontend_$FRONTEND_PORT.log"
    echo -e "  后台日志:   backend_$BACKEND_PORT.log"
    if [ -d "logs" ]; then
        echo -e "  Petrel日志: logs/*.log"
    fi
    
    echo ""
    echo -e "${YELLOW}管理命令：${NC}"
    echo -e "  停止所有服务: ./stop_all_services.sh"
    echo -e "  查看状态:     ./check_status.sh"
    echo ""
}

# ================================================================
# 主函数
# ================================================================
main() {
    show_banner
    
    start_redis
    echo ""
    
    start_nacos
    echo ""
    
    start_petrel_services
    echo ""
    
    start_php_services
    echo ""
    
    start_websocket_services
    echo ""
    
    register_to_nacos
    echo ""
    
    show_status
    
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    log_success "系统启动完成！"
    log_header "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
}

# 执行主函数
main
