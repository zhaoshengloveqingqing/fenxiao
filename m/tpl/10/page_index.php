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
	<div class="user">
		<div class="user_info">
			<img src="<?php echo ADMIN_URL;?>tpl/10/images/user.png"/>
			<p>来自[<em>官网</em>]的推荐<br/>
				立即关注，将享更多惊喜</p>
		</div>
		<a><i class="select"></i><span>进入选购</span></a>
		<a class="focus"><span>进入关注</span></a>
	</div>
	<div class="menu">
		<ul>
			<li><a href="#"><i class="order"><img src="<?php echo ADMIN_URL;?>tpl/10/images/order_icon.png"/></i><label>我的订单</label></a></li>
			<li><a href="#"><i class="qr"><img src="<?php echo ADMIN_URL;?>tpl/10/images/qr_icon.png"/></i><label>我的二维码</label></a></li>
			<li><a href="#"><i class="distribution">分</i><label>我的分销</label></a></li>
		</ul>
	</div>
	<div class="product_list">
		<div class="product">
			<h3 class="title">
				浪漫花茶
			</h3>
			<div class="product">
				<img src="<?php echo ADMIN_URL;?>tpl/10/images/good.png"/>
			</div>
			<div class="product_detail">
				<img src="<?php echo ADMIN_URL;?>tpl/10/images/good.png"/>
				<p><span class="names">特级武夷特级武夷大红袍特级武夷大红袍特级武夷大红袍大红袍</span><span class="price">48元<i class="discount_price">86元</i></span</p>
			</div>
		</div>
		<div class="product">
			<h3 class="title">
				梦想绿茶
			</h3>
			<div class="product">
				<img src="<?php echo ADMIN_URL;?>tpl/10/images/good.png"/>
			</div>
			<div class="product_detail">
				<img src="<?php echo ADMIN_URL;?>tpl/10/images/good.png"/>
				<p><span class="names">特级武夷大红袍</span><span class="price">48元<i class="discount_price">86元</i></span</p>
			</div>
		</div>
		<div class="product">
			<h3 class="title">
				懒人风尚
			</h3>
			<div class="product">
				<img src="<?php echo ADMIN_URL;?>tpl/10/images/good.png"/>
			</div>
			<div class="product_detail">
				<img src="<?php echo ADMIN_URL;?>tpl/10/images/good.png"/>
				<p><span class="names">特级武夷大红袍</span><span class="price">48元<i class="discount_price">86元</i></span</p>
			</div>
		</div>
	</div>