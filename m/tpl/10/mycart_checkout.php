<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />

<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
{?>
	<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout-moz.css" media="all" />
<?php }?>

<?php $goodslist = $this->Session->read('cart'); ?>
<div id="shopping-list">
	<div class="list">
		<i class="gouwuche"></i>
		<h3>共<span><?php echo count($goodslist); ?></span>件商品</h3>
		<a class="contiune" href="<?php echo ADMIN_URL;?>">继续购物</a>
	</div>
	<div class="myaddress">
		<form  action="<?php echo ADMIN_URL;?>mycart.php?type=confirm" method="post" name="CONSIGNEE_ADDRESS" id="CONSIGNEE_ADDRESS">
			<div class="am-form-group">
				<?php if(!empty($rt['userress'])){?>
				<?php $userress_id = 0; foreach($rt['userress'] as $row){?>
				<div class="am-u-sm-10">
					<input type="radio" id="doc-ipt-pwd-2"  class="showaddress" <?php echo $row['is_default']=='1' ? ' checked="checked"' : '';?> name="userress_id" value="<?php echo $row['address_id'];?>">
					<div class="user_info">
						<span><?php echo $row['provincename'].$row['cityname'].$row['districtname'].$row['address']; ?></span>
						<span class="name"><?php echo $row['consignee'].'&nbsp;&nbsp;'. (!empty($row['mobile']) ? $row['mobile'] : $row['tel']);?></span>
					</div>
					<a href="javascript:;" onclick="ressinfoop('<?php echo $row['address_id'];?>','showupdate',this)" style="">修改</a>
				</div>
				<?php }}?>
			</div>
			  <?php 
				$userress_id = $userress_id > 0 ? $userress_id : (isset($rt['userress'][0]) ? $rt['userress'][0]['address_id'] : 0);
			  ?>
			<div class="am-form-group add">
				<div class="am-u-sm-10">
					<input type="radio" id="doc-ipt-pwd-2"  class="showaddress"  name="userress_id"  value="0" >
					添加新地址
				</div>
			</div>
			<div class="edit userreddinfo" <?php if(!empty($rt['userress'])) echo ' style="display:none"';?>>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名：</label>
					<div class="am-u-sm-10">
						<input type="text" id="doc-ipt-3" placeholder="输入你的姓名" value="" name="consignee"  >
					</div>
				</div>

				<div class="am-form-group">
					<label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">区域：</label>
					<?php $this->element('address',array('resslist'=>$rt['province']));?>
					<span class="am-form-caret"></span>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">地址：</label>
					<div class="am-u-sm-10">
						<input type="text" id="doc-ipt-3" placeholder="输入详细地址"  value="" name="address" >
					</div>
				</div>

				<div class="am-form-group">
					<label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">
						电话：
					</label>
					<div class="am-u-sm-10">
						<input type="text" id="doc-ipt-pwd-2" placeholder="输入11位电话号码"  value="" name="mobile" >
					</div>
				</div>
				<p class="title"><a style="cursor:pointer" onclick="ressinfoop('0','add','CONSIGNEE_ADDRESS')">添加</a></p>
			</div>
			<div class="product">
				<ul>
				 	<?php 
						  if(!empty($goodslist)){
						  $total= 0;
						  $uid = $this->Session->read('User.uid');
						  $active = $this->Session->read('User.active');
						  $rank = $this->Session->read('User.rank');
						  foreach($goodslist as $k=>$row){
							  if(!($row['goods_id'])>0) continue;
							  //赠品去掉
							  if($row['is_alone_sale']=='0'&&(empty($rt['gift_goods_ids']) || !in_array($row['goods_id'],$rt['gift_goods_ids']))){ //条件不满足者  不允许购买赠品
									$gid = $row['goods_id'];
									$this->Session->write("cart.{$gid}",null);
									continue;
							  }
							 
							  $total +=$row['price']*$row['number'];
				   ?>
					<li class="clearfix">
						<a href="<?php echo ADMIN_URL.'product.php?id='.$row['goods_id'] ;?>" ><img src="<?php echo SITE_URL.$row['goods_thumb'];?>" title="<?php echo $row['goods_name'];?>"/></a>
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
								<div  class="num_opreation">
									<a class="gjian jian">-</a>
									<input readonly="" id="<?php echo $k;?>"  name="goods_number" value="<?php echo $row['number'];?>"  class="inputBg" style="" type="text">
									<a class="gjia jia" >+</a>
								</div>
								<a class="delete delcartid" id="<?php echo $k;?>">删除</a>
							</div>
						</div>
					</li>
					<?php }}?>
				</ul>
			</div>
			<div class="empty clearfix">
				<a class="empty_btn"  href="javascript:;" onclick="return ajax_clear()">清空</a>
			</div>
			<div class="way">
				<div class="pay_way">
					<span>支付方式</span>
					<div class="am-radio">
						  <?php 
							if(!empty($rt['paymentlist'])){
								foreach($rt['paymentlist'] as $k=>$row){
						?>
						<label><input type="radio"  name="pay_id"  id="pay_id"<?php if($k=='0'){ echo ' checked="checked"';}?> value="<?php echo $row['pay_id'];?>" type="radio"><?php echo $row['pay_name'];?></label>
						<?php } }?>
					</div>
				</div>
				<div class="deliver_way">
					<span>配送方式</span>
					<div class="am-radio">
					<?php 
						$free = array();
						if(!empty($rt['shippinglist'])){
						foreach($rt['shippinglist'] as $k=>$row){
					?>
						<label>
							<input onclick="return jisuan_shopping('<?php echo $row['shipping_id'];?>')"<?php echo $k=='0' ? ' checked="checked"':'';?> name="shipping_id" id="shipping_id" value="<?php echo $row['shipping_id'];?>" type="radio" /><?php echo $row['shipping_name'];?>
						</label>
					<?php 
						$f = $this->action('shopping','ajax_jisuan_shopping',array('shopping_id'=>$row['shipping_id'],'userress_id'=>($userress_id > 0 ? $userress_id : '5')),'cart');
						$f = $f>0 ? $f : '0.00';
						$free[] = $f;
						}}	?>
					</div>
				</div>
			</div>
			<?php $free[0] = empty($free[0]) ? '0.00' : $free[0]; ?>
			<p style=" display:none;line-height:22px; color:#222; font-size:14px; font-weight:bold; color:#9A0000; padding-top:5px;">产品金额:￥<span class="ztotals"><?php echo $zp = $total;if($rt['discount']<100){?>&nbsp;X&nbsp;<?php echo str_replace('.00','',format_price($rt['discount']/10));?>折&nbsp;=&nbsp;<font class="ppzprice"><?php echo $zp = format_price($total*($rt['discount']/100));} ?></font></span>元</p>
			<p class="total">实付金额:￥
				<span class="ztotals"><?php echo $zp;?></span>+￥
				<span class="freeshopp"><?php echo $free[0];?></span>(邮费)=<span class="freeshoppandprice"><?php echo ($zp+$free[0]);?></span>元
			</p>
			<p class="action">
				<input class="submit" value="提交订单" type="submit" onclick="return checkvar()" style="cursor:pointer;"/>
			</p>
		</form>
	</div>
