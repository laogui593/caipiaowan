<?php
/**
 * Nacos 服务注册脚本
 * 将后台管理服务(7170)注册到 Nacos
 */

class NacosServiceRegistry {
    
    private $nacosHost = '127.0.0.1';  // Nacos 服务器地址
    private $nacosPort = 8848;          // Nacos 端口
    private $namespace = 'public';      // 命名空间
    
    // 服务配置
    private $serviceName;           // 服务名称
    private $serviceIp = '127.0.0.1';  // 服务IP
    private $servicePort;           // 服务端口
    private $groupName = 'DEFAULT_GROUP';  // 分组名称
    private $serviceMetadata = [];  // 服务元数据
    
    public function __construct($nacosConfig = [], $serviceConfig = []) {
        if (isset($nacosConfig['host'])) {
            $this->nacosHost = $nacosConfig['host'];
        }
        if (isset($nacosConfig['port'])) {
            $this->nacosPort = $nacosConfig['port'];
        }
        if (isset($nacosConfig['namespace'])) {
            $this->namespace = $nacosConfig['namespace'];
        }
        
        // 设置服务配置
        $this->serviceName = $serviceConfig['name'] ?? 'caipiao-service';
        $this->servicePort = $serviceConfig['port'] ?? 7180;
        $this->serviceIp = $serviceConfig['ip'] ?? '127.0.0.1';
        $this->serviceMetadata = $serviceConfig['metadata'] ?? [];
    }
    
    /**
     * 注册服务到 Nacos
     */
    public function registerService() {
        $url = "http://{$this->nacosHost}:{$this->nacosPort}/nacos/v1/ns/instance";
        
        $data = [
            'serviceName' => $this->serviceName,
            'ip' => $this->serviceIp,
            'port' => $this->servicePort,
            'namespaceId' => $this->namespace,
            'groupName' => $this->groupName,
            'healthy' => 'true',
            'weight' => 1.0,
            'enabled' => 'true',
            'metadata' => json_encode(array_merge([
                'version' => '1.0.0'
            ], $this->serviceMetadata))
        ];
        
        echo "正在注册服务到 Nacos...\n";
        echo "Nacos地址: {$this->nacosHost}:{$this->nacosPort}\n";
        echo "服务名称: {$this->serviceName}\n";
        echo "服务地址: {$this->serviceIp}:{$this->servicePort}\n\n";
        
        $result = $this->sendRequest($url, $data);
        
        if ($result === 'ok') {
            echo "✓ 服务注册成功！\n";
            echo "服务已注册到 Nacos: {$this->serviceName}\n";
            return true;
        } else {
            echo "✗ 服务注册失败: $result\n";
            return false;
        }
    }
    
    /**
     * 从 Nacos 注销服务
     */
    public function deregisterService() {
        $url = "http://{$this->nacosHost}:{$this->nacosPort}/nacos/v1/ns/instance";
        
        $data = [
            'serviceName' => $this->serviceName,
            'ip' => $this->serviceIp,
            'port' => $this->servicePort,
            'namespaceId' => $this->namespace,
            'groupName' => $this->groupName,
        ];
        
        echo "正在从 Nacos 注销服务...\n";
        
        $result = $this->sendDeleteRequest($url, $data);
        
        if ($result === 'ok') {
            echo "✓ 服务注销成功！\n";
            return true;
        } else {
            echo "✗ 服务注销失败: $result\n";
            return false;
        }
    }
    
    /**
     * 发送心跳保持服务活跃
     */
    public function sendHeartbeat() {
        $url = "http://{$this->nacosHost}:{$this->nacosPort}/nacos/v1/ns/instance/beat";
        
        $beat = json_encode([
            'serviceName' => $this->serviceName,
            'ip' => $this->serviceIp,
            'port' => $this->servicePort,
            'weight' => 1.0,
            'metadata' => [
                'version' => '1.0.0'
            ]
        ]);
        
        $data = [
            'serviceName' => $this->serviceName,
            'ip' => $this->serviceIp,
            'port' => $this->servicePort,
            'namespaceId' => $this->namespace,
            'groupName' => $this->groupName,
            'beat' => $beat
        ];
        
        $result = $this->sendRequest($url, $data, 'PUT');
        return $result;
    }
    
    /**
     * 查询服务实例
     */
    public function queryService() {
        $url = "http://{$this->nacosHost}:{$this->nacosPort}/nacos/v1/ns/instance/list";
        
        $params = http_build_query([
            'serviceName' => $this->serviceName,
            'namespaceId' => $this->namespace,
            'groupName' => $this->groupName,
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $data = json_decode($response, true);
            return $data;
        }
        
        return null;
    }
    
    /**
     * 发送 HTTP 请求
     */
    private function sendRequest($url, $data, $method = 'POST') {
        $ch = curl_init();
        
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return "CURL错误: $error";
        }
        
        return $response;
    }
    
