<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/order_pay.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<p class="tips">请您及时付款,以便尽快处理订单</p>
	<div class="pay_order_list">
		<ul>
			<li>
				<div class="order_details">
					<a href="#">
						<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
					</a>
					<div class="order_info">
						<a href="#">
							<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
						</a>
						<p>零售价：<span class="price">ddd</span>本店价：<span class="discount_price">￥45元</span></p>
						<p class="number_info">数量：<span class="number">2</span></p>
					</div>
				</div>
			</li>
			<li>
				<div class="order_details">
					<a href="#">
						<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
					</a>
					<div class="order_info">
						<a href="#">
							<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
						</a>
						<p>零售价：<span class="price">ddd</span>本店价：<span class="discount_price">￥45元</span></p>
						<p class="number_info">数量：<span class="number">2</span></p>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<form>
		<div class="way">
			<div class="pay_way">
				<span>支付方式:</span>
				<div class="am-radio">
					<label>
						微信支付
					</label>
				</div>
			</div>
			<div class="deliver_way">
				<span>配送方式:</span>
				<div class="am-radio">
					<label>
						快递配送
					</label>
				</div>
			</div>
		</div>
		<p class="total">实付金额:
			<span class="ztotals">￥<?php echo $zp;?>ss</span>
			<span class="freeshopp">+￥<?php echo $free[0];?>(邮费)=</span><span class="freeshoppandprice"><?php echo ($zp+$free[0]);?>元</span>
		</p>
		<p class="action">
			<input class="pay" value="提交订单" type="submit" onclick="return checkvar()"/>
			<input class="another_pay" value="提交订单" type="submit"/>
		</p>
	</form>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
