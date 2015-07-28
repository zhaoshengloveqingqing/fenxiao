<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_orderinfo.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<div class="order_info">
		<p>订单号:<span><?php echo $rt['orderinfo']['order_sn'];?></span><span class="status"><?php echo $rt['status'][1];?></span></p>
		<p>订单时间：<span class="time"><?php echo date('Y-m-d H:i:s', $rt['orderinfo']['add_time']); ?></span></p>
	</div>
	<div class="order_address">
		<div class="order_bg">
			<p>送货地址<span class="status"><?php echo $rt['status'][2];?></span></p>
			<p class="user_info">
				<span><?php echo $rt['orderinfo']['consignee'];?> <?php echo $rt['orderinfo']['mobile'];?></span>
				<span><?php echo $rt['orderinfo']['province'].$rt['orderinfo']['city'].$rt['orderinfo']['district'].$rt['orderinfo']['address'];?></span>
			</p>
		</div>
	</div>
	<div class="order_list">
		<ul>
			<?php if(!empty($rt['goodslist']))foreach($rt['goodslist'] as $row){?>
			<li>
				<div class="order_top">
					<a href="#">
						<div class="order">
							<img src="<?php echo SITE_URL.$row['goods_thumb'];?>"  title="<?php echo $row['goods_name'];?>"/>
							<div class="order_detail">
								<h3><?php echo $row['goods_name'];?></h3>
							</div>
						</div>
						<div class="price_number">
							<p><span class="price"><?php echo $row['goods_price'];?>元</span><span class="number">X<?php echo $row['goods_number'];?></span></p>
						</div>
					</a>
				</div>
			</li>
			<?php } ?>
		</ul>
		<p class="total">应付总金额<span class="price"><?php echo $rt['orderinfo']['order_amount'];?>元</span></p>
		<div class="order_action">
			<p>
				<?php if($rt['orderinfo']['order_status']=='1') {?>
					<a href="javascript:void(0);"  class="pay" >已取消</a>
				<?php } else if($rt['orderinfo']['pay_status']=='0' && $rt['orderinfo']['shipping_status']=='0') {?>
					<a href="<?php echo ADMIN_URL.'mycart.php?type=fastpay2&oid='.$rt['orderinfo']['order_id'];?>">立即支付</a><!-- class="pay"   -->
					<a href="<?php echo ADMIN_URL.'mycart.php?type=pay2&oid='.$rt['orderinfo']['order_id'];?>">找人代付</a>
					 <?php  if ($rt['orderinfo']['order_status']=='0') {?>								
						<a id="<?php echo $rt['orderinfo']['order_id'];?>" class="clickorder" name="cancel_order" href="javascript:void(0);">取消订单</a>
					 <?php } else if ($rt['orderinfo']['order_status']=='2' )  {?>	
					 <?php }?>
				<?php } else if ($rt['orderinfo']['pay_status']=='1' && $rt['orderinfo']['order_status']=='2') {?>
					<?php  if ($rt['orderinfo']['shipping_status']=='2') {?>
					<a id="<?php echo $rt['orderinfo']['order_id'];?>" class="clickorder" name="confirm" href="javascript:void(0);">确认收货</a>
					<a class=""  href="http://m.kuaidi100.com/index_all.html?type=<?php echo trim($rt['orderinfo']['shipping_code']);?>&postid=<?php echo trim($rt['orderinfo']['sn_id']);?>&callbackurl=<?php echo urlencode( SITE_URL.'m/user.php?act=orderlist'); ?>">查看物流</a>
					<?php }else if ($rt['orderinfo']['shipping_status']=='5') { ?>
						<a id="<?php echo $rt['orderinfo']['order_id'];?>" class="clickorder" name="tuikuan" href="javascript:void(0);">申请退货</a>
					<?php }else  if ($rt['orderinfo']['shipping_status']=='0'){ ?>
						<a id="<?php echo $rt['orderinfo']['order_id'];?>" class="clickorder" name="tuikuan" href="javascript:void(0);">申请退款</a>
					<?php }?>
				<?php } else if ($rt['orderinfo']['pay_status']=='1' && $rt['orderinfo']['order_status']=='5' &&  $rt['orderinfo']['shipping_status']=='0') {?>
						<a href="javascript:void(0);" style="width:120px;"  class="pay" >退款中，请等待...</a>
				<?php } else if ($rt['orderinfo']['pay_status']=='1' && $rt['orderinfo']['order_status']=='6' &&  $rt['orderinfo']['shipping_status']=='5') {?>
						<a href="javascript:void(0);" style="width:120px;"  class="pay" >退货中，请等待...</a>
				<?php } else if ($rt['orderinfo']['pay_status']=='1' && $rt['orderinfo']['order_status']=='5' &&  $rt['orderinfo']['shipping_status']=='4') {?>
						<a href="javascript:void(0);" style="width:120px;"  class="pay" >退款中，请等待...</a>
				<?php } else if ($rt['orderinfo']['pay_status']=='2' && $rt['orderinfo']['order_status']=='7' &&  $rt['orderinfo']['shipping_status']=='4') {?>
						<a href="javascript:void(0);" style="width:120px;"  class="pay" >已退货退款</a>
				<?php }?>
			</p>
		</div>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>