</div>
<?php  $thisurl = ADMIN_URL.'mycart.php'; ?> 
<script language="javascript" type="text/javascript">
//2位小数
function toDecimal(x) {  
	var f = parseFloat(x);  
	if (isNaN(f)) {  
		return;  
	}  
	f = Math.round(x*100)/100; 
	return f;  
} 

function ajax_clear(){
	if(confirm('确定清空购物车吗？')){
		window.location.href='<?php echo ADMIN_URL;?>mycart.php?type=clear';
		return true;
	}
	return false;
}
$('.showaddress').live('click',function(){
	var vv= $(this).val();
	if(vv==0){
		$('.userreddinfo').show();
	}else{
		$('.userreddinfo').hide();
	}
	//$('.userreddinfo').toggle();
});

function checkvar(){
	pp = $('input[name="pay_id"]:checked').val(); 
	if(typeof(pp)=='undefined' || pp ==""){
		alert("请选择支付方式！");
		return false;
	}
	
	ss = $('input[name="shipping_id"]:checked').val(); 
	if(typeof(ss)=='undefined' || ss ==""){
		alert("请选择配送方式！");
		return false;
	}
	
	userress_id = $('input[name="userress_id"]:checked').val();
	if(userress_id == '0' || userress_id == '' || typeof(userress_id)=='undefined'){
			consignee = $('input[name="consignee"]').val(); 
			if(typeof(consignee)=='undefined' || consignee ==""){
				alert("收货人不能为空！");
				return false;
			}
			
			provinces = $('select[name="province"]').val();
			if ( provinces == '0' )
			{
				alert("请选择收货地址！");
				return false;
			}
			
			city = $('select[name="city"]').val();
			if ( city == '0' )
			{
				alert("请完整选择收货地址！");
				return false;
			}
			
			district = $('select[name="district"]').val();
			if ( district == '0' )
			{
				alert("请完整选择收货地址！");
				return false;
			}
		
			address = $('input[name="address"]').val(); 
			if(typeof(address)=='undefined' || address ==""){
				alert("详细地址不能为空！");
				return false;
			}
			
			mobile = $('input[name="mobile"]').val(); 
			tel = $('input[name="tel"]').val(); 
			if(mobile =="" && tel ==""){
				alert("请输入手机或者电话号码！");
				return false;
			}
			if(!isMobile(mobile)){
				alert("请输入11位手机号码！");
				return false;
			}
	}	

	return true;
}

