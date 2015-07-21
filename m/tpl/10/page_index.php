<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/page_index.css?v=4" media="all" />
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
	<?php
	if(!empty($rt['shareinfo'])){
		$issubscribe = $rt['shareinfo']['is_subscribe'];
	?>
	<div class="user">
		<div class="user_info">
			<img src="<?php echo $rt['shareinfo']['headimgurl'] ? $rt['shareinfo']['headimgurl'] : ADMIN_URL. 'tpl/10/images/user.png';?>"/>
			<p>来自[<em><?php echo $rt['shareinfo']['nickname'];?></em>]的推荐<br/>
				<?php echo $issubscribe=='1' ? '立即购买,抢占东家地盘' : '立即关注,将享更多惊喜';?></p>
		</div>
		<?php if($issubscribe=='1'){?>
			<a  href="<?php echo ADMIN_URL.'catalog.php';?>"><i class="select"></i><span>进入选购</span></a>
		<?php }else{?>
			<a  href="<?php echo $lang['wxguanzhuurl'];?>"  class="focus"><span>进入关注</span></a>
		<?php } ?>
	</div>
	<?php } ?>
	<div class="menu">
		<ul>
			<li><a href="<?php echo ADMIN_URL;?>user.php?act=orderlist"><img src="<?php echo ADMIN_URL;?>tpl/10/images/order_icon.png"/><label>我的订单</label></a></li>
			<li><a href="<?php echo ADMIN_URL;?>user.php?act=myerweima"><img src="<?php echo ADMIN_URL;?>tpl/10/images/qr_icon.png"/><label>我的二维码</label></a></li>
			<li><a href="<?php echo ADMIN_URL;?>user.php?act=dailicenter"><img src="<?php echo ADMIN_URL;?>tpl/10/images/distribution_icon.png"/><label>我的分销</label></a></li>
		</ul>
	</div>
	<div class="product_list">
		<?php if(!empty($rt['cat']))foreach($rt['cat'] as $row){?>
		<div class="product">
			<h3 class="title">
				<a href="<?php echo ADMIN_URL.'catalog.php?cid='.$row['cat_id'];?>"><?php echo $row['cat_name'];?></a>
			</h3>
			<?php if(!empty($row['cat_img'])&&file_exists(SYS_PATH.$row['cat_img'])){?>
			<div class="product_img">
				<a href="<?php echo $row['cat_url'];?>"><img    src="<?php echo SITE_URL.$row['cat_img'];?>" /></a>
			</div>
			<?php } ?>
			<?php if(!empty($rt['goods'][$row['cat_id']]))foreach($rt['goods'][$row['cat_id']] as $k=>$rows){?>
			<div class="product_detail">
				<a href="<?php echo ADMIN_URL.($row['is_jifen']=='1'?'exchange':'product').'.php?id='.$rows['goods_id'];?>" style="cursor:pointer;">
				<img src="<?php echo SITE_URL.$rows['goods_img'];?>"/>
				<p><span class="names"><?php echo $rows['goods_name'];?></span><span class="price"><?php echo str_replace('.00','',$rows['pifa_price']);?>元<i class="discount_price"><?php echo str_replace('.00','',$rows['shop_price']);?>元</i></span></p>
				</a>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php if(!empty($rt['listsjf'])){?>
		<div class="product points">
			<h3 class="title">
				<a href="<?php echo ADMIN_URL.'exchange.php';?>">积分兑换</a>
			</h3>
			<div class="points_list">
				<ul class="points">
					<?php foreach($rt['listsjf'] as $k=>$row){?>
					<li>
						<a href="<?php echo ADMIN_URL.'exchange.php?id='.$row['goods_id'];?>">
							<img src="<?php echo SITE_URL.$row['goods_img'];?>"/>
							<h3><?php echo $row['goods_name'];?></h3>
						</a>
						<p>所需积分<span class="points_light"><?php echo $row['need_jifen'];?></span></p>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div class="copyright">
	<?php echo $lang['copyright'];?>
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
   $this->element('10/wxshare',array('lang' =>  array_merge($lang, $wxshare) )); 
 ?>
