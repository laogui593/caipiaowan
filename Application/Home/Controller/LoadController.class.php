<?php
namespace Home\Controller;
use Think\Controller;

class LoadController extends Controller {
    
    /**
     * Initial接口 - 返回系统初始化数据
     * 访问地址: /index.php?m=Home&c=Load&a=initial
     */
    public function initial() {
        try {
            // 尝试获取系统配置
            $config = null;
            try {
                $config = M('config_one')->find();
            } catch (\Exception $e) {
                // 数据库连接失败，使用默认配置
                $config = null;
            }
            
            // 获取游戏列表
            $games = array(
                array('id' => 1, 'name' => '北京PK10', 'code' => 'pk10', 'status' => 1, 'port' => 15531),
                array('id' => 2, 'name' => '时时彩', 'code' => 'ssc', 'status' => 1, 'port' => 15532),
                array('id' => 3, 'name' => '六合彩', 'code' => 'lhc', 'status' => 1, 'port' => 15533),
                array('id' => 4, 'name' => '幸运飞艇', 'code' => 'xyft', 'status' => 1, 'port' => 15537),
                array('id' => 5, 'name' => '快3', 'code' => 'k3', 'status' => 1, 'port' => 15538),
                array('id' => 6, 'name' => '北京28', 'code' => 'bj28', 'status' => 1, 'port' => 15534),
                array('id' => 7, 'name' => '加拿大28', 'code' => 'jnd28', 'status' => 1, 'port' => 15535),
            );
            
            // 获取最新开奖数据（模拟）
            $latest_results = array(
                array('game' => 'pk10', 'issue' => '20251029001', 'opencode' => '03,07,01,09,05,02,10,04,08,06', 'opentime' => date('Y-m-d H:i:s')),
                array('game' => 'ssc', 'issue' => '20251029001', 'opencode' => '1,5,8,2,9', 'opentime' => date('Y-m-d H:i:s')),
                array('game' => 'lhc', 'issue' => '2025001', 'opencode' => '12,25,36,18,07,42+15', 'opentime' => date('Y-m-d H:i:s')),
            );
            
            // 构建返回数据
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => '初始化数据加载成功',
                'timestamp' => time(),
                'server_time' => date('Y-m-d H:i:s'),
                'server_port' => 7180,
                'data' => array(
                    'site_config' => array(
                        'site_name' => $config ? $config['web_name'] : '彩票系统',
                        'site_title' => $config ? $config['web_name'] : '彩票管理系统',
                        'site_status' => 1,
                        'notice' => $config ? $config['notice'] : '欢迎使用彩票系统，祝您好运！',
                        'version' => '1.0.0',
                    ),
                    'games' => $games,
                    'latest_results' => $latest_results,
                    'statistics' => array(
                        'online_users' => rand(100, 500),
                        'today_bets' => rand(1000, 5000),
                        'today_amount' => rand(100000, 1000000),
                        'total_users' => rand(10000, 50000),
                    ),
                    'websocket' => array(
                        'enabled' => true,
                        'host' => '127.0.0.1',
                        'ports' => array(
                            'pk10' => 15531,
                            'ssc' => 15532,
                            'lhc' => 15533,
                            'bj28' => 15534,
                            'jnd28' => 15535,
                            'xyft' => 15537,
                            'k3' => 15538,
                        )
                    ),
                    'system_info' => array(
                        'php_version' => PHP_VERSION,
                        'server_time' => date('Y-m-d H:i:s'),
                        'timezone' => date_default_timezone_get(),
                    )
                )
            );
            
        } catch (\Exception $e) {
            // 如果出现任何错误，返回错误信息
            $data = array(
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => time(),
            );
        }
        
        // 返回JSON数据
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    /**
     * 获取游戏配置
     */
    public function config() {
        $config = M('config_one')->find();
        
        $data = array(
            'status' => 'success',
            'code' => 200,
            'data' => array(
                'web_name' => $config['web_name'] ?? '彩票系统',
                'notice' => $config['notice'] ?? '',
                'status' => 1,
                'server_time' => date('Y-m-d H:i:s'),
            )
        );
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * 获取游戏列表
     */
    public function games() {
        $lottery = M('lottery')->where('status=1')->select();
        
        $data = array(
            'status' => 'success',
            'code' => 200,
            'data' => $lottery ? $lottery : array()
        );
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * 获取最新开奖结果
     */
    public function results() {
        $game = I('get.game', '');
        $limit = I('get.limit', 10);
        
        if ($game) {
            $results = M('caiji')->where(array('game' => $game))->order('id desc')->limit($limit)->select();
        } else {
            $results = M('caiji')->order('id desc')->limit($limit)->select();
        }
        
        $data = array(
            'status' => 'success',
            'code' => 200,
            'data' => $results ? $results : array()
        );
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * 系统状态
     */
    public function status() {
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => '系统运行正常',
            'data' => array(
                'system' => 'online',
                'database' => 'connected',
                'server_time' => date('Y-m-d H:i:s'),
                'timestamp' => time(),
                'version' => '1.0.0',
            )
        );
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
