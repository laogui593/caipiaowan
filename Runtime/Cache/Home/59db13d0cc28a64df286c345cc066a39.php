<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title><?php echo C('sitename');?> - 重庆时时彩</title>
    <meta name="renderer" content="webkit">
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="0">
    
    <style>
        /* ========== 全局样式重置 ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #5a3d7a 100%);
            min-height: 100vh;
            overflow-x: hidden;
            padding-bottom: 70px;
        }
        
        /* ========== 顶部用户信息栏 ========== */
        .top-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 15px 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: slideDown 0.5s ease;
        }
        
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .back-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .back-btn:hover {
            transform: translateX(-3px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .header-title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            flex: 1;
            text-align: center;
        }
        
        .header-actions {
            display: flex;
            gap: 10px;
        }
        
        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }
        
        .icon-btn:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
        }
        
        /* ========== 主容器 ========== */
        .main-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        /* ========== 开奖信息卡片 ========== */
        .lottery-info-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .user-balance-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f7fafc;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: 3px solid #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .user-details h3 {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .user-balance {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
        }
        
        .countdown-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .countdown-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .countdown-title {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .countdown-timer {
            font-size: 42px;
            font-weight: 700;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .latest-result {
            margin-top: 20px;
            padding: 20px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border: 2px solid rgba(102, 126, 234, 0.2);
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .result-period {
            font-size: 14px;
            color: #718096;
            font-weight: 600;
        }
        
        .toggle-history {
            color: #667eea;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }
        
        .toggle-history:hover {
            transform: translateX(3px);
        }
        
        .result-numbers {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .result-ball {
            width: 45px;
            height: 45px;
            line-height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            animation: bounce 0.5s ease;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .result-tags {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .result-tag {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
        }
        
        .history-list {
            display: none;
            margin-top: 15px;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .history-item {
            padding: 15px;
            background: white;
            border-radius: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .history-item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .history-period {
            font-size: 13px;
            color: #718096;
            font-weight: 600;
        }
        
        .history-numbers {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
        }
        
        .history-ball {
            width: 32px;
            height: 32px;
            line-height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }
        
        .history-tags {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .history-tag {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }
        
        /* ========== 公告栏 ========== */
        .notice-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 12px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            overflow: hidden;
        }
        
        .notice-icon {
            font-size: 20px;
            color: #667eea;
            animation: ring 2s ease-in-out infinite;
        }
        
        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-10deg); }
            20%, 40% { transform: rotate(10deg); }
        }
        
        .notice-content {
            flex: 1;
            overflow: hidden;
            height: 20px;
            line-height: 20px;
        }
        
        .notice-text {
            display: block;
            animation: marquee 15s linear infinite;
            white-space: nowrap;
        }
        
        @keyframes marquee {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }
        
        /* ========== 投注区域 ========== */
        .betting-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.7s ease;
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #ff6b6b;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-title::before {
            content: '';
            width: 8px;
            height: 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }
        
        .position-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        
        .position-tab {
            padding: 12px 20px;
            border: none;
            border-radius: 15px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            min-width: 100px;
        }
        
        .position-tab:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }
        
        .position-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .bet-options-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
        }
        
        .bet-option {
            aspect-ratio: 1;
            border: 2px solid #fee;
            border-radius: 15px;
            background: white;
            color: #2d3748;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        
        .bet-option:hover {
            transform: scale(1.05);
            border-color: #667eea;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }
        
        .bet-option.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .bet-option.selected::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        
        .bet-label {
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .bet-odds {
            font-size: 11px;
            opacity: 0.7;
        }
        
        /* ========== 聊天记录区域 ========== */
        .chat-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.8s ease;
        }
        
        .chat-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .chat-item {
            margin-bottom: 15px;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .chat-notice {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 15px;
            text-align: center;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .chat-message {
            display: flex;
            gap: 12px;
            padding: 12px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .chat-message:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(3px);
        }
        
        .chat-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid #667eea;
            flex-shrink: 0;
        }
        
        .chat-content {
            flex: 1;
        }
        
        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .chat-username {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .chat-time {
            font-size: 12px;
            color: #a0aec0;
        }
        
        .chat-bet-info {
            font-size: 13px;
            color: #4a5568;
        }
        
        .chat-bet-period {
            display: block;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .chat-bet-type {
            color: #667eea;
            font-weight: 600;
        }
        
        /* ========== 底部浮动栏 ========== */
        .bet-float-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        
        .float-actions {
            display: flex;
            gap: 10px;
            width: 100%;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 25px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }
        
        .btn-secondary {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        /* ========== 投注弹窗 ========== */
        .bet-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            z-index: 2000;
        }
        
        .bet-modal {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-radius: 25px 25px 0 0;
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
            z-index: 2001;
            animation: slideUpModal 0.4s ease;
        }
        
        @keyframes slideUpModal {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f7fafc;
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
        }
        
        .modal-close {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e74c3c;
            color: white;
            border: none;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .modal-close:hover {
            transform: rotate(90deg);
        }
        
        .bet-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .amount-input-group {
            margin: 20px 0;
        }
        
        .amount-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .amount-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .amount-input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .quick-amounts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .amount-chip {
            padding: 12px;
            border: 2px solid #e8ebf9;
            border-radius: 12px;
            background: white;
            color: #667eea;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .amount-chip:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }
        
        .modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        .modal-actions .btn {
            padding: 15px;
            font-size: 16px;
        }
        
        /* ========== 响应式设计 ========== */
        @media (max-width: 768px) {
            .main-container {
                padding: 0 15px;
            }
            
            .lottery-info-card,
            .betting-card,
            .chat-card {
                padding: 20px 15px;
                border-radius: 20px;
            }
            
            .user-balance-section {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .countdown-timer {
                font-size: 36px;
            }
            
            .result-ball {
                width: 40px;
                height: 40px;
                line-height: 40px;
                font-size: 18px;
            }
            
            .position-tabs {
                gap: 8px;
            }
            
            .position-tab {
                padding: 10px 16px;
                font-size: 13px;
                min-width: 80px;
            }
            
            .bet-options-grid {
                grid-template-columns: repeat(5, 1fr);
                gap: 8px;
            }
            
            .bet-option {
                font-size: 16px;
                padding: 8px;
            }
            
            .bet-label {
                font-size: 14px;
            }
            
            .bet-odds {
                font-size: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .header-title {
                font-size: 16px;
            }
            
            .back-btn,
            .icon-btn {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }
            
            .result-ball {
                width: 35px;
                height: 35px;
                line-height: 35px;
                font-size: 16px;
            }
            
            .bet-options-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* ========== 开奖加载动画 ========== */
        .lottery-loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .lottery-loading-overlay.active {
            display: flex;
        }
        
        .loading-container {
            text-align: center;
            animation: fadeInScale 0.5s ease;
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .loading-balls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .loading-ball {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a0000 0%, #8b0000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 28px;
            font-weight: 700;
            box-shadow: 0 8px 30px rgba(139, 0, 0, 0.6),
                        inset 0 -5px 15px rgba(0, 0, 0, 0.4),
                        inset 0 5px 15px rgba(255, 255, 255, 0.1);
            animation: ballPulse 1.5s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }
        
        .loading-ball::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 20%;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .loading-ball:nth-child(1) { animation-delay: 0s; }
        .loading-ball:nth-child(2) { animation-delay: 0.1s; }
        .loading-ball:nth-child(3) { animation-delay: 0.2s; }
        .loading-ball:nth-child(4) { animation-delay: 0.3s; }
        .loading-ball:nth-child(5) { animation-delay: 0.4s; }
        
        @keyframes ballPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 8px 30px rgba(139, 0, 0, 0.6),
                            inset 0 -5px 15px rgba(0, 0, 0, 0.4),
                            inset 0 5px 15px rgba(255, 255, 255, 0.1);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 12px 40px rgba(255, 107, 107, 0.8),
                            inset 0 -5px 15px rgba(0, 0, 0, 0.3),
                            inset 0 5px 15px rgba(255, 255, 255, 0.2);
            }
        }
        
        .loading-spinner {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            position: relative;
        }
        
        .loading-spinner::before,
        .loading-spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
        }
        
        .loading-spinner::before {
            width: 100%;
            height: 100%;
            border: 4px solid transparent;
            border-top-color: #667eea;
            border-right-color: #667eea;
            animation: spinFast 1s linear infinite;
        }
        
        .loading-spinner::after {
            width: 70%;
            height: 70%;
            top: 15%;
            left: 15%;
            border: 4px solid transparent;
            border-bottom-color: #764ba2;
            border-left-color: #764ba2;
            animation: spinSlow 1.5s linear infinite;
        }
        
        @keyframes spinFast {
            to { transform: rotate(360deg); }
        }
        
        @keyframes spinSlow {
            to { transform: rotate(-360deg); }
        }
        
        .loading-text {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            animation: textGlow 1.5s ease-in-out infinite;
        }
        
        @keyframes textGlow {
            0%, 100% {
                opacity: 0.8;
                text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            }
            50% {
                opacity: 1;
                text-shadow: 0 4px 25px rgba(102, 126, 234, 0.8);
            }
        }
        
        .loading-tags {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .loading-tag {
            padding: 8px 20px;
            border-radius: 20px;
            background: rgba(102, 126, 234, 0.2);
            border: 2px solid rgba(102, 126, 234, 0.4);
            color: white;
            font-size: 16px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            animation: tagFade 1.5s ease-in-out infinite;
        }
        
        .loading-tag:nth-child(1) { animation-delay: 0s; }
        .loading-tag:nth-child(2) { animation-delay: 0.3s; }
        .loading-tag:nth-child(3) { animation-delay: 0.6s; }
        
        @keyframes tagFade {
            0%, 100% {
                opacity: 0.6;
                transform: translateY(0);
            }
            50% {
                opacity: 1;
                transform: translateY(-5px);
            }
        }
        
        .loading-hint {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-top: 20px;
        }
        
        .loading-dots {
            display: inline-block;
        }
        
        .loading-dots::after {
            content: '...';
            animation: dots 1.5s steps(4, end) infinite;
        }
        
        @keyframes dots {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60%, 100% { content: '...'; }
        }
    </style>
</head>
<body onload="connect(15533);">
    <!-- 顶部导航栏 -->
    <div class="top-header">
        <button class="back-btn" onclick="history.go(-1)">←</button>
        <h1 class="header-title">重庆时时彩</h1>
        <div class="header-actions">
            <button class="icon-btn" onclick="location.reload()">🔄</button>
            <button class="icon-btn" onclick="showMask()">💬</button>
        </div>
    </div>

    <!-- 主容器 -->
    <div class="main-container">
        <!-- 开奖信息卡片 -->
        <div class="lottery-info-card">
            <!-- 用户余额部分 -->
            <?php if($userinfo): ?><div class="user-balance-section">
                <div class="user-profile">
                    <img src="<?php echo ($userinfo["headimgurl"]); ?>" class="user-avatar" alt="用户头像" />
                    <div class="user-details">
                        <h3><?php echo ($userinfo["nickname"]); ?></h3>
                        <div class="user-balance">¥<?php echo ($userinfo["points"]); ?></div>
                    </div>
                </div>
            </div><?php endif; ?>
            
            <!-- 倒计时区域 -->
            <div class="countdown-section">
                <div class="countdown-title">距离 <span id="current-period">加载中...</span> 期开奖</div>
                <div class="countdown-timer" id="countdown-display">0</div>
            </div>
            
            <!-- 最新开奖结果 -->
            <div class="latest-result">
                <div class="result-header">
                    <span class="result-period">第 <?php echo ($kjlist[0]["periodnumber"]); ?> 期</span>
                    <span class="toggle-history" onclick="toggleHistory()">
                        <span id="history-toggle-text">查看历史</span> <span id="history-toggle-icon">▼</span>
                    </span>
                </div>
                <div class="result-numbers">
                    <span class="result-ball"><?php echo ($kjlist[0]["a"]); ?></span>
                    <span class="result-ball"><?php echo ($kjlist[0]["b"]); ?></span>
                    <span class="result-ball"><?php echo ($kjlist[0]["c"]); ?></span>
                    <span class="result-ball"><?php echo ($kjlist[0]["d"]); ?></span>
                    <span class="result-ball"><?php echo ($kjlist[0]["e"]); ?></span>
                </div>
                <div class="result-tags">
                    <span class="result-tag"><?php echo ($kjlist[0]["tema_dx"]); ?></span>
                    <span class="result-tag"><?php echo ($kjlist[0]["tema_ds"]); ?></span>
                    <span class="result-tag"><?php echo ($kjlist[0]["lh"]); ?></span>
                </div>
                
                <!-- 历史记录列表 -->
                <div class="history-list" id="history-list">
                    <?php if(is_array($kjlist)): $i = 0; $__LIST__ = array_slice($kjlist,1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="history-item">
                        <div class="history-item-header">
                            <span class="history-period">第 <?php echo ($vo["periodnumber"]); ?> 期</span>
                        </div>
                        <div class="history-numbers">
                            <span class="history-ball"><?php echo ($vo["a"]); ?></span>
                            <span class="history-ball"><?php echo ($vo["b"]); ?></span>
                            <span class="history-ball"><?php echo ($vo["c"]); ?></span>
                            <span class="history-ball"><?php echo ($vo["d"]); ?></span>
                            <span class="history-ball"><?php echo ($vo["e"]); ?></span>
                        </div>
                        <div class="history-tags">
                            <span class="history-tag"><?php echo ($vo["tema_dx"]); ?></span>
                            <span class="history-tag"><?php echo ($vo["tema_ds"]); ?></span>
                            <span class="history-tag"><?php echo ($vo["lh"]); ?></span>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>

        <!-- 公告栏 -->
        <div class="notice-bar">
            <span class="notice-icon">📢</span>
            <div class="notice-content">
                <span class="notice-text"><?php echo C('welcome');?></span>
            </div>
        </div>

        <!-- 投注区域 - 仅登录后显示 -->
        <?php if($userinfo): ?><div class="betting-card">
            <h2 class="card-title">快速投注</h2>
            
            <!-- 位置选择标签 -->
            <div class="position-tabs">
                <button class="position-tab active" data-position="1">第一球(万位)</button>
                <button class="position-tab" data-position="2">第二球(千位)</button>
                <button class="position-tab" data-position="3">第三球(百位)</button>
                <button class="position-tab" data-position="4">第四球(十位)</button>
                <button class="position-tab" data-position="5">第五球(个位)</button>
                <button class="position-tab" data-position="total">总和</button>
            </div>
            
            <!-- 投注选项网格 -->
            <div class="bet-options-grid" id="bet-options-grid">
                <!-- 动态生成投注选项 -->
            </div>
        </div><?php endif; ?>

        <!-- 聊天记录区域 -->
        <div class="chat-card">
            <h2 class="card-title">竞猜记录</h2>
            <div class="chat-list">
                <?php if(is_array($msglist)): $i = 0; $__LIST__ = $msglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['type'] == 'admin' or $vo['type'] == 'system'): ?><div class="chat-item">
                        <div class="chat-notice"><?php echo (stripcslashes(htmlspecialchars_decode($vo["content"]))); ?></div>
                    </div><?php endif; ?>
                    
                    <?php if($vo['type'] == 'say'): $str=trim($vo['content']); if(!empty($str)){ $reg='/(\d{3}(\.\d+)?)/is'; preg_match($reg,$str,$result); $ress = isset($result[0]) ? $result[0] : '0'; $conts = str_replace($ress,"",$str); } ?>
                    <div class="chat-item">
                        <div class="chat-message">
                            <img src="<?php echo ($vo["head_img_url"]); ?>" class="chat-avatar" alt="用户头像" />
                            <div class="chat-content">
                                <div class="chat-header">
                                    <span class="chat-username"><?php echo ($vo["from_client_name"]); ?></span>
                                    <span class="chat-time"><?php echo ($vo["time"]); ?></span>
                                </div>
                                <div class="chat-bet-info">
                                    <span class="chat-bet-period">第 <?=$kjlist[0]['periodnumber']+1?> 期</span>
                                    类型: <span class="chat-bet-type"><?php echo ($conts); ?></span> | 金额: ¥<?php echo ($ress); ?>
                                </div>
                            </div>
                        </div>
                    </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                
                <div class="chat-item">
                    <div class="chat-notice">仅显示前50条竞猜记录</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 底部浮动栏 -->
    <?php if($userinfo): ?><div class="bet-float-bar">
        <div class="float-actions">
            <button class="btn btn-secondary" onclick="window.location.href='/Home/Fen/addpage.html'">充值</button>
            <button class="btn btn-secondary" onclick="window.location.href='/Home/Run/record.html'">记录</button>
            <button class="btn btn-primary" id="show-bet-modal">马上投注</button>
        </div>
    </div><?php endif; ?>

    <!-- 投注弹窗 -->
    <?php if($userinfo): ?><div class="bet-modal-overlay" id="bet-modal-overlay"></div>
    <div class="bet-modal" id="bet-modal">
        <div class="modal-header">
            <h3 class="modal-title">确认投注</h3>
            <button class="modal-close" id="close-modal">×</button>
        </div>
        
        <div class="bet-summary">
            <div style="font-size: 14px; margin-bottom: 10px;">投注信息</div>
            <div style="font-size: 18px;" id="bet-summary-text">
                请选择投注项
            </div>
        </div>
        
        <div class="amount-input-group">
            <label class="amount-label">投注金额（元）</label>
            <input type="number" class="amount-input" id="bet-amount" placeholder="请输入投注金额" value="100" min="1" />
            
            <div class="quick-amounts">
                <button class="amount-chip" data-amount="100">100</button>
                <button class="amount-chip" data-amount="200">200</button>
                <button class="amount-chip" data-amount="500">500</button>
                <button class="amount-chip" data-amount="1000">1000</button>
                <button class="amount-chip" data-amount="2000">2000</button>
                <button class="amount-chip" data-amount="5000">5000</button>
            </div>
        </div>
        
        <div class="modal-actions">
            <button class="btn btn-secondary" id="cancel-bet">取消</button>
            <button class="btn btn-secondary" id="double-bet">双倍</button>
            <button class="btn btn-primary" id="confirm-bet">确认投注</button>
        </div>
    </div><?php endif; ?>

    <!-- 开奖加载动画 -->
    <div class="lottery-loading-overlay" id="lottery-loading">
        <div class="loading-container">
            <div class="loading-balls">
                <div class="loading-ball">5</div>
                <div class="loading-ball">7</div>
                <div class="loading-ball">7</div>
                <div class="loading-ball">9</div>
                <div class="loading-ball">9</div>
            </div>
            
            <div class="loading-spinner"></div>
            
            <div class="loading-text">正在开奖中<span class="loading-dots"></span></div>
            
            <div class="loading-tags">
                <div class="loading-tag">大</div>
                <div class="loading-tag">单</div>
                <div class="loading-tag">龙</div>
            </div>
            
            <div class="loading-hint">请稍候，开奖结果即将揭晓</div>
        </div>
    </div>

    <!-- 客服遮罩 -->
    <div id="mask" class="mask" onclick="hideMask()" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.9); backdrop-filter:blur(10px); z-index:3000; align-items:center; justify-content:center; animation:fadeIn 0.3s ease;">
        <div style="position:relative; max-width:500px; width:90%; text-align:center;" onclick="event.stopPropagation();">
            <button onclick="hideMask();" style="position:absolute; top:-15px; right:-15px; width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); border:none; color:white; font-size:24px; cursor:pointer; box-shadow:0 4px 15px rgba(0,0,0,0.3); transition:all 0.3s ease; z-index:1;">×</button>
            <div style="background:white; padding:40px 30px; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                <div style="width:80px; height:80px; margin:0 auto 20px; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:40px; box-shadow:0 8px 25px rgba(102,126,234,0.4);">📱</div>
                
                <h3 style="color:#2d3748; font-size:24px; font-weight:700; margin-bottom:10px;">联系客服</h3>
                <p style="color:#718096; font-size:14px; margin-bottom:30px;">通过 Telegram 与我们联系</p>
                
                <div style="background:linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(118,75,162,0.1) 100%); padding:25px; border-radius:15px; margin-bottom:25px; border:2px solid rgba(102,126,234,0.2);">
                    <div style="display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:12px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM16.64 8.8C16.49 10.38 15.84 14.22 15.51 15.99C15.37 16.74 15.09 16.99 14.83 17.02C14.25 17.07 13.81 16.64 13.25 16.27C12.37 15.69 11.87 15.33 11.02 14.77C10.03 14.12 10.67 13.76 11.24 13.18C11.39 13.03 13.95 10.7 14 10.49C14.0069 10.4582 14.006 10.4252 13.9973 10.3938C13.9886 10.3624 13.9724 10.3337 13.95 10.31C13.89 10.26 13.81 10.28 13.74 10.29C13.65 10.31 12.25 11.24 9.52 13.08C9.12 13.35 8.76 13.49 8.44 13.48C8.08 13.47 7.4 13.28 6.89 13.11C6.26 12.91 5.77 12.8 5.81 12.45C5.83 12.27 6.08 12.09 6.55 11.9C9.47 10.63 11.41 9.79 12.38 9.39C15.16 8.23 15.73 8.03 16.11 8.03C16.19 8.03 16.38 8.05 16.5 8.15C16.6 8.23 16.63 8.34 16.64 8.42C16.63 8.48 16.65 8.66 16.64 8.8Z" fill="#667eea"/>
                        </svg>
                        <span style="color:#667eea; font-size:16px; font-weight:600;">Telegram</span>
                    </div>
                    <div style="font-size:28px; font-weight:700; color:#2d3748; margin-bottom:10px; letter-spacing:1px;" id="telegram-number">@shicai_kefu</div>
                    <button onclick="copyTelegram()" style="width:100%; padding:12px; border-radius:12px; border:none; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:white; font-size:15px; font-weight:600; cursor:pointer; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(102,126,234,0.3);">
                        <span id="copy-text">📋 点击复制账号</span>
                    </button>
                </div>
                
                <p style="color:#a0aec0; font-size:13px; line-height:1.6;">复制账号后，打开 Telegram 搜索添加<br/>或点击下方按钮直接打开</p>
                
                <a href="https://t.me/shicai_kefu" target="_blank" style="display:inline-block; margin-top:15px; padding:12px 30px; border-radius:25px; background:rgba(102,126,234,0.1); color:#667eea; text-decoration:none; font-size:14px; font-weight:600; transition:all 0.3s ease;">
                    🚀 打开 Telegram
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function copyTelegram() {
            const text = document.getElementById('telegram-number').textContent;
            const copyBtn = document.getElementById('copy-text');
            
            // 复制到剪贴板
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    copyBtn.textContent = '✅ 复制成功！';
                    setTimeout(function() {
                        copyBtn.textContent = '📋 点击复制账号';
                    }, 2000);
                });
            } else {
                // 降级方案
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    copyBtn.textContent = '✅ 复制成功！';
                    setTimeout(function() {
                        copyBtn.textContent = '📋 点击复制账号';
                    }, 2000);
                } catch (err) {
                    copyBtn.textContent = '❌ 复制失败';
                }
                document.body.removeChild(textarea);
            }
        }
    </script>

    <!-- JavaScript -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.js"></script>
    <script src='/Public/Common/js/socket.io.js'></script>
    
    <!-- 推送功能 -->
    <script type="text/javascript">
	var ws, name;

	// 连接服务端
	function connect(port){

		// 创建websocket
		ws = new WebSocket("ws://" + document.domain + ":"+port);
		//console.log(ws);
		// 当socket连接打开时，发送登录信息
		ws.onopen = function(){
			var name = "<?php echo ($userinfo["nickname"]); ?>";
			// 登录
			var userid = "<?php echo ($userinfo["id"]); ?>";
			var login_data = '{"type":"login","client_name":"' + name.replace(/"/g, '\"') + '","client_id":"'+userid+'"}';
			console.log("websocket握手成功，发送登录数据:" + login_data);
			ws.send(login_data);
		};
		// 当有消息时根据消息类型显示不同信息
		ws.onmessage = onmessage;
		ws.onclose = function(){
			console.log("连接关闭，定时重连");
			location.reload();
			connect();
		};
		ws.onerror = function() {
			console.log("出现错误");
		};
	}

	var inte = parseInt(Math.random()*12+1);
	function onmessage(e) {
		var rate = 0;
		var robot_rate = <?php echo C('robot_rate');?> ? <?php echo C('robot_rate');?> : 3;
		
	
		switch(<?php echo C('robot_rate');?>){
			case 5:
				rate = 5;
				break;
			case 4:
				rate = 10;
				break;
			case 3:
				rate = 25;
				break;
			case 2:
				rate = 35;
				break;
			case 1:
				rate = 45;
				break;
			default:
				rate = 25;
				break;
		}
		
		var data = eval("(" + e.data + ")");
		//console.log(data);
		switch(data['type']) {
			
			// 服务端ping客户端
			case 'ping':
				$('#xs').html(data.content+<?php echo C('online');?>);
				ws.send('{"type":"pong"}');
				inte--;
				if(inte==0){
					ws.send('{"type":"robot"}');
					inte = parseInt(Math.random()*rate+1)+2;
				}
				break;
				// 登录 更新用户列表
			case 'login':
				console.log(data['client_name'] + "登录成功");
				break;
				// 发言
			case 'say':
				say(data['uid'],data['from_client_name'], data['head_img_url'], data['content'], data['time']);
				break;
				// 用户退出 更新用户列表
			case 'logout':
				break;
			case 'broadcast':
				//alert('client');
			
				//房管
			case 'admin':
				$("#03").append('<li class="notice"><center>' + data["content"] + '</center></li>');
				//$("#03").append('<p class="bettime">'+data["time"]+'</p>');
				document.getElementById("alert1").innerHTML=data["content"];
				$(".alert1").show();
				setTimeout( "$('.alert1').fadeOut()" , 1000);
				$('html,body').scrollTop($('body')[0].scrollHeight);
				break;
				//系统
			case 'system':
				
				if(data["content"].indexOf("结算已完毕") != -1){

					
				}
				$("#03").append('<li><div><div class="uhead" style="margin-right: 5px;"><img src="' + data["head_img_url"] + '" style="pointer-events: none;"></div><div class="betinfo"><p class="ubet" style=""><span><span class="type"> ' + data["content"] + '</span></span></p></div></div></li>');
				//$("#03").append('<p class="bettime">'+data["time"]+'</p>');
				break;
				//积分减
			case 'points':
				$('#sy').html((parseFloat($('#sy').html())-data['content']).toFixed(1));
				break;
				//积分加
			case 'pointsadd':
				$('#sy').html((parseFloat($('#sy').html())+data['points']).toFixed(1));
				parent.layer.msg('恭喜竞猜成功');
				break;
				//重载
			case 'reload':
				if('<?php echo ($userinfo["id"]); ?>'==9){
					
					window.location.href=window.location.href;
				}
				break;
				//切换
			case 'switch':
				parent.location.reload();
				break;
						
						
			case 'getNumber':
				getMoneyData(data);
				break;
		}
	}

	// 提交对话
	function onSubmit(input) {
		var headimgurl = '<?php echo ($userinfo["headimgurl"]); ?>';
		var from_client_name = '<?php echo ($userinfo["nickname"]); ?>';
		if(input==''){
			//$('#textarea').focus();
			return false;
		}
		var fangjian=$("#fangjian").val();
		if(fangjian=='')fangjian="a";
		console.log(fangjian);
		ws.send('{"type":"say","client_name":"'+from_client_name+'","headimgurl":"'+headimgurl+'","content":"' + input.replace(/"/g, '\"').replace(/n/g, '\n').replace(/r/g, '\r') + '","fangjian":"'+fangjian+'"}');
		//$('#textarea').val('');
		//$('#dialog').scrollTop(0);
		$('html,body').scrollTop($('body')[0].scrollHeight);
	}

	// 发言
	function say(uid, from_client_name, head_img_url, content, time, number) {
	
		let reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
        let html = $('#say').html();
		
		var num = content.replace(/[^0-9]/ig,"-");
		var arr=num.split('-');
		
		var len = arr.length - 1;
			num = arr[len];
		var back = '';
		if('<?php echo ($userinfo["id"]); ?>'==uid){
			back = 'background:#5e8bed; color:#fff;'
		}
		
		var con = content.replace(num,'');
		let source = html.replace(reg, function (node, key) { return {
            time:  time,
            images: head_img_url ,
            username: from_client_name ,
            number: $('.gmfix .line1 b').html() ,
            count: con ,
            nums: num ,
			back: back
        }[key]; });
	
		if('<?php echo ($userinfo["id"]); ?>'==uid){
			$("#03").append($(source));
		}else{
			$("#03").append($(source));
		}

		$('html,body').scrollTop($('body')[0].scrollHeight);
		/*if('<?php echo ($userinfo["id"]); ?>'==uid){
			$("#03").append('<li><div><div class="uhead"><img src="'+head_img_url+'" style= "pointer-events: none;"></div><div class="betinfo"><p class="uname">' + from_client_name +'　　'+time +'</p><p class="ubet"><i class="ico02 timeico"></i>投注内容：' + content + '</p></div></div></li>');
		}else{
			$("#03").append('<li><div><div class="uhead"><img src="'+head_img_url+'" style= "pointer-events: none;"></div><div class"><p class="uname">' + from_client_name +'　　'+time +'</p><p class="ubet"><i class="ico02 timeico"></i>投注内容：' + content + '</p></div></div></li>');
		}*/
	}

	
</script>
<style>
	foot{display:none;}
</style>
<script type='text/html' id="say">
<li>
					<div class="time"><p>[time]</p></div>
						<div>
							<div class="uhead">
								<img src="[images]" style= "pointer-events: none;">
							</div>
							<div class="betinfo">
								<p class="uname">[username]</p>
								<div class="ubet">
									<p class="rase"><img src="/tu/gu.png" alt="">第 <span class="qihao">[number]</span>期</p>
									<p class="title"><span>购买类型</span><span style="float:right">购买金额</span></p>
									<p class="tz_detail"><span class="leixing">[count]</span><span class="jie">[nums]</span></p>
								</div>
							</div>
						</div>
					</li>
 
</script>
<script type='text/html' id="numberss">
	第<i>[numbers]</i>期
	<span class='a[b1]'></span>
	<span class='a[b2]'></span>
	<span class='a[b3]'></span>
	<span class='a[b4]'></span>
	<span class='a[b5]'></span>
	<span class='a[b6]'></span>
	<span class='a[b7]'></span>
	<span class='a[b8]'></span>
	<span class='a[b9]'></span>
	<span class='a[b10]'></span>
	<span class='d'></span>
</script>
<script type='text/html' id="numbersss">
<p><span >[numbers]</span>期开奖结果</p>
				<div class="result">
					<span class="pink">[b1]</span> +
					<span class="purple">[b2]</span> +
					<span class="yellow">[b3]</span>=
					<span class="green">[b4]</span>[tema_ds],[tema_dx]</div>
</script>
<script>
	function get_money(){

		$.ajax({
			url:'/home/user/get_number',
			data:{
				number:'<?php echo ($list[0]["periodnumber"]); ?>',
				type:'<?php echo ($list[0]["game"]); ?>'
				
			},
			success:function(data){
				$('#myMoney').html(data.info.points);
				var now = parseInt(data.info.periodnumber)+1;
				var bef = $('.line1 b').html();
				
				var shos = $('#hqkj').html();
				shos = parseInt(shos)+1;
				if(data.info.over < 0){
					return false;
				}
				
				if(now != bef){
					
					clearInterval(settime);
					 $('.line1 b').html();
					 $('#J_touzhu').attr("disabled",false);
					//$("#J_touzhu").css("background-color","#de6f7e");
					
					if(data.info.game == '幸运飞艇'){
						
						
						let reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
						let html = $('#numberss').html();
						
						strs=data.info.awardnumbers.split(",");
						
						let source = html.replace(reg, function (node, key) { return {
							numbers:  data.info.periodnumber,
							b1:  strs[0],
							b2:  strs[1],
							b3:  strs[2],
							b4:  strs[3],
							b5:  strs[4],
							b6:  strs[5],
							b7:  strs[6],
							b8:  strs[7],
							b9:  strs[8],
							b10: strs[9] ,
						}[key]; });
						
						let lis = '<li>第 <i>'+data.info.periodnumber+'</i> 期<i> &nbsp;<span class="a'+strs[0]+'"></span><span class="a'+strs[1]+'"></span><span class="a'+strs[2]+'"></span> <span class="a'+strs[3]+'"></span> <span class="a'+strs[4]+'"></span> <span class="a'+strs[5]+'"></span> <span class="a'+strs[6]+'"></span> <span class="a'+strs[7]+'"></span> <span class="a'+strs[8]+'"></span> <span class="a'+strs[9]+'"></span></i></li>'
						
						$('.openmo').append($(lis));
						$('#hqkj').html(source);
					}else{
						
						let reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
						let html = $('#numbersss').html();
						
						strs=data.info.awardnumbers.split(",");
						
						
						
						let source = html.replace(reg, function (node, key) { return {
							numbers:  data.info.periodnumber,
							b1:  strs[0],
							b2:  strs[1],
							b3:  strs[2],
							b4:  parseInt(strs[0]) + parseInt(strs[1]) + parseInt(strs[2]),
							tema_ds:  data.info.tema_ds,
							tema_dx:  data.info.tema_dx,
						}[key]; });
						var aa=parseInt(strs[0]) + parseInt(strs[1]) + parseInt(strs[2]);
						let lis = '<li>第 <i>'+data.info.periodnumber+'</i> 期<i> <span class="num">'+strs[0]+'</span> + <span class="num">'+strs[1]+'</span> + <span class="num">'+strs[2]+'</span> = <span class="hong">'+aa+'</span><font style="display:inline-block;width:15px"></font>('+data.info.tema_ds+','+data.info.tema_dx+')</i></li>'
						
						$('.openmo').append($(lis));
						
						$('#hqkj').html(source);
						//$('#hqkj').html(source);
						
					}
					
					
					
					countDown();
					
					//console.log(data);
					
				}else{
					
				}
		
			}
		});
	}
	
	function getMoneyData(data){
		//$('#myMoney').html(data.info.points);
		var now = parseInt(data.info.periodnumber)+1;
		var bef = $('.line1 b').html();
		
		var shos = $('#hqkj').html();
		shos = parseInt(shos)+1;
		if(data.info.over < 0){
			return false;
		}
		
		if(now != bef){
			
			clearInterval(settime);
			 $('.line1 b').html();
			 $('#J_touzhu').attr("disabled",false);
			//$("#J_touzhu").css("background-color","#de6f7e");
			
			if(data.info.game == '幸运飞艇'){
				
				
				let reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
				let html = $('#numberss').html();
				
				strs=data.info.awardnumbers.split(",");
				
				let source = html.replace(reg, function (node, key) { return {
					numbers:  data.info.periodnumber,
					b1:  strs[0],
					b2:  strs[1],
					b3:  strs[2],
					b4:  strs[3],
					b5:  strs[4],
					b6:  strs[5],
					b7:  strs[6],
					b8:  strs[7],
					b9:  strs[8],
					b10: strs[9] ,
				}[key]; });
				
				let lis = '<li>第 <i>'+data.info.periodnumber+'</i> 期<i> &nbsp;<span class="a'+strs[0]+'"></span><span class="a'+strs[1]+'"></span><span class="a'+strs[2]+'"></span> <span class="a'+strs[3]+'"></span> <span class="a'+strs[4]+'"></span> <span class="a'+strs[5]+'"></span> <span class="a'+strs[6]+'"></span> <span class="a'+strs[7]+'"></span> <span class="a'+strs[8]+'"></span> <span class="a'+strs[9]+'"></span></i></li>'
				
				$('.openmo').append($(lis));
				$('#hqkj').html(source);
			}else{
				
				let reg = new RegExp("\\[([^\\[\\]]*?)\\]", 'igm');
				let html = $('#numbersss').html();
				
				strs=data.info.awardnumbers.split(",");
				
				
				
				let source = html.replace(reg, function (node, key) { return {
					numbers:  data.info.periodnumber,
					b1:  strs[0],
					b2:  strs[1],
					b3:  strs[2],
					b4:  parseInt(strs[0]) + parseInt(strs[1]) + parseInt(strs[2]),
					tema_ds:  data.info.tema_ds,
					tema_dx:  data.info.tema_dx,
				}[key]; });
				var aa=parseInt(strs[0]) + parseInt(strs[1]) + parseInt(strs[2]);
				let lis = '<li>第 <i>'+data.info.periodnumber+'</i> 期<i> <span class="num">'+strs[0]+'</span> + <span class="num">'+strs[1]+'</span> + <span class="num">'+strs[2]+'</span> = <span class="hong">'+aa+'</span><font style="display:inline-block;width:15px"></font>('+data.info.tema_ds+','+data.info.tema_dx+')</i></li>'
				
				$('.openmo').append($(lis));
				
				$('#hqkj').html(source);
				//$('#hqkj').html(source);
				
			}
			
			
			
			countDown();
			
			//console.log(data);
			
		}else{
			
		}
		
	}
	
	
	var t2 = window.setInterval("get_money()",3000);
	function s_to_hs(s){
		//计算分钟
		//算法：将秒数除以60，然后下舍入，既得到分钟数
		var h;
		h  =   Math.floor(s/60);
		//计算秒
		//算法：取得秒%60的余数，既得到秒数
		s  =   s%60;
		//将变量转换为字符串
		h    +=    '';
		s    +=    '';
		//如果只有一位数，前面增加一个0
		h  =   (h.length==1)?h:h;
		s  =   (s.length==1)?'0'+s:s;
		return h+'分'+s+'秒';
	}
	if(("standalone" in window.navigator) && window.navigator.standalone){
		var noddy, remotes = false;
		document.addEventListener('click', function(event) {
			noddy = event.target;
			while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
				noddy = noddy.parentNode;
			}
			if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes)){
				event.preventDefault();
				document.location.href = noddy.href;
			}
		},false);
	}
</script>
 
    
    <script>
    $(document).ready(function() {
        // 检查登录状态
        var isLoggedIn = <?php echo $userinfo ? 'true' : 'false'; ?>;
        
        // 当前选中的投注项
        var currentPosition = '1';
        var selectedBet = null;
        
        // 投注选项配置
        var betOptions = {
            '1': [
                { label: '大', odds: '<?php echo C("ssc_dxds");?>' },
                { label: '小', odds: '<?php echo C("ssc_dxds");?>' },
                { label: '单', odds: '<?php echo C("ssc_dxds");?>' },
                { label: '双', odds: '<?php echo C("ssc_dxds");?>' },
                { label: '0', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '1', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '2', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '3', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '4', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '5', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '6', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '7', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '8', odds: '<?php echo C("ssc_dwq");?>' },
                { label: '9', odds: '<?php echo C("ssc_dwq");?>' }
            ],
            'total': [
                { label: '大', odds: '<?php echo C("ssc_zdxds");?>' },
                { label: '小', odds: '<?php echo C("ssc_zdxds");?>' },
                { label: '单', odds: '<?php echo C("ssc_zdxds");?>' },
                { label: '双', odds: '<?php echo C("ssc_zdxds");?>' },
                { label: '龙', odds: '<?php echo C("ssc_lhh_1");?>' },
                { label: '虎', odds: '<?php echo C("ssc_lhh_1");?>' },
                { label: '合', odds: '<?php echo C("ssc_lhh_2");?>' }
            ]
        };
        
        // 初始化投注选项
        betOptions['2'] = betOptions['1'];
        betOptions['3'] = betOptions['1'];
        betOptions['4'] = betOptions['1'];
        betOptions['5'] = betOptions['1'];
        
        // 渲染投注选项
        function renderBetOptions(position) {
            var options = betOptions[position];
            var html = '';
            options.forEach(function(option) {
                html += '<button class="bet-option" data-value="' + option.label + '">';
                html += '<span class="bet-label">' + option.label + '</span>';
                html += '<span class="bet-odds">1:' + option.odds + '</span>';
                html += '</button>';
            });
            $('#bet-options-grid').html(html);
        }
        
        // 初始化渲染
        renderBetOptions('1');
        
        // 位置切换
        $('.position-tab').on('click', function() {
            if (!isLoggedIn) {
                window.location.href = '/Home/Index/login';
                return false;
            }
            
            var position = $(this).data('position');
            currentPosition = position;
            
            $('.position-tab').removeClass('active');
            $(this).addClass('active');
            
            renderBetOptions(position);
        });
        
        // 投注选项点击
        $(document).on('click', '.bet-option', function() {
            if (!isLoggedIn) {
                window.location.href = '/Home/Index/login';
                return false;
            }
            
            $('.bet-option').removeClass('selected');
            $(this).addClass('selected');
            
            selectedBet = {
                position: currentPosition,
                positionName: $('.position-tab.active').text(),
                value: $(this).data('value'),
                odds: $(this).find('.bet-odds').text()
            };
        });
        
        // 显示投注弹窗
        $('#show-bet-modal').on('click', function() {
            if (!selectedBet) {
                alert('请先选择投注项');
                return;
            }
            
            $('#bet-summary-text').text(
                selectedBet.positionName + ' - ' + selectedBet.value + ' (' + selectedBet.odds + ')'
            );
            
            $('#bet-modal-overlay').fadeIn(300);
            $('#bet-modal').fadeIn(300);
        });
        
        // 关闭弹窗
        $('#close-modal, #cancel-bet, #bet-modal-overlay').on('click', function() {
            $('#bet-modal-overlay').fadeOut(300);
            $('#bet-modal').fadeOut(300);
        });
        
        // 阻止弹窗内部点击关闭
        $('#bet-modal').on('click', function(e) {
            e.stopPropagation();
        });
        
        // 快捷金额
        $('.amount-chip').on('click', function() {
            var amount = $(this).data('amount');
            $('#bet-amount').val(amount);
        });
        
        // 双倍投注
        $('#double-bet').on('click', function() {
            var currentAmount = parseInt($('#bet-amount').val()) || 0;
            $('#bet-amount').val(currentAmount * 2);
        });
        
        // 确认投注
        $('#confirm-bet').on('click', function() {
            if (!selectedBet) {
                alert('请选择投注项');
                return;
            }
            
            var amount = $('#bet-amount').val();
            if (!amount || amount <= 0) {
                alert('请输入有效的投注金额');
                return;
            }
            
            var input = selectedBet.position + '/' + selectedBet.value + '/' + amount;
            if (selectedBet.position == 'total') {
                input = selectedBet.value + amount;
            }
            
            onSubmit(input);
        });
        
        // 历史记录切换
        window.toggleHistory = function() {
            var $historyList = $('#history-list');
            var $toggleText = $('#history-toggle-text');
            var $toggleIcon = $('#history-toggle-icon');
            
            if ($historyList.is(':visible')) {
                $historyList.slideUp(300);
                $toggleText.text('查看历史');
                $toggleIcon.text('▼');
            } else {
                $historyList.slideDown(300);
                $toggleText.text('收起历史');
                $toggleIcon.text('▲');
            }
        };
        
        // 客服遮罩
        window.showMask = function() {
            $('#mask').fadeIn(300);
        };
        
        window.hideMask = function() {
            $('#mask').fadeOut(300);
        };
        
        // 倒计时功能
        var count = 0;
        function countDown(){
            $.ajax({
                url:'/Home/Get/getSsc',
                data: {},
                success: function(data){
                    data = JSON.parse(data);
                    $('#current-period').text(data.drawIssue.substring(5,11));
                    count = data.counttime;
                    executeCountDown();
                    setInterval(function() {
                        executeCountDown();
                    }, 1000);
                }
            });
        }
        
        function executeCountDown(){
            if(count == 0){
                // 显示开奖加载动画
                showLotteryLoading();
                $('#countdown-display').html('<span style="font-size:20px;">正在开奖</span>');
            }else if(count <= <?php echo C('ssc_stop_time');?>){
                count = count - 1;
                $('#countdown-display').html('<span style="font-size:20px;">已封盘</span>');
                $('#confirm-bet').attr("disabled",true).css("opacity", "0.5");
            }else{
                count = count - 1;
                $('#countdown-display').text(count);
            }
        }
        
        // 显示开奖加载动画
        function showLotteryLoading() {
            $('#lottery-loading').addClass('active');
            
            // 5秒后自动隐藏（可根据实际开奖时间调整）
            setTimeout(function() {
                hideLotteryLoading();
            }, 5000);
        }
        
        // 隐藏开奖加载动画
        function hideLotteryLoading() {
            $('#lottery-loading').removeClass('active');
        }
        
        // 开奖结果更新后隐藏加载动画
        window.afterLotteryDraw = function(result) {
            // 更新开奖号码显示
            if (result && result.numbers) {
                $('.loading-ball').each(function(index) {
                    if (result.numbers[index]) {
                        $(this).text(result.numbers[index]);
                    }
                });
            }
            
            // 延迟隐藏，让用户看到开奖结果
            setTimeout(function() {
                hideLotteryLoading();
            }, 2000);
        };
        
        countDown();
    });
    </script>
</body>
</html>