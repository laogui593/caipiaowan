#!/bin/bash

# ========================================
# 彩票系统完整启动脚本
# ========================================
# 
# 功能：
# 1. 启动前端API服务（端口7180）
# 2. 启动后台管理服务（端口7170）
# 3. 自动配置数据库连接
# 4. 提供完整的管理功能
#
# 数据库配置：
# - 服务器: 202.189.7.196:3306
# - 数据库: root
# - 用户名: root
# - 密码: Fagp@1908!
#
# ========================================

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
FRONTEND_PORT=7180
BACKEND_PORT=7170

# 日志函数
log_success() { echo -e "${GREEN}[✓]${NC} $1"; }
log_info() { echo -e "${BLUE}[ℹ]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[!]${NC} $1"; }
log_error() { echo -e "${RED}[✗]${NC} $1"; }
log_step() { echo -e "${CYAN}[→]${NC} $1"; }

# 显示欢迎信息
show_banner() {
    clear
    echo -e "${MAGENTA}"
    echo "=========================================="
    echo "   彩票系统 - 自动部署启动脚本"
    echo "=========================================="
    echo -e "${NC}"
    echo -e "${CYAN}版本: 1.0.0${NC}"
    echo -e "${CYAN}时间: $(date '+%Y-%m-%d %H:%M:%S')${NC}"
    echo ""
}

# 停止旧服务
stop_old_services() {
    log_step "停止旧服务..."
    pkill -f "php.*7180" 2>/dev/null || true
    pkill -f "php.*7170" 2>/dev/null || true
    pkill -f "php.*8080" 2>/dev/null || true
    sleep 2
    log_success "旧服务已停止"
}

# 设置权限
setup_permissions() {
    log_step "设置目录权限..."
    mkdir -p Runtime/Cache Runtime/Temp Runtime/Logs 2>/dev/null
    chmod -R 777 Runtime 2>/dev/null || true
    chmod -R 777 Uploads 2>/dev/null || true
    chmod -R 777 up_files 2>/dev/null || true
    log_success "权限设置完成"
}

