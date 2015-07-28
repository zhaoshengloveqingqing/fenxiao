<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_mycoll.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="product">
		<ul>
		<?php if(!empty($rt['lists'])){
		foreach($rt['lists'] as $row){
		?>
			<li class="clearfix">
				<a href="<?php echo ADMIN_URL.'product.php?id='.$row['goods_id'];?>"><img src="<?php echo SITE_URL.$row['goods_thumb'];?>" title="<?php echo $row['goods_name'];?>"/></a>
				<div class="product_detail">
					<h3><?php echo $row['goods_name'].'&nbsp;&nbsp;<font color=red>￥'.$row['pifa_price'].'</font>';?></h3>
					<?php if(!empty($row['spec'])){
						echo '<p   class="price">'.implode("、",$row['spec']).'</p>';
					} ?>
					<p class="price">市场价：<em><?php echo $row['market_price'];?>元</em>本店价：<em><?php echo $row['shop_price']>0 ? $row['shop_price']  : $row['pifa_price'];?>元</em></p>
					<div class="opreation">
						<a href="javascript:void(0);" class="shoping" onclick="return addToCart('<?php echo $row['goods_id'];?>', 'jumpshopping')">加入购物车</a>
						<a href="javascript:void(0);" class="delete delcartid"  onclick="delmycoll('<?php echo $row['rec_id'];?>',this)">删除</a>
					</div>
				</div>
			</li>
		<?php } } ?>
		</ul>
	</div>
	<?php if(!empty($rt['pages'])){?>
	<div class="pages">
		<?php echo $rt['pages']['showmes'];?><?php echo $rt['pages']['first'].$rt['pages']['previ'].$rt['pages']['next'].$rt['pages']['Last'];?>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
function delmycoll(ids,obj){
	thisobj = $(obj).parent().parent().parent();
	if(confirm("确定删除吗？")){
		createwindow();
		$.post(SITE_URL+'user.php',{action:'delmycoll',ids:ids},function(data){
			removewindow();
			if(data == ""){
				thisobj.hide(300);
			}else{
				alert(data);	
			}
		});
	}else{
		return false;	
	}
}
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
