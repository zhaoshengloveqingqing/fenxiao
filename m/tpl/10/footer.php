
<div id="opquyubox">
	<div>
		<h2>商品分类</h2>
		<ul class="menu">
			<?php if(!empty($lang['menu']))foreach($lang['menu'] as $row){?>
			<li>
				<a href="<?php echo ADMIN_URL.'catalog.php?cid='.$row['id'];?>">
					<?php echo $row['name'];?>
					<?php if(!empty($row['cat_id'])){?>
					<ul class="sub-menu">
						<?php foreach($row['cat_id'] as $rows){?>
						<li><a href="<?php echo ADMIN_URL.'catalog.php?cid='.$rows['id'];?>"><?php echo $rows['name'];?></a></li>
						<?php } ?>
					</ul>
					<?php } } ?>
				</a>
			</li>
		</ul>
	</div>
</div>


<div id="footer">
	<nav>
		<ul id="menu" class="top_menu">
			<li><a href="<?php echo ADMIN_URL;?>"><i class="home"></i><label>首页</label></a></li> <!-- class='active' --> 
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