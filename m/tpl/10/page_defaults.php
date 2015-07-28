<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/15/css.css" media="all" />
<style type="text/css">
body{
	margin-bottom: 105px !important;
}
.indexcon{ text-align:center}
.indexcon img{ max-width:100%;}
.footffont{ line-height:24px; position:relative}
.footffontbox{ position:absolute; left:0px; right:0px; top:0px; z-index:9; text-align:center; line-height:24px;}
.gototop{height:32px; line-height:32px; position:fixed; bottom:65px; left:0px; right:0px; padding-right:5px; padding-left:5px; display:block}
</style>
<div id="main">
	<div class="indexcon">
			<?php
			echo $rt['tj']['goods_desc'];
			?>
	</div>	
</div>
<div class="footffont">
	<div class="footffontbox">
	<?php echo $lang['copyright'];?>
	</div>
</div>
<div class="show_zhuan" style=" display:none;width:100%; height:100%; position:absolute; top:0px; right:0px; z-index:9999999;filter:alpha(opacity=90);-moz-opacity:0.9;opacity:0.9; background:url(<?php echo $this->img('gz/121.png');?>) right top no-repeat #000;background-size:100% auto;" onclick="$(this).hide();"></div>
<?php
 $thisurl1 = Import::basic()->thisurl();
 $rr = explode('?',$thisurl1);
 $t2 = isset($rr[1])&&!empty($rr[1]) ? $rr[1] : "";
 $dd = array();
 if(!empty($t2)){
 	$rr2 = explode('&',$t2);
	if(!empty($rr2))foreach($rr2 as $v){
		$rr2 = explode('=',$v);
		if($rr2[0]=='from' || $rr2[0]=='isappinstalled'|| $rr2[0]=='code'|| $rr2[0]=='state') continue;
		$dd[] = $v;
	}
 }
 $thisurl = $rr[0].'?'.(!empty($dd) ? implode('&',$dd) : 'tid=0');
?>
<script type="text/javascript">
function show_zhuan(){
	$('.show_zhuan').show();
	$('body,html').animate({scrollTop:0},500);
}
</script>
<?php 
	$imgurl = !empty($rt['tj']['goods_thumb'])? SITE_URL.$rt['tj']['goods_thumb'] : $this->img('logo.jpg');
	$title =  $rt['tj']['goods_name'] ? $rt['tj']['goods_name'] : $lang['metatitle'];
	$params = array(
		'title' => $title,
		'action' => 'ajax_share',
		'thisurl' => $thisurl,
		'imgurl' => $imgurl
	);
	$wxshare = array(
		'title' => $title,
		'imgUrl' =>  $imgurl,
		'desc' =>  $title,
		'link' => $thisurl,
		'is_record' => 1,
		'ajax_url' => ADMIN_URL.'product.php',
		'ajax_params' => $params,
	);
   $this->element('15/wxshare',array('lang' =>  array_merge($lang, $wxshare) )); 
 ?>
<?php
if($rt['uinfo']['is_subscribe']=='0'){
	$urls = $lang['wxguanzhuurl'];
	$desc = '立即关注，将获得更多的折扣！';
	$but = '进入关注';
	$sub = '';
	$true = "false";
 }elseif($rt['uinfo']['user_rank']=='1'){
	$urls = ADMIN_URL.'product.php?id='.$rt['tj']['goods_id'];
	$desc = '你还不是合伙人,请购买成为合伙人！';
	$but = '立即购买';
	$sub = '';
	$true = "false";
 }else{
	$urls = 'javascript:;';
	$desc = '你已经是合伙人,推荐赚佣金吧！';
	$but = '我要分享';
	$sub = ' onclick="show_zhuan();"';
	$true = "true";
 }
?>
<?php
if($true=="true"){
?>
<div style="position:fixed; bottom:48px; right:5px; z-index:99; width:100px">
<input type="button" id="cart" class="addcar" value="我要购买" style="cursor:pointer; width:100%; background:#EB5566" onclick="return addToCart('<?php echo $rt['tj']['goods_id'];?>','jumpshopping')">
</div>
<?php
}
?>
<div style=" position:relative;height:76px; line-height:76px; background:#F7F7F7;  position:fixed; bottom:0px; left:0px; width:100%; z-index:9999;">
	<img src="<?php echo $rt['uinfo']['headimgurl'];?>" height="65" style="margin:6px 8px 2px 10px; float:left;vertical-align: middle" />
	<p style=" padding-top:10px; padding-bottom:2px; line-height:30px; color:#333; font-weight:bold">
	来自好友<font color="#EB5566"><?php echo $rt['tjr']['nickname'];?></font>的推荐<br/><?php echo $desc;?>
	</p>
	<a href="<?php echo $urls;?>" style=" position:absolute; right:10px; top:10px; z-index:99; cursor:pointer; height:25px; line-height:25px;
	 width:60px; border:1px solid #FFF;border-radius: 1px; text-align:center; color:#FFF;background: #EB5566"<?php echo $sub;?>><?php echo $but;?></a>
</div>