$('.delcartid').click(function(){
	if(confirm("确定移除吗")){
		gid = $(this).attr('id');
		shipping_id = $('input[name="shipping_id"]:checked').val(); 
		userress_id = "<?php echo $userress_id; ?>";
		$(this).parent().parent().parent().remove();
		obj = $(this);
		$.post('<?php echo $thisurl;?>',{action:'ajax_remove_cargoods',gid:gid, shipping_id : shipping_id, userress_id : userress_id},function(data){
			var res = $.parseJSON(data);
			$('.ztotals').html(res.price);
			$('.freeshopp').html(res.shipping);
			$('.freeshoppandprice').html(res.total);
			nn = $('.mycarts').html();
			number = $(obj).parent().parent().find('input[name="goods_number"]').val();
			$('.mycarts').html(parseInt(nn)-parseInt(number));
		});
	}
	return false;
});

//计算邮费
function jisuan_shopping(id){
		if(id=="" || typeof(id)=='undefined') return false;
		uu = $('input[name="userress_id"]:checked').val();
		if(typeof(uu)=='undefined' || uu ==""){
			alert("请选择一个收货地址！");
			return false;
		}
		createwindow();
		$.post('<?php echo $thisurl;?>',{action:'jisuan_shopping',shopping_id:id,userress_id:uu},function(data){
				if(data !="" && typeof(data) !='undefined'){
					arr = data.split('+');
					if(arr.length==2){
					$('.freeshopp').html(arr[1]);
					b = $('.ppzprice').html();
					if(b==null || typeof(b)=='undefined'){
						b = $('.ztotals').html();
					}
					
					$('.freeshoppandprice').html(toDecimal(parseFloat(b)+parseFloat(arr[1])));
					}else{
						alert(data);
					}
				}else{
					$('.freeshopp').html('0.00');
					b = $('.ppzprice').html();
					if(b==null || typeof(b)=='undefined'){
						b = $('.ztotals').html();
					}
					$('.freeshoppandprice').html(parseFloat(b));
				}
				removewindow();
		});
		
}

//数量减1
$('.jian').live('click',function(){
	ob = $(this).parent();
	numobj = ob.find('input[name="goods_number"]');
	vall = $(numobj).val();
	if(!(vall>0)){
		ob.val('1');
		return false;
	}
	if(vall>1){
		$(numobj).val((parseInt(vall)-1));
		nn = $('.mycarts').html();
		$('.mycarts').html(parseInt(nn)-1);
		change_number(numobj);
	}
});
//数量加1
$('.jia').live('click',function(){
	ob = $(this).parent();
	numobj = ob.find('input[name="goods_number"]');
	vall = $(numobj).val();
	if(!(vall>0)){
		$(ob).val('1');
		return false;
	}
	$(numobj).val((parseInt(vall)+1));
	nn = $('.mycarts').html();
	$('.mycarts').html(parseInt(nn)+1);
	change_number(numobj);
});
//改变商品价格
function change_number(obj){
	//地址ID
	userressid = $('input[name="userress_id"]:checked').val();
	if(userressid>0){}else{
		userressid = 5;
	}
	//配送ID
	shippingid = $('input[name="shipping_id"]:checked').val();
	
	id = $(obj).attr('id');
	numbers = $(obj).val();
	if(!(numbers>0)){
	 	numbers = 1;
	 	$(obj).val('1');
	}
	createwindow();
	$.post(SITE_URL+'mycart.php',{action:'ajax_change_price',id:id,number:numbers,shipping_id:shippingid,userress_id:userressid},function(data){ 
		removewindow();
		if(data.error=='0'){
			dis = <?php echo $rt['discount']<100 ? ($rt['discount']/100) : 1;?>;
			data.prices = toDecimal(data.prices * dis);
			$('.ztotals').html(data.prices);
			$('.gprice'+id).html('￥'+data.thisprice);
			$('.gzprice'+id).html('￥'+toDecimal(data.thisprice * numbers));
			ff = data.freemoney;
			$('.freeshopp').html(toDecimal(ff));
			$('.freeshoppandprice').html(toDecimal(toDecimal(data.prices) + toDecimal(ff)));
		}else{
			var ob = $('.jia').parent(),
				   numobj = ob.find('input[name="goods_number"]'),
				   vall = $(numobj).val();
			$(numobj).val((parseInt(vall)-1));
			nn = $('.mycarts').html();
			$('.mycarts').html(parseInt(nn)-1);
			alert(data.message);
		}
	}, "json");
	return true;
}
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>