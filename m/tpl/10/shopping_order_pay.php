<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/order_pay.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<p class="tips">
		<?php if($rt['orderinfo']['pay_status'] =='1'){?>
		已支付订单，<br>及时在会员中心留意订单状态！
		<?php }elseif($rt['orderinfo']['pay_status'] =='2'){?>
		已退款，<br>请及时将货品退还！
		<?php } else{?>
		请您及时付款，<br>以便订单尽快处理！
		<?php } $ordergoods = $rt['goodslist'];?>
	</p>
	<div class="pay_order_list">
		<ul>
			<?php if(!empty($ordergoods)) foreach($ordergoods as $row){?>
			<li>
				<div class="order_details">
					<a href="<?php echo ADMIN_URL.'product.php?id='.$row['goods_id']?>">
						<img src="<?php echo SITE_URL.$row['goods_thumb'];?>"  title="<?php echo $row['goods_name'];?>" />
					</a>
					<div class="order_info">
						<a href="<?php echo ADMIN_URL.'product.php?id='.$row['goods_id']?>">
							<h3><?php echo $row['goods_name'];?></h3>
						</a>
						<?php if(!empty($row['goods_attr'])){
						 echo '<p class="price">'.$row['goods_attr'].'</p>';
						 } ?>
						<p>零售价：<span class="price">￥<?php echo $row['market_price'];?></span>本店价：<span class="discount_price">￥<?php echo $row['goods_price'];?></span></p>
						<p class="number_info">数量：<span class="number"><?php echo $row['goods_number'];?><?php  echo $row['goods_unit'];?></span></p>
					</div>
				</div>
			</li>
			<?php }?>
		</ul>
	</div>
	<form>
		<div class="way">
			<div class="pay_way">
				<span>支付方式:</span>
				<div class="am-radio">
					<label><?php echo $rt['orderinfo']['pay_name'];?></label>
				</div>
			</div>
			<div class="deliver_way">
				<span>配送方式:</span>
				<div class="am-radio">
					<label><?php echo $rt['orderinfo']['shipping_name'];?></label>
				</div>
			</div>
		</div>
		<p class="total">实付金额:
			<span class="ztotals">￥<?php echo $rt['orderinfo']['order_amount'];?></span>
			<span class="freeshopp">+￥<?php echo $rt['orderinfo']['shipping_fee'];?>(邮费)=</span>
			<span class="freeshoppandprice"><?php echo format_price($rt['orderinfo']['order_amount']+$rt['orderinfo']['shipping_fee']);?>元</span>
		</p>
		<?php if($rt['orderinfo']['pay_status'] !='1'){?>
		<p class="action">
			<a href="<?php echo ADMIN_URL.'mycart.php?type=fastpay2&oid='.$rt['orderinfo']['order_id'];?>"  class="pay" >立即支付</a>
			<a href="#" onclick="$('.show_zhuan').show();" class="another_pay" >找人代付</a>
		</p>
		<?php } ?>
	</form>
</div>
<div class="show_zhuan"
     style=" display:none;width:100%; height:100%; position:absolute; top:0px; right:0px; z-index:9999999;
		     filter:alpha(opacity=90);-moz-opacity:0.9;opacity:0.9; background:url(<?php echo $this->img('gz/121.png');?>) right top no-repeat #000;
		     background-size:100% auto;" onclick="$(this).hide();">

</div>
<script type="text/javascript">
	$('.another_pay').click(function (){
		$('body').addClass('hiden');
	});
</script>
<?php
 $thisurl = Import::basic()->thisurl();
 $rr = explode('?',$thisurl);
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
	$wxshare = array(
		'title' => '炫耀一下，支付一下吧',
		'imgUrl' =>  $this->img('ico-success.png'),
		'desc' => '有惊喜哦',
		'link' => $thisurl,
		'is_record' => 0
	);
	$this->element('15/wxshare', array('lang'=>array_merge($lang, $wxshare))); 
?>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