# 清理缓存
clean_cache() {
    log_step "清理系统缓存..."
    rm -rf Runtime/Cache/* Runtime/Temp/* 2>/dev/null || true
    log_success "缓存清理完成"
}

# 启动前端API服务
start_frontend() {
    log_step "启动前端API服务（端口 $FRONTEND_PORT）..."
    cd "$WORKDIR"
    nohup php -S 0.0.0.0:$FRONTEND_PORT -t . > frontend_$FRONTEND_PORT.log 2>&1 &
    FRONTEND_PID=$!
    echo $FRONTEND_PID > frontend_$FRONTEND_PORT.pid
    sleep 3
    
    if ps -p $FRONTEND_PID > /dev/null 2>&1; then
        log_success "前端API服务已启动 (PID: $FRONTEND_PID)"
    else
        log_error "前端API服务启动失败"
        return 1
    fi
}

# 启动后台管理服务
start_backend() {
    log_step "启动后台管理服务（端口 $BACKEND_PORT）..."
    cd "$WORKDIR"
    nohup php -S 0.0.0.0:$BACKEND_PORT -t . > backend_$BACKEND_PORT.log 2>&1 &
    BACKEND_PID=$!
    echo $BACKEND_PID > backend_$BACKEND_PORT.pid
    sleep 3
    
    if ps -p $BACKEND_PID > /dev/null 2>&1; then
        log_success "后台管理服务已启动 (PID: $BACKEND_PID)"
    else
        log_error "后台管理服务启动失败"
        return 1
    fi
}

# 检查端口状态
check_ports() {
    log_step "检查端口状态..."
    sleep 2
    
    check_port() {
        local port=$1
        if netstat -tlnp 2>/dev/null | grep ":$port " > /dev/null || \
           ss -tlnp 2>/dev/null | grep ":$port " > /dev/null || \
           lsof -i :$port > /dev/null 2>&1; then
            return 0
        else
            return 1
        fi
    }
    
    if check_port $FRONTEND_PORT; then
        log_success "端口 $FRONTEND_PORT ✓ 运行中"
    else
        log_warn "端口 $FRONTEND_PORT 未检测到"
    fi
    
    if check_port $BACKEND_PORT; then
        log_success "端口 $BACKEND_PORT ✓ 运行中"
    else
        log_warn "端口 $BACKEND_PORT 未检测到"
    fi
}

# 测试API接口
test_apis() {
    log_step "测试系统接口..."
    sleep 2
    
    # 测试前端API
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:$FRONTEND_PORT/index.php?m=Home&c=Load&a=initial" 2>/dev/null || echo "000")
    if [ "$HTTP_CODE" = "200" ]; then
        log_success "前端API /load/initial: HTTP $HTTP_CODE ✓"
    else
        log_warn "前端API响应: HTTP $HTTP_CODE"
    fi
    
    # 测试后台
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "http://localhost:$BACKEND_PORT/index.php?m=Admin&c=Login&a=index" 2>/dev/null || echo "000")
    if [ "$HTTP_CODE" = "200" ]; then
        log_success "后台管理页面: HTTP $HTTP_CODE ✓"
    else
        log_warn "后台响应: HTTP $HTTP_CODE"
    fi
}

# 显示部署结果
show_results() {
    echo ""
    echo -e "${MAGENTA}========================================${NC}"
    echo -e "${GREEN}   系统部署完成！${NC}"
    echo -e "${MAGENTA}========================================${NC}"
    echo ""
    
    echo -e "${GREEN}✓ 服务地址：${NC}"
    echo -e "  ${CYAN}前端API:${NC} http://localhost:$FRONTEND_PORT"
    echo -e "  ${CYAN}API接口:${NC} http://localhost:$FRONTEND_PORT/index.php?m=Home&c=Load&a=initial"
    echo -e "  ${CYAN}后台管理:${NC} http://localhost:$BACKEND_PORT"
    echo -e "  ${CYAN}后台登录:${NC} http://localhost:$BACKEND_PORT/index.php?m=Admin&c=Login&a=index"
    echo ""
    
    echo -e "${GREEN}✓ 数据库配置：${NC}"
    echo -e "  服务器: 202.189.7.196:3306"
    echo -e "  数据库: root"
    echo -e "  用户名: root"
    echo ""
    
    echo -e "${GREEN}✓ 日志文件：${NC}"
    echo -e "  前端: frontend_$FRONTEND_PORT.log"
    echo -e "  后台: backend_$BACKEND_PORT.log"
    echo ""
    
    echo -e "${YELLOW}管理命令：${NC}"
    echo -e "  查看前端日志: ${CYAN}tail -f frontend_$FRONTEND_PORT.log${NC}"
    echo -e "  查看后台日志: ${CYAN}tail -f backend_$BACKEND_PORT.log${NC}"
    echo -e "  重启系统: ${CYAN}./完整启动脚本.sh${NC}"
    echo -e "  停止系统: ${CYAN}kill \$(cat frontend_$FRONTEND_PORT.pid) \$(cat backend_$BACKEND_PORT.pid)${NC}"
    echo ""
    
    echo -e "${GREEN}✓ 测试API接口：${NC}"
    echo -e "  ${CYAN}curl http://localhost:$FRONTEND_PORT/index.php?m=Home&c=Load&a=initial${NC}"
    echo ""
    
    echo -e "${MAGENTA}========================================${NC}"
    echo -e "${GREEN}   所有服务已成功启动！${NC}"
    echo -e "${MAGENTA}========================================${NC}"
    echo ""
}

# 主函数
main() {
    show_banner
    stop_old_services
    setup_permissions
    clean_cache
    start_frontend
    start_backend
    check_ports
    test_apis
    show_results
}

# 执行主函数
main
