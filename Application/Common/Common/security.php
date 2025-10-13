<?php
/**
 * 安全函数库
 * 用于增强系统安全性
 */

/**
 * 安全的整数ID验证
 * @param mixed $id 需要验证的ID
 * @return int 返回安全的整数ID，失败返回0
 */
function safe_int($id) {
    return intval($id);
}

/**
 * 安全的字符串转义
 * @param string $str 需要转义的字符串
 * @return string 转义后的字符串
 */
function safe_string($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

/**
 * 安全的密码哈希（推荐用于新密码）
 * @param string $password 原始密码
 * @return string 哈希后的密码
 */
function safe_password_hash($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
}

/**
 * 验证密码（与safe_password_hash配对使用）
 * @param string $password 原始密码
 * @param string $hash 哈希值
 * @return bool 密码是否匹配
 */
function safe_password_verify($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * 兼容旧系统的MD5密码验证
 * @param string $password 原始密码
 * @param string $hash MD5哈希值
 * @return bool 密码是否匹配
 */
function legacy_password_verify($password, $hash) {
    return md5($password) === $hash;
}

/**
 * XSS防护 - HTML输出
 * @param string $str 需要输出的字符串
 * @return string 安全的HTML字符串
 */
function xss_clean($str) {
    if (is_array($str)) {
        return array_map('xss_clean', $str);
    }
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * 生成CSRF Token
 * @return string Token值
 */
function generate_csrf_token() {
    if (!session_id()) {
        session_start();
    }
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();
    return $token;
}

/**
 * 验证CSRF Token
 * @param string $token 提交的Token
 * @return bool Token是否有效
 */
function verify_csrf_token($token) {
    if (!session_id()) {
        session_start();
    }
    
    // 检查Token是否存在
    if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
        return false;
    }
    
    // 检查Token是否过期（30分钟）
    if (time() - $_SESSION['csrf_token_time'] > 1800) {
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_token_time']);
        return false;
    }
    
    // 验证Token
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * 安全的文件上传验证
 * @param array $file $_FILES数组元素
 * @param array $allowed_types 允许的MIME类型
 * @param int $max_size 最大文件大小（字节）
 * @return array ['status' => bool, 'message' => string]
 */
function safe_file_upload($file, $allowed_types = ['image/jpeg', 'image/png', 'image/gif'], $max_size = 5242880) {
    // 检查文件是否存在
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['status' => false, 'message' => '文件上传失败'];
    }
    
    // 检查文件大小
    if ($file['size'] > $max_size) {
        return ['status' => false, 'message' => '文件大小超过限制'];
    }
    
    // 检查文件类型
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        return ['status' => false, 'message' => '文件类型不允许'];
    }
    
    // 检查是否是真实图片（如果是图片类型）
    if (strpos($mime_type, 'image/') === 0) {
        $image_info = @getimagesize($file['tmp_name']);
        if ($image_info === false) {
            return ['status' => false, 'message' => '文件不是有效的图片'];
        }
    }
    
    return ['status' => true, 'message' => '验证通过'];
}

/**
 * 防止SQL注入的参数绑定助手
 * @param string $sql SQL模板
 * @param array $params 参数数组
 * @return array ['sql' => string, 'params' => array]
 */
function safe_sql_bind($sql, $params = []) {
    // 这个函数主要用于文档说明，实际使用ThinkPHP的where方法
    return [
        'sql' => $sql,
        'params' => array_map('safe_int', $params)
    ];
}
