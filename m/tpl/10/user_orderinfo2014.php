<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_orderinfo.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<div class="order_info">
		<p>订单号:<span>32958763</span><span class="status">未付款</span></p>
		<p>订单时间：<span class="time">2015年6月4日   13:30</span></p>
	</div>
	<div class="order_address">
		<div class="order_bg">
			<p>送货地址<span class="status">未配送</span></p>
			<p class="user_info">
				<span>李明1873453456</span>
				<span>辽宁省 大连市  甘井子区  黄浦路901号</span>
			</p>
		</div>
	</div>
	<div class="order_list">
		<ul>
			<li>
				<div class="order_top">
					<a href="#">
						<div class="order">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<div class="order_detail">
								<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
							</div>
						</div>
						<div class="price_number">
							<p><span class="price">48元</span><span class="number">X1</span></p>
						</div>
					</a>
				</div>
			</li>
			<li>
				<div class="order_top">
					<a href="#">
						<div class="order">
							<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
							<div class="order_detail">
								<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
							</div>
						</div>
						<div class="price_number">
							<p><span class="price">48元</span><span class="number">X1</span></p>
						</div>
					</a>
				</div>
			</li>
		</ul>
		<p class="total">应付总金额<span class="price">48元</span></p>
		<div class="order_action">
			<p>
				<a class="pay"  href="#">立即支付</a>
				<a href="#">找人代付</a>
				<a href="#">取消订单</a>
			</p>
		</div>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>