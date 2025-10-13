<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">  

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-size: 62px;">
<HEAD>
  <title><?php echo C('sitename');?>　</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="/Public/Home/new/css/index.css" />
  <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/Public/Home/new/css/page.css" />
 </HEAD>
 <BODY onload="connect(15531);">

  <header>
     <a href="javascript:history.back(-1)"><i class="ico02 back fl"></i></a>
	 <h2>极速赛车</h2>
     <i class="ico null"></i>
	 <i class="ico plus qx45 fr"></i>
	 <i class="ico plus qx0 fr"></i>
	 <!-- <a onclick="showMask()"><i class="ico service fr"></i></a> -->
	 <a onclick="javascript:window.location.href='/';"><i class="ico service fr"></i></a>
  </header>
  <div class="headblank"></div>
  <div class="gmfix"><div id="01">
 
	<div class="gmfl">
		<p class="line1">距离 <i><b></b></i> 期开奖</p>
		<p class="line2">0</p>
	</div>
	<?php if($userinfo): ?><a href='/Home/User/index'><img src="<?php echo ($userinfo["headimgurl"]); ?>" style="width:35px; height:35px; border-radius:50px;margin-left:10px"><?php endif; ?>
	<div class="gmfr">
		<p class="line3"><i><?php echo ($userinfo["nickname"]); ?></i> <span class="yeup"></span></p>
		<p class="line4"><?php echo ($userinfo["points"]); ?>元</p></a>
	</div></div>

	<div class="open" onclick="a1()">
	
	<div id="02"><span id="hqkj">第 <i><?php echo ($kjlist[0]["periodnumber"]); ?></i> 期	
	<span class="a<?php echo ($kjlist[0]["a"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["b"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["c"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["d"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["e"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["f"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["g"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["h"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["i"]); ?>"></span> <span class="a<?php echo ($kjlist[0]["j"]); ?>"></span> <span class="d"></span>
	</div>	
	
	<div id="o">
	<ul class="openmo">
	<?php if(is_array($kjlist)): $i = 0; $__LIST__ = $kjlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>第 <i><?php echo ($vo["periodnumber"]); ?></i> 期<i> &nbsp<span class="a<?php echo ($vo["a"]); ?>"></span><span class="a<?php echo ($vo["b"]); ?>"></span><span class="a<?php echo ($vo["c"]); ?>"></span> <span class="a<?php echo ($vo["d"]); ?>"></span> <span class="a<?php echo ($vo["e"]); ?>"></span> <span class="a<?php echo ($vo["f"]); ?>"></span> <span class="a<?php echo ($vo["g"]); ?>"></span> <span class="a<?php echo ($vo["h"]); ?>"></span> <span class="a<?php echo ($vo["i"]); ?>"></span> <span class="a<?php echo ($vo["j"]); ?>"></span></i></li><?php endforeach; endif; else: echo "" ;endif; ?>
	
	<!--<p><a href='/user/index.php'>点击查看更多开奖记录</a></p>-->
	</ul>
	</div>
	</div>
  </div>
<!--聊天开始-->
  <div class="main">
<ul class="betup"><p class="gonggao"><marquee scrollAmount=4 width=95%><?php echo C('welcome');?></marquee></p>
<div id="03">
<?php if(is_array($msglist)): $i = 0; $__LIST__ = $msglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['type'] == 'admin'): ?><!-- <p class="bettime"><?php echo ($vo["time"]); ?></p>
		<li class="notice"><center><?php echo (stripcslashes(htmlspecialchars_decode($vo["content"]))); ?></center></li> --><?php endif; ?>
	<?php if($vo['type'] == 'system'): ?><!--<p class="bettime"><?php echo ($vo["time"]); ?></p>
		<li class="notice"><center><?php echo (stripcslashes(htmlspecialchars_decode($vo["content"]))); ?></center></li> --><?php endif; ?>
	<?php if($vo['type'] == 'say'): $str=trim($vo['content']); if(empty($str)){return '';} $reg='/(\d{3}(\.\d+)?)/is'; preg_match($reg,$str,$result); $ress = $result[0]; $conts = str_replace($ress,"",$str); ?>
		<li><div>
		<p class="bettime"><?php echo ($vo["time"]); ?></p>
		
		<div class="uhead"><img src="<?php echo ($vo["head_img_url"]); ?>" style= "pointer-events: none;"></div><div class="betinfo"><p class="uname"><?php echo ($vo["from_client_name"]); ?>　　</p><p class="ubet">
		<span style='display:block; width:100%;' id='numbers'>第 <?=$kjlist[0]['periodnumber']+1?> 期</span>
		<span>类型:  <span class='type'> <?php echo ($conts); ?></span></span><span>金额:<?php echo ($ress); ?><img src='/public/home/images/money_icon_big.png' /></span></p></div></div></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
