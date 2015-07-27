<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_mycoll.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="product">
		<ul>
			<li class="clearfix">
				<img src="<?php echo SITE_URL.$row['goods_thumb'];?>" title="<?php echo $row['goods_name'];?>"/>
				<div class="product_detail">
					<h3><?php echo $row['goods_name'];?></h3>
					<?php if(!empty($row['spec'])){
						echo '<p   class="price">'.implode("、",$row['spec']).'</p>';
					} ?>
					<p  class="price">
						<?php echo str_replace('.000','',$row['goods_weight']);?>克
					</p>
					<p class="price">零售价：<em><?php echo $row['shop_price'];?>元</em>本店价：<em><?php echo $row['price']>0 ? $row['price']  : $row['pifa_price'];?>元</em></p>
					<div class="opreation">
						<a class="shoping" id="<?php echo $k;?>">加入购物车</a>
						<a class="delete delcartid" id="<?php echo $k;?>">删除</a>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
