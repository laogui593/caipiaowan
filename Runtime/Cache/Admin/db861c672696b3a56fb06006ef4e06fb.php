<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>后台 - 会员管理</title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">

	</head>
	<style>
		/*分页样式*/
		.pages a,.pages span {
		    display:inline-block;
		    padding:4px 7px;
		    margin:0 2px;
		    border:1px solid #D5D4D4;
		    -webkit-border-radius:1px;
		    -moz-border-radius:1px;
		    border-radius:1px;
		}
		.pages a,.pages li {
		    display:inline-block;
		    list-style: none;
		    text-decoration:none; color:#3399ff;
		}
		
		.pages a:hover{
		    border-color:#3399ff;
		}
		.pages span.current{
		    background:#3399ff;
		    color:#FFF;
		    font-weight:700;
		    border-color:#3399ff;
		}
		.pages{
			text-align: center;
		}
		/*分页样式*/
		
		.layui-layer{
			top:48px !important;
		}
	</style>
	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">	
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>用户管理</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-4">
									<form method="post" action="<?php echo U('Admin/Member/index');?>">
										<div class="input-group">
											<input type="text"  placeholder="请输入用户UID" name="uid" value="<?php echo ($uid); ?>" class="input-sm form-control">
											<input type="text"  placeholder="请输入用户号或昵称" name="nickname" value="<?php echo ($nickname); ?>" class="input-sm form-control"> <span class="input-group-btn">
	                                    	<button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
	                                    	 
	                                    	</span>

										</div>
									</form>
								</div>
							</div>
							<div class="" >
								<table class="table table-striped table-hover table-bordered" style="width:auto;overflow:auto;display:inline-block;">
									<thead>
										<tr>
											<!-- <th></th> -->
											<th>UID</th>
											<th>头像</th>
											<th>昵称</th>
											<th>用户号</th>
											<th>性别</th>
											<th>备注</th>
											<th>注册时间</th>
											<th>所得总佣金</th>
											<th>剩余佣金</th>
											<th>剩余返水金额</th>
											<th>剩余点数</th>
											
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												<!-- <td width="20"><input type="checkbox" class="i-checks" name="ids[]"></td> -->
												<td width="60"><?php echo ($vo["id"]); ?></td>
												<td width="60"><img src="<?php echo ($vo["headimgurl"]); ?>"/></td>
												<td width="100"><?php echo ($vo["nickname"]); ?></td>
												<td width="100"><?php echo ($vo["username"]); ?></td>
												<td width="50" style="text-align: center;">
													<?php if($vo['sex'] == 1): ?>男<?php endif; ?>
													<?php if($vo['sex'] == 2): ?>女<?php endif; ?>
													<?php if($vo['sex'] == 0): ?>未知<?php endif; ?>
												</td>
												<td width="100"><?php echo ($vo["remark"]); ?></td>
												<td width="150"><?php echo (date("Y-m-d H:i:s",$vo["reg_time"])); ?></td>
												<td width="100"><?php echo ($vo["t_add"]); ?></td>
												<td width="100"><?php echo ($vo["yong"]); ?></td>
												<td width="100"><?php echo ($vo["fanshui"]); ?></td>
												<td width="100" style="text-align: center;font-weight: 700;"><?php echo ($vo["points"]); ?></td>
											
												<td width="500">
													<a onclick="integral('<?php echo ($vo["id"]); ?>')" class="btn btn-primary">上分</a>
													<a onclick="under('<?php echo ($vo["id"]); ?>')" class="btn btn-info">下分</a>
													
													<a onclick="edit('<?php echo ($vo["id"]); ?>')" class="btn btn-default">编辑</a>
													<a onclick="edityhk('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">银行卡</a>
													<?php if($vo["is_robot"] == 1): ?><a onclick="cancel_robot('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">取消假人</a>
														<?php else: ?>
														<a onclick="set_robot('<?php echo ($vo["id"]); ?>')" class="btn btn-primary">设为假人</a><?php endif; ?>
													<?php if($vo["is_agent"] == 1): ?><a onclick="cancel_agent('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">取消代理</a>
														<?php else: ?>
														<a onclick="set_agent('<?php echo ($vo["id"]); ?>')" class="btn btn-success">设为代理</a><?php endif; ?>
													<?php if($vo["status"] == 1): ?><a onclick="disable('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">禁用</a>
														<?php else: ?>
														<a onclick="endisable('<?php echo ($vo["id"]); ?>')" class="btn btn-primary">启用</a><?php endif; ?>
													<a onclick="del('<?php echo ($vo["id"]); ?>')" class="btn btn-warning">删除</a>
													<a href="/Admin/Member/pushxx/id/<?php echo ($vo["id"]); ?>" class="btn btn-primary">查看下线</a>
													<?php if($vo["t_id"] != 0): ?><a onclick="edit('<?php echo ($vo["t_id"]); ?>')" class="btn btn-success">查看上线</a>
														<?php else: ?>
														无上线<?php endif; ?>
													<!--<?php if($vo["xjp28_is_win"] == 1): ?><a onclick="cancel_set_win('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">取消赢家</a>
														<?php else: ?>
														<a onclick="set_win('<?php echo ($vo["id"]); ?>')" class="btn btn-success">设为赢家</a><?php endif; ?>
													<?php if($vo["xjp28_is_lost"] == 1): ?><a onclick="cancel_set_lost('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">取消输家</a>
														<?php else: ?>
														<a onclick="set_lost('<?php echo ($vo["id"]); ?>')" class="btn btn-success">设为输家</a><?php endif; ?>-->
													<a onclick="fenedit('<?php echo ($vo["id"]); ?>')" class="btn btn-default">今日上下分统计</a>
												</td>
											</tr><?php endforeach; endif; else: echo "" ;endif; ?>
									</tbody>
								</table>
							</div>
							<div class="pages">
								<?php echo ($show); ?>
							</div>
							<div>
								<span>系统总余分<font color="red"><?php echo ((isset($yufen) && ($yufen !== ""))?($yufen):'0'); ?></font></span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
			$(document).ready(function() {
				$(".i-checks").iCheck({
					checkboxClass: "icheckbox_square-green",
					radioClass: "iradio_square-green",
				})
			});
		</script>
		<script>
			function integral(id){
				layer.open({
			      	type: 2,
			      	title: '会员上分',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '500px'],
			      	content: "/Admin/Integral/index/id/" + id + ""
			    });
			}
			function under(id){
				layer.open({
			      	type: 2,
			      	title: '会员下分',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '500px'],
			      	content: "/Admin/Integral/under/id/" + id + ""
			    });
			}
			function edit(id){
				layer.open({
			      	type: 2,
			      	title: '编辑',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['600px', '500px'],
			      	content: "/Admin/Member/edit/id/" + id + ""
			    });
			}
			function edityhk(id){
				layer.open({
			      	type: 2,
			      	title: '编辑银行卡',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['600px', '500px'],
			      	content: "/Admin/Member/edityhk/id/" + id + ""
			    });
			}
			function fenedit(id){
				layer.open({
			      	type: 2,
			      	title: '查看',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['600px', '500px'],
			      	content: "/Admin/Member/fenedit/id/" + id + ""
			    });
			}
			
			
			
			
			function disable(id){
				layer.confirm('确定要禁用吗？禁用后将不能登录。', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/disable/id/" + id + ""
				});
			}

			function del(id){
				layer.confirm('确定要彻底删除吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/delete/id/" + id + ""
				});
			}
			function endisable(id){
				layer.confirm('确定要启用吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/endisable/id/" + id + ""
				});
			}

			
			function set_robot(id){
				layer.confirm('确定要设置为假人吗，假人投注视为无效', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/set_robot/id/" + id + ""
				});
			}
			function cancel_robot(id){
				layer.confirm('确定要取消假人吗', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/cancel_robot/id/" + id + ""
				});
			}

			function set_agent(id){
				layer.confirm('确定要设置为代理吗，代理可以登录代理后台，帐号为会员的用户号，密码可以编辑设置', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/set_agent/id/" + id + ""
				});
			}
			function cancel_agent(id){
				layer.confirm('确定要取消代理吗', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/cancel_agent/id/" + id + ""
				});
			}
			function set_win(id){
				layer.confirm('确定设为赢家吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/set_win/id/" + id + ""
				});
			}
			
			function cancel_set_win(id){
				layer.confirm('确定取消设为赢家吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/cancel_set_win/id/" + id + ""
				});
			}
			
			function set_lost(id){
				layer.confirm('确定设为输家吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/set_lost/id/" + id + ""
				});
			}
			
			function cancel_set_lost(id){
				layer.confirm('确定取消设为输家吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/cancel_set_lost/id/" + id + ""
				});
			}
		</script>
	</body>

	
</html>