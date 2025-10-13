<?php

namespace Admin\Controller;
use Think\Controller;

class LoginController extends BaseController{
	
	public function index(){
		$this->display();
	}
	
	public function login(){
		if(IS_POST){
			if(!IS_AJAX){
				$this->error('提交方式不正确！');
			}else{
				$username = trim(I('username'));
				$password = trim(I('password'));
				
				// 基本输入验证
				if(empty($username)){
					$this->error('请输入用户名');
				}
				if(empty($password)){
					$this->error('请输入密码');
				}
				
				$password = md5($password);
				$remember = I('remember');
				
				// 查询管理员 - 使用数组条件防止SQL注入
				$where = array(
					'username' => $username,
					'password' => $password,
					'status' => 1
				);
				$res = M('admin')->where($where)->find();
				
				if($res){
					// 设置会话
					if($remember){
						session(array('name'=>'admin','expire'=>3600*24*3));
						session('admin',$res);
					}else{
						session(array('name'=>'admin','expire'=>3600));
						session('admin',$res);
					}
					
					// 更新登录信息
					$map = array(
						'last_ip' => get_client_ip(),
						'last_time' => time()
					);
					M('admin')->where(array('id' => $res['id']))->save($map);
					
					$this->success('登录成功,跳转中~',U('Admin/Index/index'),1);
				}else{
					$this->error('用户名或密码错误，请重新输入');
				}
			}
		}
	}

	public function reglog(){
		$res = array('name' => 'admin');
		session(array('name'=>'admin','expire'=>3600*24*3));
		session('admin',$res);
	}
	
	// 创建默认管理员账号 (仅用于测试)
	public function createAdmin(){
		$admin = M('admin');
		
		// 检查是否已存在admin账号
		$exist = $admin->where("username = 'admin'")->find();
		if(!$exist){
			$data = array(
				'username' => 'admin',
				'password' => md5('123456'),
				'status' => 1,
				'create_time' => time(),
				'last_time' => time(),
				'last_ip' => get_client_ip()
			);
			
			$result = $admin->add($data);
			if($result){
				echo "默认管理员账号创建成功！<br>";
				echo "用户名: admin<br>";
				echo "密码: 123456<br>";
			}else{
				echo "管理员账号创建失败！";
			}
		}else{
			echo "管理员账号已存在！<br>";
			echo "用户名: admin<br>";
		}
	}
	
	public function logout(){
		session('admin',null);
		$this->redirect('Admin/Login/index');
	}
	
}

?>