<li class="notices"><center>仅显示前50条竞猜记录</center></li>
</div>
</ul>
</ul>
</div>
<!--聊天结束-->

<div class="alert" id="alert"></div>
<div class="alert1" id="alert1"></div>
<div class="chat_box" onclick="$('.bm-layer-wrapper').show();$('.bm-layer').show();">
<div>
<table width="100%">
<tr>
<td><a class="bm-btn1 closer_btn bm-btn-sm" style='display:block; width:75px; font-size:14px !important; height:30px; line-height:30px; text-align:center;' href="/Home/Fen/addpage.html">充值</a></td>
<td><a class="bm-btn1 closer_btn bm-btn-sm" style='display:block; width:75px; font-size:14px; height:30px; line-height:30px; text-align:center;' href='/Home/Run/record.html'>投注记录</a></td>
<td><input type="submit" name="chat" style=" height:30px; width:75px; font-size:14px !important; font-size:16px; background:#ff9326;border:solid #ff9326 1px; color:#ffffff;" id="sendbtn" value="马上投注"></td>
</tr>
</table>
</div>
</div>
		<!-- 投注 -->
		<script type="text/javascript" src="/Public/Home/new/css/js/artDialog.js"></script>
		<script type="text/javascript" src="/Public/Home/new/css/js/page.js"></script>
		<div class="bm-layer-wrapper"></div>
		<div class="bm-layer">
			<div class="bm-layer-trigger">
				<div class="bm-layer-prev"></div>
				<div class="bm-layer-next"></div>
			</div>
			<div class="bm-layer-fixed">
				<div class="bm-box-form" style='color:#000;'>
				￥:<input type="tel" placeholder="请输入投注元宝" value="100" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"  
 onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'0')}else{this.value=this.value.replace(/\D/g,'')}" value="" maxlength="6" id="J_jine" />
					
				</div>
				<div class="bm-box-btns">
					<button class="bm-btn1 closer_btn bm-btn-sm" >收起</button>
					<a href="/Home/Run/rulebj28.html"><button type="button" class="bm-btn1 bm-btn-sm">玩法说明</button></a>
					<button type="button" class="bm-btn" id="dw_touzhu">双倍投注</button>
					<button type="button" class="bm-btn" id="J_touzhu">投注</button>
				</div>
			</div>
			<script>
				$(document).on('click','#dw_touzhu',function(){
					$('#J_jine').val($('#J_jine').val()*2);
				}).on('click','.closer_btn',function(){
					$('.bm-layer-wrapper').hide();
					$('.bm-layer').hide();
				});
			</script>
		<div class="swiper-container" style="width:320px;">
		<div class="swiper-wrapper">
		
			<div class="swiper-slide bm-box">
				<div class="bm-box-title">冠军</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li class="bm-box-list-current"><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>龙</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>虎</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-red">
				<div class="bm-box-title">亚军</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>龙</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>虎</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-green">
				<div class="bm-box-title">季军</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>龙</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>虎</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-4">
				<div class="bm-box-title">第4名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>龙</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>虎</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-5">
				<div class="bm-box-title">第5名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>龙</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>虎</span><p>1:<?php echo C('幸运飞艇_lh');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-6">
				<div class="bm-box-title">第6名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li></li><li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-7">
				<div class="bm-box-title">第7名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li></li><li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-8">
				<div class="bm-box-title">第8名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li></li><li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-9">
				<div class="bm-box-title">第9名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li></li><li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			
			<div class="swiper-slide bm-box bm-box-10">
				<div class="bm-box-title">第10名</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>大</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>小</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li></li><li><span>单</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>双</span><p>1:<?php echo C('幸运飞艇_dxds');?></p></li>
						<li><span>1</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>2</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>3</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>4</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>5</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>6</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>7</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>8</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>9</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
						<li><span>0</span><p>1:<?php echo C('幸运飞艇_chehao');?></p></li>
					</ul>
				</div>
			</div>
			<div class="swiper-slide bm-box bm-box-11">
				<div class="bm-box-title">冠亚和</div><span class='desc'>(左右滑动获取更多玩法)</span>
				<div class="bm-box-info"></div>
				<div class="bm-box-list">
					<ul>
						<li><span>和大</span><p>1:<?php echo C('幸运飞艇_tema_1');?></p></li>
						<li><span>和小</span><p>1:<?php echo C('幸运飞艇_tema_2');?></p></li>
						<li></li><li><span>和单</span><p>1:<?php echo C('幸运飞艇_tema_2');?></p></li>
						<li><span>和双</span><p>1:<?php echo C('幸运飞艇_tema_1');?></p></li>
						<li><span>和3</span><p>1:<?php echo C('幸运飞艇_tema_sz_1');?></p></li>
						<li><span>和4</span><p>1:<?php echo C('幸运飞艇_tema_sz_1');?></p></li>
						<li><span>和5</span><p>1:<?php echo C('幸运飞艇_tema_sz_2');?></p></li>
						<li><span>和6</span><p>1:<?php echo C('幸运飞艇_tema_sz_2');?></p></li>
						<li><span>和7</span><p>1:<?php echo C('幸运飞艇_tema_sz_3');?></p></li>
						<li><span>和8</span><p>1:<?php echo C('幸运飞艇_tema_sz_3');?></p></li>
						<li><span>和9</span><p>1:<?php echo C('幸运飞艇_tema_sz_4');?></p></li>
						<li><span>和10</span><p>1:<?php echo C('幸运飞艇_tema_sz_4');?></p></li>
						<li><span>和11</span><p>1:<?php echo C('幸运飞艇_tema_sz_5');?></p></li>
						<li><span>和12</span><p>1:<?php echo C('幸运飞艇_tema_sz_4');?></p></li>
						<li><span>和13</span><p>1:<?php echo C('幸运飞艇_tema_sz_4');?></p></li>
						<li><span>和14</span><p>1:<?php echo C('幸运飞艇_tema_sz_3');?></p></li>
						<li><span>和15</span><p>1:<?php echo C('幸运飞艇_tema_sz_3');?></p></li>
						<li><span>和16</span><p>1:<?php echo C('幸运飞艇_tema_sz_2');?></p></li>
						<li><span>和17</span><p>1:<?php echo C('幸运飞艇_tema_sz_2');?></p></li>
						<li><span>和18</span><p>1:<?php echo C('幸运飞艇_tema_sz_1');?></p></li>
						<li><span>和19</span><p>1:<?php echo C('幸运飞艇_tema_sz_1');?></p></li>


					</ul>
				</div>
			</div>
			
			
		</div>
		</div>
		
		<style type="text/css">
			html {
				height:100%;
			}
			.body{
				position-:fixed;
				height:100%;
				overflow:hidden;
			}
		</style>
		<script type="text/javascript">
		    /* function tel(){
		    document.getElementById("J_jine").focus()
		    } */
			var tmp_top;
			$('#J_jine').focus(function(){
				tmp_top = $('body').scrollTop();
				$("body").scrollTop( $('body').height() );
			}).blur(function(){
				$("body").scrollTop( tmp_top );
			})
				;(function(){
				$('.Q_quxiao').click(function(){
					$('.bm-layer-wrapper').click();
					art.dialog({
						content: '确定要取消本次投注吗？',
						lock: 1,
						ok: function(){
							$.ajax({
								url:'qx.php?do=2',
								data: {
								},
								success: function(data){
									//alert(data)
									document.getElementById("alert1").innerHTML=data
									$(".alert1").show();
									setTimeout( "$('.alert1').fadeOut()" , 1000)
								}
							})
						},
						cancelVal: '关闭'
						,cancel: function(){
							//alert(2)
						}
					});
					return !1;
				});
					$('.J_quxiao').click(function(){
					$('.bm-layer-wrapper').click();
					art.dialog({
						content: '确定要取消本期全部投注吗？',
						lock: 1,
						ok: function(){
							$.ajax({
								url:'qx.php?do=1',
								data: {
								},
								success: function(data){
									//alert(data)
									document.getElementById("alert1").innerHTML=data
									$(".alert1").show();
									setTimeout( "$('.alert1').fadeOut()" , 1000)
								}
							})
						},
						cancelVal: '关闭'
						,cancel: function(){
							//alert(2)
						}
					});
					return !1;
				})
				var mySwiper;
				mySwiper = new Swiper('.swiper-container');
				$('.bm-layer-prev').on('click', function(e){
					mySwiper.swipePrev();
				})
				$('.bm-layer-next').on('click', function(e){
					mySwiper.swipeNext();
				})
				$('.bm-box-list li').click(function(){
					$(this).addClass('bm-box-list-current').siblings().removeClass('bm-box-list-current');
				})
				$('#J_show').click(function(){
					$('.bm-layer-wrapper').show();
					$('.bm-layer').show();
				})
				$('.bm-layer-wrapper').click(function(){
					$('.bm-layer-wrapper').hide();
					$('.bm-layer').hide();
				})
				// 第几名/大小单双/金额
				$('#J_touzhu').click(function(){
					var active = $('.swiper-slide-active');
					var lx = $('.bm-box-title', active).html()
					var lx1 = [];
					$('.bm-box-list-current', active).each(function(){
						lx1.push( $(this).find('span').html().replace('和', '') );
					})
					lx1 = lx1.join('');
					var je = $('#J_jine').val();
					
					if( !lx1.length ){
						//alert('金额不能为空。');
						document.getElementById("alert").innerHTML="类型不能为空";
						$(".alert").show();
						setTimeout( "$('.alert').fadeOut()" , 1000)
						return !1;
					}
					if( !je.length ){
						//alert('金额不能为空。');
						document.getElementById("alert").innerHTML="金额不能为空";
						$(".alert").show();
						setTimeout( "$('.alert').fadeOut()" , 1000)
						return !1;
					}
					
					//alert(lx+'/'+lx1+'/'+je);
					//return !1;
					if(lx == '冠军'){
						lx = '1';
					}else if(lx == '亚军'){
						lx = '2';
					}else if(lx == '季军'){
						lx = '3';
					}else if(lx == '第4名'){
						lx = '4';
					}else if(lx == '第5名'){
						lx = '5';
					}else if(lx == '第6名'){
						lx = '6';
					}else if(lx == '第7名'){
						lx = '7';
					}else if(lx == '第8名'){
						lx = '8';
					}else if(lx == '第9名'){
						lx = '9';
					}else if(lx == '第10名'){
						lx = '0';
					}else if(lx == '冠亚和'){
						lx = '和';
					}
					
					
					
					var data = "";
					if(lx1 == '龙' || lx1 == '虎'){
						data = lx+'/'+lx1+'/'+je;
					}else if(lx != '和' && (lx1 == '0' || lx1 == '1' || lx1 == '2' || lx1 == '3' || lx1 == '4' || lx1 == '5' || lx1 == '6' || lx1 == '7' || lx1 == '8' || lx1 == '9')){
						data = lx+'/'+lx1+'/'+je;
					}else if(lx == '和' && (lx1 == '大' || lx1 == '小' || lx1 == '单' || lx1 == '双')){
						data = lx+lx1+je;
					}else if(lx == '和'){
						data = lx+lx1+'/'+je;
					}else{
						data = lx+lx1+je;
					}
					console.log(data);
					onSubmit(data);
					
				})
			})();
		</script>

		<!--推送-->
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
 
		<script src='/Public/Common/js/socket.io.js'></script>
		<!--推送-->
		
		<script>
		
		var count = 0;
		var settime;
		function countDown(){
			$.ajax({
				url:'/Home/Get/get幸运飞艇',
				data: {
				},
				success: function(data){
					data = JSON.parse(data);
					$(".line1").html("距离 <i><b>"+data.next.periodNumber+"</b></i> 期开奖");
					count = data.next.awardTimeInterval/1000;
					//console.log(count);
					executeCountDown();
					settime = setInterval(function() {
						executeCountDown();
					}, 1000);
				}
			})
		}
		var show = 1;
		function executeCountDown(){
		    //console.log(<?php echo C('幸运飞艇_stop_time');?>);
			if(count == 0){
				$(".line2").html("正在开奖");
				
			}else if(count <= <?php echo C('幸运飞艇_stop_time');?> && show == 1){
				count = count - 1;
				$(".line2").html("已封盘");
				$('#J_touzhu').attr("disabled",true);
				$("#J_touzhu").css("background-color","#c7c7c7");
				show = 0;
			}else{
				count = count - 1;
				chn_num = s_to_hs(count);
				$(".line2").html(chn_num);
			}
		}
		
		countDown();
		
		
		</script>
