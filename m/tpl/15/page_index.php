<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/15/css.css?v=4" media="all" />
<style type="text/css">
body{ background:#efefef !important;}
</style>
<?php //$this->element('guanzhu',array('shareinfo'=>$lang['shareinfo']));?>
<?php $ad = $this->action('banner','banner','首页轮播',5);?>
<?php if(!empty($ad)){?>
<!--顶栏焦点图-->
<div class="flexslider" style="margin-bottom:0px;">
	 <ul class="slides">
	 <?php if(!empty($ad))foreach($ad as $row){
	 $a = basename($row['ad_img']);
	 ?>			 
		<li><img src="<?php echo SITE_URL.$row['ad_img'];?>" style="width:100%" alt="<?php echo $row['ad_name'];?>"/></li>
	 <?php } ?>												
	  </ul>
</div>
<?php } ?>
<div id="main">

	<?php $this->element('15/menu_top',array('lang'=>$lang));?>	
	
	<?php
	if(!empty($rt['shareinfo'])){
		$issubscribe = $rt['shareinfo']['is_subscribe'];
	?>
	<div style="height:44px; line-height:44px; background:#FFF; width:100%; border-bottom:1px solid #ededed; position:relative">
		<img src="<?php echo $rt['shareinfo']['headimgurl'] ? $rt['shareinfo']['headimgurl'] : $this->img('account.png');?>" height="40" style="margin:2px 8px 2px 10px;" />
		<p style="  padding-top:4px; padding-bottom:4px; line-height:20px; color:#333; display: inline-table; position: absolute; top: 0; width: 140px;">
		来自<font color="#00761d">【<?php echo $rt['shareinfo']['nickname'];?>】</font>的推荐<br/><?php echo $issubscribe=='1' ? '立即购买,抢占东家地盘' : '立即关注,将享更多惊喜';?>
		</p>
		<?php if($issubscribe=='1'){?>
		<a href="<?php echo ADMIN_URL.'catalog.php';?>" style="position:absolute; right:0px; top:0px; z-index:99; cursor:pointer; width:70px; display:block; height:44px; line-height:44px; background:#F7F7F7; text-align:center; color:#00761d">进入选购</a>
		<?php }else{?>
		<a href="<?php echo $lang['wxguanzhuurl'];?>" style="position:absolute; right:10px; top:6px; z-index:99; cursor:pointer; height:35px;"><img src="<?php echo $this->img('guanzhu.png');?>" /></a>
		<?php } ?>
	</div>
	<?php } ?>
	
	<div style="padding:5px; padding-top:5px;">
    <?php if(!empty($rt['cat']))foreach($rt['cat'] as $row){?>
	<div class="indexitem" style="padding-top:0px">
		<p class="ptitle"><span><a href="<?php echo ADMIN_URL.'catalog.php?cid='.$row['cat_id'];?>"><?php echo $row['cat_name'];?></a></span></p>
		<?php if(!empty($row['cat_img'])&&file_exists(SYS_PATH.$row['cat_img'])){?>
		<p><a href="<?php echo $row['cat_url'];?>"><img src="<?php echo SITE_URL.$row['cat_img'];?>" style="width:100%"/></a></p>
		<?php } ?>
		<ul class="goodslists">
		<?php if(!empty($rt['goods'][$row['cat_id']]))foreach($rt['goods'][$row['cat_id']] as $k=>$rows){?>
			<li style="width:100%; float:left; position:relative;font-size:14px">
				<div style="padding:4px">
				<a style="background:#fff; padding:5px; display:block;" href="<?php echo ADMIN_URL.($row['is_jifen']=='1'?'exchange':'product').'.php?id='.$rows['goods_id'];?>">
					<div style="height:auto; overflow:hidden; text-align:center;">
						<img src="<?php echo SITE_URL.$rows['goods_img'];?>" style="height: auto;max-width:100%; min-height:100px;display:inline;" alt="<?php echo $rows['goods_name'];?>"/>
					</div>
					<p style="line-height:20px; height:20px; overflow:hidden; text-align:center; padding-top:5px"><?php echo $rows['goods_name'];?></p>
					<p style="line-height:25px; height:25px; overflow:hidden; color:#D30202"><span style="float:left">本店价:</span><b class="price" style="font-size:16px; float:left; padding-left:3px;">￥<?php echo str_replace('.00','',$rows['pifa_price']);?></b></p>
					<p style="line-height:20px; height:20px; overflow:hidden; color:#999999"><del>市场价:￥<?php echo str_replace('.00','',$rows['shop_price']);?></del></p>
				</a>
				</div>
				<a href="<?php echo ADMIN_URL.($row['is_jifen']=='1'?'exchange':'product').'.php?id='.$rows['goods_id'];?>">
				<span style=" margin-right:10px;width:80px; height:32px; display:block; text-align:center; line-height:32px; font-size:14px; background:#3d8b1d;border-radius:5px; position:absolute; bottom:13px; right:10px; z-index:10; color:#FFFFFF;" class="buyfals">立即购买</span>
				</a>
			</li>
		<?php } ?>
		<div class="clear"></div>
		</ul>
	</div>
<?php } ?>
<?php if(!empty($rt['listsjf'])){?>
<!--积分兑换-->
	<div class="indexitem">
		<p class="ptitle" style="position:relative"><span><a href="<?php echo ADMIN_URL.'exchange.php';?>">积分兑换</a></span><a style="position:absolute; right:5px; bottom:0px; z-index:99; font-size:12px; text-decoration:underline" class="price" href="<?php echo ADMIN_URL.'exchange.php';?>">MORE</a></p>
		<ul class="goodslists">
		<?php foreach($rt['listsjf'] as $k=>$row){?>
			<li style="width:50%; float:left;">
				<div style="padding:4px;">
				<a style="background:#fff; padding:5px; display:block;" href="<?php echo ADMIN_URL.'exchange.php?id='.$row['goods_id'];?>">
					<div style=" height:130px; overflow:hidden; text-align:center;">
						<img src="<?php echo SITE_URL.$row['goods_img'];?>" style="max-width:99%;display:inline;" alt="<?php echo $row['goods_name'];?>"/>
					</div>
					<p style="line-height:20px; height:20px; overflow:hidden; text-align:center"><?php echo $row['goods_name'];?></p>
					<p style="line-height:22px; height:22px; overflow:hidden; text-align:center; background:#fafafa; border:1px solid #ededed;border-radius:5px;">所需积分:<b class="price" style="font-size:12px;"><?php echo $row['need_jifen'];?></b></p>
				</a>
				</div>
			</li>
		<?php } ?>
		<div class="clear"></div>
		</ul>
	</div>
<?php } ?>
	</div>	
</div>

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
<?php 
	$imgurl =  !empty($lang['site_logo'])? SITE_URL.$lang['site_logo'] : $this->img('logo.jpg');
	$title =  $lang['metatitle'];
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
<div style="background:#fafafa; min-height:50px; padding-top:10px; padding-bottom:10px; line-height:24px;text-align:center;">
	<?php echo $lang['copyright'];?>
</div>
<?php //$this->element('15/footer',array('lang'=>$lang)); ?>
