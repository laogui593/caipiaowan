<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - 每日输赢管理</title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
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
	</style>
	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">	
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>每日输赢</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<form method="get" action="<?php echo U('Admin/Order/win_lose');?>">
									<div class="col-sm-2">
										<input type="text" placeholder="开始时间" id="starttime" name="starttime" value='<?php echo ($start); ?>' class="form-control">
									</div>		
									<div class="col-sm-2">
										<input type="text"  placeholder="结束时间" id="endtime" name="endtime" value="<?php echo ($end); ?>" class="input-sm form-control"> 
									</div>
									<div class="col-sm-2">
										<select class="form-control" name="game">
											<!--option <?php if($game == 幸运飞艇): ?>selected<?php endif; ?> value="幸运飞艇" >北京赛车</option>
											<option <?php if($game == er75sc): ?>selected<?php endif; ?> value="er75sc">极速赛车</option>
											<option <?php if($game == xyft): ?>selected<?php endif; ?> value="xyft">幸运飞艇</option-->
											<option <?php if($game == bj28): ?>selected<?php endif; ?> value="xyft">急速飞艇</option>
																						<option <?php if($game == ssc): ?>selected<?php endif; ?> value="ssc">时时彩</option>
											<!--option <?php if($game == ssc): ?>selected<?php endif; ?> value="ssc">重庆时时彩</option>
											<option <?php if($game == lhc): ?>selected<?php endif; ?> value="lhc">六合彩</option-->
										</select>
									</div>
									<button type="submit" class="btn btn-sm btn-primary"> 搜索</button> 
                                	<button class="btn btn-sm btn-primary timesearch" time="today"> 今天</button>
                                	<button  class="btn btn-sm btn-primary timesearch" time="yestoday"> 昨天</button>
                                	<button class="btn btn-sm btn-primary timesearch" time="week"> 最近一周</button>
                                	<button class="btn btn-sm btn-primary timesearch" time="month"> 最近一月</button>
								</form>
							</div>

							
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered">
									<thead>
										<tr>
											<th>平台进项流水</th>
											<th>平台出项流水</th>
											<th>平台输赢</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="100"><a href="<?php echo U('Admin/Member/pushjs');?>?starttime=<?php echo ($start); ?>&endtime=<?php echo ($end); ?>"><?php echo ($del); ?></a></td>
											<td width="100"><?php echo ($add); ?></td>
											<td width="100"><?php echo ($ying); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="pages">
								<?php echo ($show); ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		<script src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
		<script src="/Public/Admin/js/plugins/layer/laydate/laydate.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
			laydate({
			  elem: '#starttime',
			  max: laydate.now(), //+1代表明天，+2代表后天，以此类推
			  istime: true,
			  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
			});
			laydate({
			  elem: '#endtime',
			  max: laydate.now(), //+1代表明天，+2代表后天，以此类推
			  istime: true,
			  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
			});
		</script>
		<script>
			$('.timesearch').click(function(e){
				e.stopPropagation();
				var time_value = $(this).attr('time');
				location.href = "<?php echo U('Admin/Order/win_lose');?>?time="+time_value;
				return false;
			})


			$(document).ready(function() {
				$(".i-checks").iCheck({
					checkboxClass: "icheckbox_square-green",
					radioClass: "iradio_square-green",
				})
			});
		</script>
		<script>
			function del(id){
				layer.confirm('确定要删除吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Robot/del/id/" + id + ""
				});
			}
		</script>
	</body>

	
</html>