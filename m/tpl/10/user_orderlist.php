<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_orderlist.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<nav class="order_status">
		<ul>
			<li class="active"><a href="#">待付款<i>2</i></a></li>
			<li><a href="#">待收货</a></li>
			<li><a href="#">全部</a></li>
		</ul>
	</nav>
	<div class="order_list">
		<ul>
			<li>
				<div class="order_top">
					<a href="#">
						<div class="order">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<div class="order_detail">
								<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
								<p>订单时间：2015年6月4日</p>
							</div>
						</div>
						<div class="price_number">
							<p><span class="price">48元</span><span class="number">X1</span></p>
						</div>
					</a>
				</div>
				<div class="order_action">
					<p>
						<a class="pay"  href="#">立即支付</a>
						<a href="#">找人代付</a>
						<a href="#">取消订单</a>
					</p>
				</div>
			</li>
			<li>
				<div class="order_top">
					<a href="#">
						<div class="order">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<div class="order_detail">
								<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
								<p>订单时间：2015年6月4日</p>
							</div>
						</div>
					</a>
					<div class="price_number">
						<p><span class="price">48元</span><span class="number">X1</span></p>
					</div>
				</div>
				<div class="order_action">
					<p>
						<a class="pay" href="#">立即支付</a>
						<a href="#">找人代付</a>
						<a href="#">取消订单</a>
					</p>
				</div>
			</li>
		</ul>
	</div>
	<div class="pagination">
		<?php if(!empty($rt['orderpage'])){?>
			<div class="pages"><?php echo $rt['orderpage']['showmes'];?><?php echo $rt['orderpage']['first'].$rt['orderpage']['previ'].$rt['orderpage']['next'].$rt['orderpage']['Last'];?></div>
		<?php } ?>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>