</div>

<!--websocket-start-->
<div class="rmenu">
<!-- <a href="/Home/Run/record.html">投注记录</a> -->
<!--<?php if(C('quick_pay') == '1' and $userinfo != null): ?><a href="<?php echo C('quick_pay_domain');?>/pay/index.php?appid=<?php echo C('quick_pay_appid');?>&payno=<?php echo ($userinfo["id"]); ?>">在线充值</a>
<?php else: ?>
<a href="/Home/Fen/addpage.html">在线充值</a><?php endif; ?>
<!-- <a href="<?php echo U('Home/Run/tui');?>?uid=<?php echo ($userinfo["id"]); ?>">推广赚钱</a> -->

<a href="/Home/Fen/addpage.html">在线充值</a>
<a href="/Home/Fen/xiapage.html">快速提现</a>

<a href="/Home/Run/rule幸运飞艇.html">游戏规则</a>
</div>


<script>
$(".bm-btn").click(function(){
	  //$(".alert").show();
	  //setTimeout( "$('.alert').fadeOut()" , 1000)
 });
$(".f").click(function(){
	  $(".alert1").show();
	  setTimeout( "$('.alert1').fadeOut()" , 1000)
 });
function a1()
{
	$(".openmo").slideToggle();
}
 $(".ufmenu, .ufup").click(function(){
      $(".ufix").animate({height:"0"});
	   $("header").show();
 });

 $(".menu").click(function(){
      $(".ufix").animate({height:"100%"});
	  $("header").hide();

 });

