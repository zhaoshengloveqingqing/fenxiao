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
				<p><span class="names"><?php echo $rows['goods_name'];?></span><span class="price"><?php echo str_replace('.00','',$rows['pifa_price']);?><i class="discount_price"><?php echo str_replace('.00','',$rows['shop_price']);?></i></span></p>
				</a>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="product points">
			<h3 class="title">
				<a href="#">积分兑换</a>
			</h3>
			<div class="points_list">
				<ul class="points">
					<li>
						<a href="#">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<h3>特级武夷山金骏眉红k茶</h3>
						</a>
						<p>所需积分<span class="points_light">48</span></p>
					</li>
					<li>
						<a href="#">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<h3>特级武夷山金骏眉红k茶</h3>
						</a>
						<p>所需积分<span class="points_light">48</span></p>
					</li>
					<li>
						<a href="#">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<h3>特级武夷山金骏眉红k茶</h3>
						</a>
						<p>所需积分<span class="points_light">48</span></p>
					</li>
					<li>
						<a href="#">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<h3>特级武夷山金骏眉红k茶</h3>
						</a>
						<p>所需积分<span class="points_light">48</span></p>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="copyright">
	©2015 苏州派尔网络科技有限公司
</div>