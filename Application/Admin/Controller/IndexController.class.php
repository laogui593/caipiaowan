<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends BaseController {
	
    public function index(){
    	// 检查设备类型
    	$is_mobile = is_mobile();
    	
    	// 获取待处理的上下分请求数量
    	$xf_count = M('fenxia')->where("status=0")->count();
    	$sf_count = M('fenadd')->where("`check`=0")->count();
    	
    	// 获取系统基本信息
    	$admin_info = session('admin');
    	$system_info = array(
    		'admin_name' => $admin_info['username'],
    		'system_name' => C('sitename'),
    		'login_time' => date('Y-m-d H:i:s', $admin_info['last_time']),
    		'login_ip' => $admin_info['last_ip']
    	);
    	
    	// 获取今日统计数据
    	$today_stats = $this->getTodayStats();

    	$this->assign("is_mobile", $is_mobile);
    	$this->assign("sf_count", $sf_count);
    	$this->assign("xf_count", $xf_count);
    	$this->assign("system_info", $system_info);
    	$this->assign("today_stats", $today_stats);
        $this->display();
	}
	
	// 获取今日统计数据
	private function getTodayStats(){
		$start = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$end = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
		
		// 今日投注统计
		$order_map['time'] = array(array('egt',$start),array('elt',$end),'and');
		$order_map['state'] = 1;
		$order_stats = M('order')->field("COUNT(*) as count, SUM(add_points) AS add_points, SUM(del_points) AS del_points")->where($order_map)->find();
		
		// 今日用户统计
		$user_map['reg_time'] = array(array('egt',$start),array('elt',$end),'and');
		$new_users = M('user')->where($user_map)->count();
		
		// 在线用户统计（最近10分钟活跃）
		$online_time = time() - 600;
		$online_users = M('user')->where("last_time > {$online_time}")->count();
		
		return array(
			'order_count' => $order_stats['count'] ?: 0,
			'today_profit' => ($order_stats['del_points'] - $order_stats['add_points']) ?: 0,
			'new_users' => $new_users ?: 0,
			'online_users' => $online_users ?: 0
		);
	}
	
	public function gameMsg() {
        $data = array(
            'pay' => M('fenadd')->where("`check`=0")->count(),
            'withdraw' => M('fenxia')->where("status=0")->count()
        );
        echo json_encode($data);
    }
	
	
	public function dashboard(){
		 // $auth_url = "http://pk.fylyf.cn/Home/Index/authcheck?auth_code=".C('auth_code');
   //  	$auth = curlGet($auth_url);
   //  	$auth = trim($auth,chr(239).chr(187).chr(191));
   //  	$this->assign('auth',json_decode($auth,true));

    	//平台今日输赢和总输赢
		$start=mktime(0,0,0,date('m'),date('d'),date('Y'));
		$end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

		$map['time'] = array(array('egt',$start),array('elt',$end),'and');
		$map['state'] = 1;
		$order = M('order');

		$pt_today = $order->field("SUM(add_points) AS add_points,SUM(del_points) AS del_points")->where($map)->find();
		$data['today_ying'] = $pt_today['del_points'] - $pt_today['add_points'];
		//平台今日上分总数
		$addmap['addtime']=array(array('egt',$start),array('elt',$end),'and');
		$addmap['status']=1;
		$addfenadd=M('fenadd');
		$addfen_row=$addfenadd->field("SUM(money) AS mmm")->where($addmap)->find();
		$data['fenadd']=$addfen_row['mmm'];
	    $integral=M('integral');
		$adminmap['type']=1;
		$adminmap['time']=array(array('egt',$start),array('elt',$end),'and');
		$admin_add=$integral->field("SUM(points) AS mmm")->where($adminmap)->find();
		$data['fenadd']=$addfen_row['mmm']+$admin_add['mmm'];
		
		
		if($data['fenadd']==null||$data['fenadd']==''||$data['fenadd']==0){
			$data['fenadd']=0;
		}
		//平台今日下分总数
		$addmap['addtime']=array(array('egt',$start),array('elt',$end),'and');
		$addmap['status']=1;
		$xiafenadd=M('fenxia');
		$xiafen_row=$xiafenadd->field("SUM(money) AS mmm")->where($addmap)->find();
	//	$data['fenxia']=$xiafen_row['mmm'];
		$adminmap['type']=0;
		$admin_add=$integral->field("SUM(points) AS mmm")->where($adminmap)->find();
		$data['fenxia']=$admin_add['mmm'];
		
		if($data['fenxia']==null||$data['fenxia']==''||$data['fenxia']==0){
			$data['fenxia']=0;
		}
		
		//平台近一个月输赢
		$start=mktime(0,0,0,date('m'),date('d')-29,date('Y'));
		$end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
		$map_m['time'] = array(array('egt',$start),array('elt',$end),'and');
		$map_m['state'] = 1;
		$pt_all = $order->field("SUM(add_points) AS add_points,SUM(del_points) AS del_points")->where($map_m)->find();
		$data['all_ying'] = $pt_all['del_points'] - $pt_all['add_points'];

		//今日新增用户
		$start_u=mktime(0,0,0,date('m'),date('d'),date('Y'));
		$end_u=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

		$map_u['reg_time'] = array(array('egt',$start_u),array('elt',$end_u),'and');
		
		$user = M('user');
		$data['today_user'] = $user->where($map_u)->count();

		//最近一个月新增用户
		$start_u_m=mktime(0,0,0,date('m'),date('d')-29,date('Y'));
		$end_u_m=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
		$map_u_m['reg_time'] = array(array('egt',$start_u_m),array('elt',$end_u_m),'and');
		
		$user = M('user');
		$data['month_user'] = $user->where($map_u_m)->count();
        $data['usernumber']=$user->count();
		$this->assign("data",$data);
		$this->display();
	}
		
	public function main(){
		$auth = auth_check(C('auth_code'),$_SERVER['HTTP_HOST']);
		if (!$auth) {
			echo "未授权或授权已过期";exit;
		}
		
		$number = M('number');
		$count = $number->count();
		$page = new \Think\Page($count,10);
		$show = $page->show();
		$list = $number->limit($page->firstRow.','.$page->listRows)->order("id DESC")->select();
		for($i=0;$i<count($list);$i++){
			$list[$i]['order'] = M('order')->where("number = {$list[$i]['']}")->select();
		}
		$this->display();
	}
	
	public function pwd() {
		$User = M('admin');
		$user2 = session('admin');
		if ($_POST) {
			if (!IS_AJAX) {
				$this->error('提交方式不正确', U('index/pwd'), 0);
			} else {
				$data['user'] = I('post.user');
				$data['password'] = md5(I('post.oldpassword'));
				$newpassword = md5(I('post.newpassword'));
				$repassword = md5(I('post.repassword'));
				$result = $User->where($data)->find();

				if ($result) {
					if ($newpassword != $repassword) {
						$this->error("两次输入新密码不一致");
					} else {
						$User->where($data)->setField('password', $newpassword);
						$this->success("修改成功", U('Login/index'),1);
					}
				} else {
					$this->error("账号或密码不正确");
				}
			}
		}
		$this -> assign('user2', $user2);
		$this -> display();
	}

	public function del() {
		delFileByDir(APP_PATH.'Runtime/');
		$this->success('删除缓存成功！',U('Admin/Index/index'));
	}	
	
	
		
}