<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - 代理配置</title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
		<link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
	</head>

	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>代理配置</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							<form id="signform" action="<?php echo U('Admin/Site/agent');?>" method="post" class="form-horizontal">
								

								<div class="form-group">
									<label class="col-sm-2 control-label">用户是否显示代理推广码</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_qrcode">
											<option <?php if(C('is_qrcode') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_qrcode') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">代理推广返利点数（百分点）</label>
									<div class="col-sm-6">
										<input type="text" name="fenxiao" value="<?php echo C('fenxiao');?>" placeholder="输入邀请返利点" class="form-control">
										例如：1即为下级客户下注100返利1<span>（修改后需要重启服务生效）</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">代理分红点数（百分点）</label>
									<div class="col-sm-6">
										<input type="text" name="fenhong" value="<?php echo C('fenhong');?>" placeholder="输入代理分红点" class="form-control">
										例如：1即为下级客户总输赢100，分红1，分红需要手动操作<span></span>
									</div>
								</div>
								<!-- <div class="form-group">
									<label class="col-sm-2 control-label">邀请返利最低充值或下注</label>
									<div class="col-sm-6">
										<input type="text" name="fenxiao_min" value="<?php echo C('fenxiao_min');?>" placeholder="输入邀请返利最低充值或下注点数" class="form-control">
										<span>（修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">返利设置</label>
									<div class="col-sm-6">
										<select class="form-control" name="fenxiao_set">
											<option <?php if(C('fenxiao_set') == 2): ?>selected<?php endif; ?>  value="2">下注时返利</option>
											<option <?php if(C('fenxiao_set') == 1): ?>selected<?php endif; ?>  value="1" >充值时返利</option>
										</select>
										<span>（修改后需要重启服务生效）</span>
									</div>
								</div> -->
								<div class="form-group">
									<label class="col-sm-2 control-label">代理是否能收款上下分</label>
									<div class="col-sm-6">
										<select class="form-control" name="agent_pay">
											<option <?php if(C('agent_pay') == 1): ?>selected<?php endif; ?>  value="1">是</option>
											<option <?php if(C('agent_pay') == 0): ?>selected<?php endif; ?>  value="0" >否</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">是否开启自动返水，每天早上九点</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_auto_fs">
											<option <?php if(C('is_auto_fs') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_auto_fs') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
										<span>（修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">平台返水还是代理返水</label>
									<div class="col-sm-6">
										<select class="form-control" name="who_fs">
											<option <?php if(C('who_fs') == 1): ?>selected<?php endif; ?>  value="1">代理返水</option>
											<option <?php if(C('who_fs') == 0): ?>selected<?php endif; ?>  value="0" >平台返水</option>
										</select>
										<span>（平台返水是指以平台方，向客户返水，比例按平台方设置的比例返水；代理返水是指代理进行返水，通过扣代理的佣金，向用户进行返水，比例按代理设置的比例进行返水）</span>
									</div>
								</div>
								<!--div class="form-group">
									<label class="col-sm-2 control-label">赛车飞艇用户返水百分比</label>
									<div class="col-sm-6">
										<input type="text" name="pkft_fs_rate" value="<?php echo C('pkft_fs_rate');?>" placeholder="用户返水百分比" class="form-control">
										<span>例如：1即为下注流水为100返利1点</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">时时彩用户返水百分比</label>
									<div class="col-sm-6">
										<input type="text" name="ssc_fs_rate" value="<?php echo C('ssc_fs_rate');?>" placeholder="用户返水百分比" class="form-control">
										<span>例如：1即为下注流水为100返利1点</span>
									</div>
								</div-->
								<div class="form-group">
									<label class="col-sm-2 control-label">用户返水百分比</label>
									<div class="col-sm-6">
										<input type="text" name="pcdd_fs_rate" value="<?php echo C('pcdd_fs_rate');?>" placeholder="用户返水百分比" class="form-control">
										<span>例如：1即为下注流水为100返利1点</span>
									</div>
								</div>
								<!--div class="form-group">
									<label class="col-sm-2 control-label">快3用户返水百分比</label>
									<div class="col-sm-6">
										<input type="text" name="k3_fs_rate" value="<?php echo C('k3_fs_rate');?>" placeholder="用户返水百分比" class="form-control">
										<span>例如：1即为下注流水为100返利1点</span>
									</div>
								</div-->

								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<div class="col-sm-4 col-sm-offset-2">
										<button class="btn btn-primary" type="submit">保存信息</button>&nbsp;&nbsp;&nbsp;
										<a class="btn btn-danger" href="<?php echo U('Index/index');?>">取消</a>
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		<script src="/Public/Admin/js/content.min.js?v=1.0.0"></script>
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
		<script>
			$('.幸运飞艇_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.幸运飞艇_api').show();
				}else {
					$('.幸运飞艇_api').hide();
				}
			})

			$('.xyft_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.xyft_api').show();
				}else {
					$('.xyft_api').hide();
				}
			})

			$('.ssc_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.ssc_api').show();
				}else {
					$('.ssc_api').hide();
				}
			})

			$('.bj28_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.bj28_api').show();
				}else {
					$('.bj28_api').hide();
				}
			})

			$('.jnd28_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.jnd28_api').show();
				}else {
					$('.jnd28_api').hide();
				}
			})

			$('.k3_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.k3_api').show();
				}else {
					$('.k3_api').hide();
				}
			})

			$(document).ready(function() {
				$(".i-checks").iCheck({
					checkboxClass: "icheckbox_square-green",
					radioClass: "iradio_square-green",
				})
			});
		</script>
		<script>
			$(function(){
				$('#signform').ajaxForm({
					success: complete, 
					dataType: 'json'
				});
				function complete(data){
					if(data.status==1){
						$('.btn-primary').attr('disabled','disabled');
						layer.msg(data.info, function(index){
			 				layer.close(index);
							window.location.href=data.url;
						});
					}else{
						layer.msg(data.info);
						return false;	
					}
				}
			});
		</script>
	</body>

</html>