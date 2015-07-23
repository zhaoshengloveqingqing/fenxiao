<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_orderlist.css" media="all" />
<style type="text/css">
	.pages a{ padding:1px 5px 1px 5px; border-bottom:2px solid #ccc; border-right:2px solid #ccc; border-left:1px solid #ededed; border-top:1px solid #ededed; margin-left:3px; background:#fafafa}
</style>
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<nav class="order_status">
		<ul>
			<li <?php echo  $rt['type'] == '1' ? 'class="active"' : ''; ?> ><a href="<?php echo ADMIN_URL;?>user.php?act=orderlist">待付款 <?php echo  $rt['type'] == '1' ? '<i>'.$rt['order_count'] .'</i>' : ''; ?></a></li>
			<li <?php echo  $rt['type'] == '2' ? 'class="active"' : ''; ?>  ><a href="<?php echo ADMIN_URL;?>user.php?act=orderlist&type=2">待收货 <?php echo  $rt['type'] == '2' ? '<i>'.$rt['order_count'] .'</i>' : ''; ?></a></li>
			<li <?php echo  $rt['type'] == '3' ? 'class="active"' : ''; ?> ><a href="<?php echo ADMIN_URL;?>user.php?act=orderlist&type=3">全部<?php echo  $rt['type'] == '3' ? '<i>'.$rt['order_count'] .'</i>' : ''; ?></a></li>
		</ul>
	</nav>
	<div class="order_list">
		<ul>
			 <?php
			   if(!empty($rt['orderlist'])){
			   foreach($rt['orderlist'] as $k=>$row){
			  ?>
			<li>
				<a href="<?php echo ADMIN_URL. 'user.php?act=orderinfo2014&order_id='.$row['order_id'];?>">
				<?php if($row['goods']) {?>
				<?php foreach($row['goods'] as $k=>$goods) {?>
				<div class="order_top">
						<div class="order">
							<img src="<?php echo SITE_URL.$goods['goods_thumb'];?>"/>
							<div class="order_detail">
								<h3><?php echo $goods['goods_name'];?></h3>
								<p>订单时间：<?php echo date('Y-m-d H:i:s',$row['add_time']);?></p>
							</div>
						</div>
						<div class="price_number">
							<p><span class="price"><?php echo $goods['goods_price']?>元</span><span class="number">X<?php echo $goods['goods_number']?></span></p>
						</div>
				</div>
				<?php }}?>
				</a>
				<div class="order_action">
					<p>
						<?php if($row['order_status']=='1') {?>
							<a href="javascript:void(0);"  class="pay" >已取消</a>
						<?php } else if($row['pay_status']=='0' && $row['shipping_status']=='0') {?>
							<a href="<?php echo ADMIN_URL.'mycart.php?type=fastpay2&oid='.$row['order_id'];?>">立即支付</a><!-- class="pay"   -->
							<a href="<?php echo ADMIN_URL.'mycart.php?type=pay2&oid='.$row['order_id'];?>">找人代付</a>
							 <?php  if ($row['order_status']=='0') {?>								
								<a id="<?php echo $row['order_id'];?>" class="clickorder" name="cancel_order" href="javascript:void(0);">取消订单</a>
							 <?php } else if ($row['order_status']=='2' )  {?>	
							 <?php }?>
						<?php } else if ($row['pay_status']=='1' && $row['order_status']=='2') {?>
							<?php  if ($row['shipping_status']=='2') {?>
							<a id="<?php echo $row['order_id'];?>" class="clickorder" name="confirm" href="javascript:void(0);">确认收货</a>
							<a class=""  href="http://m.kuaidi100.com/index_all.html?type=<?php echo trim($row['shipping_code']);?>&postid=<?php echo trim($row['sn_id']);?>&callbackurl=<?php echo urlencode( SITE_URL.'m/user.php?act=orderlist'); ?>">查看物流</a>
							<?php }else if ($row['shipping_status']=='5') { ?>
								<a id="<?php echo $row['order_id'];?>" class="clickorder" name="tuikuan" href="javascript:void(0);">申请退货</a>
							<?php }else  if ($row['shipping_status']=='0'){ ?>
								<a id="<?php echo $row['order_id'];?>" class="clickorder" name="tuikuan" href="javascript:void(0);">申请退款</a>
							<?php }?>
						<?php } else if ($row['pay_status']=='1' && $row['order_status']=='5' &&  $row['shipping_status']=='0') {?>
								<a href="javascript:void(0);" style="width:120px;"  class="pay" >退款中，请等待...</a>
						<?php } else if ($row['pay_status']=='1' && $row['order_status']=='6' &&  $row['shipping_status']=='5') {?>
								<a href="javascript:void(0);" style="width:120px;"  class="pay" >退货中，请等待...</a>
						<?php } else if ($row['pay_status']=='1' && $row['order_status']=='5' &&  $row['shipping_status']=='4') {?>
								<a href="javascript:void(0);" style="width:120px;"  class="pay" >退款中，请等待...</a>
						<?php } else if ($row['pay_status']=='2' && $row['order_status']=='7' &&  $row['shipping_status']=='4') {?>
								<a href="javascript:void(0);" style="width:120px;"  class="pay" >已退货退款</a>
						<?php }?>
					</p>
				</div>
			</li>
			<?php }}?>
		</ul>
	</div>
	<div class="pagination">
		<?php if(!empty($rt['orderpage'])){?>
			<div class="pages"><?php echo $rt['orderpage']['showmes'];?><?php echo $rt['orderpage']['first'].$rt['orderpage']['previ'].$rt['orderpage']['next'].$rt['orderpage']['Last'];?></div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
$('.clickorder').live('click',function(){
		if(confirm("确定操作吗？")){
			createwindow();
			id = $(this).attr('id');
			na = $(this).attr('name');
			$.post('<?php echo ADMIN_URL.'user.php';?>',{action:'ajax_order_op_user',id:id,type:na},function(data){
				removewindow();
				if(data == ""){
					window.location.href = '<?php echo Import::basic()->thisurl();?>';
				}else{
					alert(data);
				}
			});
		}
		return false;
});
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>