    /**
     * 发送 DELETE 请求
     */
    private function sendDeleteRequest($url, $data) {
        $params = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return "CURL错误: $error";
        }
        
        return $response;
    }
}

// 命令行使用示例
if (php_sapi_name() == 'cli') {
    
    // Nacos 配置（根据实际情况修改）
    $nacosConfig = [
        'host' => '127.0.0.1',      // Nacos 服务器地址
        'port' => 6878,              // Nacos 端口（自定义端口）
        'namespace' => 'public'      // 命名空间
    ];
    
    // 解析命令行参数
    $action = isset($argv[1]) ? $argv[1] : 'register';
    $serviceType = isset($argv[2]) ? $argv[2] : 'all';  // all, frontend, backend
    
    // 定义两个服务
    $services = [];
    
    if ($serviceType == 'all' || $serviceType == 'frontend') {
        $services[] = [
            'name' => 'caipiao-frontend-api',
            'port' => 7180,
            'ip' => '127.0.0.1',
            'metadata' => [
                'service_type' => 'frontend',
                'description' => '彩票系统前端API服务'
            ]
        ];
    }
    
    if ($serviceType == 'all' || $serviceType == 'backend') {
        $services[] = [
            'name' => 'caipiao-backend-admin',
            'port' => 7170,
            'ip' => '127.0.0.1',
            'metadata' => [
                'service_type' => 'backend',
                'description' => '彩票系统后台管理服务'
            ]
        ];
    }
    
    switch ($action) {
        case 'register':
            echo "=== 注册服务到 Nacos ===\n\n";
            foreach ($services as $service) {
                $registry = new NacosServiceRegistry($nacosConfig, $service);
                $registry->registerService();
                echo "\n";
            }
            break;
            
        case 'deregister':
            echo "=== 从 Nacos 注销服务 ===\n\n";
            foreach ($services as $service) {
                $registry = new NacosServiceRegistry($nacosConfig, $service);
                $registry->deregisterService();
                echo "\n";
            }
            break;
            
        case 'heartbeat':
            echo "=== 发送心跳 ===\n\n";
            foreach ($services as $service) {
                $registry = new NacosServiceRegistry($nacosConfig, $service);
                $result = $registry->sendHeartbeat();
                echo "{$service['name']}: $result\n";
            }
            break;
            
        case 'query':
            echo "=== 查询服务 ===\n\n";
            foreach ($services as $service) {
                $registry = new NacosServiceRegistry($nacosConfig, $service);
                echo "服务: {$service['name']}\n";
                $result = $registry->queryService();
                print_r($result);
                echo "\n";
            }
            break;
            
        case 'daemon':
            echo "=== 启动守护进程 ===\n\n";
            
            // 注册所有服务
            echo "注册服务...\n";
            $registries = [];
            foreach ($services as $service) {
                $registry = new NacosServiceRegistry($nacosConfig, $service);
                $registry->registerService();
                $registries[] = ['service' => $service, 'registry' => $registry];
                echo "\n";
            }
            
            echo "开始发送心跳（每5秒）...\n";
            echo "按 Ctrl+C 停止\n\n";
            
            while (true) {
                sleep(5);
                foreach ($registries as $item) {
                    $result = $item['registry']->sendHeartbeat();
                    echo "[" . date('Y-m-d H:i:s') . "] {$item['service']['name']}: $result\n";
                }
            }
            break;
            
        default:
            echo "彩票系统 Nacos 服务注册工具\n\n";
            echo "用法:\n";
            echo "  php nacos_register.php <action> [service_type]\n\n";
            echo "Actions:\n";
            echo "  register    - 注册服务到 Nacos\n";
            echo "  deregister  - 从 Nacos 注销服务\n";
            echo "  heartbeat   - 发送心跳\n";
            echo "  query       - 查询服务状态\n";
            echo "  daemon      - 守护进程模式（自动发送心跳）\n\n";
            echo "Service Types:\n";
            echo "  all         - 所有服务（默认）\n";
            echo "  frontend    - 仅前端API服务 (7180)\n";
            echo "  backend     - 仅后台管理服务 (7170)\n\n";
            echo "示例:\n";
            echo "  php nacos_register.php register all       # 注册所有服务\n";
            echo "  php nacos_register.php register frontend  # 仅注册前端服务\n";
            echo "  php nacos_register.php daemon             # 守护进程模式\n";
            echo "  php nacos_register.php query              # 查询所有服务\n\n";
            echo "服务列表:\n";
            echo "  - caipiao-frontend-api (7180)   - 前端API服务\n";
            echo "  - caipiao-backend-admin (7170)  - 后台管理服务\n";
            break;
    }
}
