
<div id="opquyubox">
	<!--<p><img src="<?php echo $this->img('homeMenuTop.png');?>" width="100%" /></p>-->
	<div style="line-height:26px;">
	<!--	<h2 style="border-bottom:1px solid #ededed;"><a href="<?php echo ADMIN_URL.'exchange.php';?>">积分兑换</a></h2>-->
	<?php if(!empty($lang['menu']))foreach($lang['menu'] as $row){?>
		<h2 style="border-bottom:1px solid #ededed;"><a href="<?php echo ADMIN_URL.'catalog.php?cid='.$row['id'];?>"><?php echo $row['name'];?></a></h2>
		<?php if(!empty($row['cat_id'])){?>
		<div style=" line-height:14px; padding-left:15px">
			<?php foreach($row['cat_id'] as $rows){?>
			<a href="<?php echo ADMIN_URL.'catalog.php?cid='.$rows['id'];?>"><?php echo $rows['name'];?></a>
			<?php } ?>
		</div>
	<?php } } ?>
	</div>
	<div style=" height:45px;"></div>
</div>


<div id="footer">
	<nav>
		<ul id="menu" class="top_menu">
			<li><a class='active' href="<?php echo ADMIN_URL;?>"><i class="home"></i><label>首页</label></a></li>
			<li><a href="javascript:void(0)" onclick="ajaxopquyu()"><i class="category"></i><label>分类</label></a></li>
			<li><a href="<?php echo ADMIN_URL.'user.php';?>"><i class="user"></i><label>我的地盘</label></a></li>
			<li>
				<a href="<?php echo ADMIN_URL;?>mycart.php" style="height:56px; padding:0px; border:none">
				<span class="shop_num">1</span>
				<i class="shopping"></i>
				<label>购物车</label>
				</a>
			</li>
		</ul>
	</nav>
</div>