$(".qx0").click(function(){
      $(".rmenu").show(300);
      $(this).hide();
	  $(".qx45").show();
 });
$(".qx45").click(function(){
      $(".rmenu").hide(300);
      $(this).hide();
	  $(".qx0").show();
 });
$(".plsm").click(function(){
      $(".peilv").show();
	   $(".main, .gmfix").hide();
 });
 $(".pltit span").click(function(){
      $(".peilv").hide();
	  $(".main, .gmfix").show();
 });
function showMask(){     
$("#mask").css("height",$(document).height());     
$("#mask").css("width",$(document).width());     
$("#mask").show();     
}  
function hideMask(){     
$("#mask").hide();     
}
</script>
<div id="mask" class="mask" onclick="hideMask()"><img src="<?php if($kefu[kefu] != ''): ?>/Uploads/<?php echo ($kefu[kefu]); else: ?>/Public/Admin/img/no_img.jpg<?php endif; ?>" /></div>
</body>
</html>

    <foot>
      <ul class="foot">
          <li><a href='/Home/Run/rule幸运飞艇.html'><i class="gz"></i><br>规则</a></li>
          <li><a  href='/Home/Run/record.html'><i class="jl"></i><br>记录</a></li>
          <li><a href="<?php echo U('Home/Run/tui');?>?uid=<?php echo ($userinfo["id"]); ?>"><i class="news" ></i><br>推广</a></li>
          <li><a onclick="showMask()"><i class="kf"></i><br>客服</a></li>
          <?php if(C('quick_pay') == '1' and $userinfo != null): ?><li><a  href="<?php echo C('quick_pay_domain');?>/pay/index.php?appid=<?php echo C('quick_pay_appid');?>&payno=<?php echo ($userinfo["id"]); ?>"><i class="charge"></i><br>充值</a></li>
		  <?php else: ?>
		  <li><a  href="/Home/Fen/addpage.html"><i class="charge"></i><br>充值</a></li><?php endif; ?>
          <li><a  href='/Home/User/index'><i class="wd"></i><br>我的</a></li>
      </ul>
  </foot>

 <div id="04">
	</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>