<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - 网站设置</title>
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
							<h5>网站设置</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							<form id="signform" action="<?php echo U('Admin/Site/index');?>" method="post" class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label">网站名称</label>
									<div class="col-sm-6">
										<input type="text" name="sitename" value="<?php echo C('sitename');?>" placeholder="输入网站名称" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">网站域名(不带http)</label>
									<div class="col-sm-6">
										<input type="text" name="siteurl" id="siteurl" value="<?php echo C('siteurl');?>" placeholder="www.xx.com" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">登录公告（标题）</label>
									<div class="col-sm-6">
										<input type="text" name="dlggbt" id="dlggbt" value="<?php echo C('dlggbt');?>" placeholder="" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">登录公告</label>
									<div class="col-sm-6">
										
										<textarea class="form-control" name='gonggaos'><?php echo C('gonggaos');?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">QQ</label>
									<div class="col-sm-6">
										<input type="text" name="qq" value="<?php echo C('qq');?>" placeholder="QQ" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">客服</label>
									<div class="col-sm-6">
										<input type="text" name="zxkf" id="zxkf" value="<?php echo C('zxkf');?>" placeholder="" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">三房间入场和下注</label>
									<div class="col-sm-6">
										<input type="text" name="money_limit" id="money_limit" value="<?php echo C('money_limit');?>" placeholder="" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">网站是否开放</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_open">
											<option <?php if(C('is_open') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_open') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>
								
								<!-- <div class="form-group">
									<label class="col-sm-2 control-label">前台界面切换</label>
									<div class="col-sm-6">
										<select class="form-control" name="index_page">
											<option <?php if(C('index_page') == 1): ?>selected<?php endif; ?>  value="1">旧版</option>
											<option <?php if(C('index_page') == 2): ?>selected<?php endif; ?>  value="2">新版</option>
										</select>
									</div>
								</div> -->

								<div class="form-group">
									<label class="col-sm-2 control-label">是否开放注册</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_open_reg">
											<option <?php if(C('is_open_reg') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_open_reg') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">开通公众号版自动登录注册</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_weixin">
											<option <?php if(C('is_weixin') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_weixin') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
										<span>（开通后，需要配置微信参数，通过微信进入，自动登录注册，其他方式进入，还是可以进入网页版）</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">是否开通百度搜索进入</label>
									<div class="col-sm-6">
										<select class="form-control is_baidu_select"  name="is_baidu">
											<option <?php if(C('is_baidu') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_baidu') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>

								<div class="form-group baidu_value" <?php if(C('is_baidu') == 0): ?>style='display:none'<?php endif; ?>>
									<label class="col-sm-2 control-label">百度搜索进入值</label>
									<div class="col-sm-6">
										<input type="text" name="baidu_value" value="<?php echo C('baidu_value');?>" placeholder="请输入百度搜索进入值" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">是否自动反水</label>
									<div class="col-sm-6">
										<select class="form-control is_baidu_select"  name="is_auto_fs">
											<option <?php if(C('is_auto_fs') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_auto_fs') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>

								 

							
						 
								<div class="form-group">
									<label class="col-sm-2 control-label">授权码</label>
									<div class="col-sm-6">
										<input type="text" name="auth_code" value="<?php echo C('auth_code');?>" placeholder="" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">防封二维码自动生成</label>
									<div class="col-sm-6">
										<!--<img src="http://sina.lt/images/go.png">-->
										<div id="qrcode">

										</div>
										<span>(推广请用二维码，拒绝用域名直接在微信间发送)</span>

									</div>
								</div>
								
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
		<script src="/Public/Admin/js/qrcode.min.js?v=1.0.0"></script>
		<script src="/Public/Admin/js/clipboard.min.js?v=1.0.0"></script>
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
			$(function(){
				$('.is_baidu_select').change(function(){
					console.log(3);
				if ($(this).val() == 1) {
					$('.baidu_value').show();
				}else {
					$('.baidu_value').hide();
				}
			})
			window.onload =function(){
                getqr();
            }

			function getqr(){
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    width : 96,//设置宽高
                    height : 96
                });
                var url = "http://"+$("#siteurl").val();
                $.post("<?php echo U('site/ajax_short_url');?>",{'url':url}, function (res) {
                    var obj = eval('(' + res + ')');
					url = obj[0]['url_short'];
                    if(url==''){
                        url = "http://"+$("#siteurl").val();
                    }
                    console.log(url);
                    qrcode.makeCode(url);
                });
			}

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