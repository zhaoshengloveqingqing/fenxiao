<style type="text/css">
	body{padding:10px; background:#FFF}
	body,td {font-size:13px;}
	p{ height:22px; line-height:22px; margin:0px; padding:0px}
</style>
<?php 
	if(!empty($rt)){ 
	foreach($rt as $row){
	?>
	<table width="100%" border="1" style="border-collapse:collapse;border-color:#333;">
		<tr>
			<td style="padding-left:2px;padding-bottom:5px;" valign="middle" colspan="2">
				<!--<img src="http://weixin.apiqq.com/admin/images/logo.png" />-->
				<b style="font-weight:bold; font-size:22px;">商品发货单</b>
			</td>
			<td style="font-size:20px; font-weight:bold;padding-bottom:5px;" valign="middle">订单号：<?php echo $row['order_sn'];?></td>
			<td align="center"><img src="<?php echo ADMIN_URL; ?>/images/sn.jpg" /><br/><?php echo $row['order_sn'];?></td>
		</tr>
		<tr>
			<td colspan="5" style="padding:5px; text-align:left">
			<!--<p>如你有任何疑问，请根据以下信息与我们联系；</p>-->
			<p>微信：微信分销系统</p>
			<p>公司地址：<!--&nbsp;&nbsp;电话：&nbsp;&nbsp;邮箱：</p>-->
			</td>
		</tr>
	</table>
	
	<p style="border-left:1px solid #333;border-right:1px solid #333;height:16px;"></p>
	<table width="100%" border="1" style="border-collapse:collapse;border-color:#333;">
	    <tr>
	        <td width="11%">客户:</td><td><?php echo $row['consignee'];?><!-- 购货人姓名 --></td>
	        <td align="right">下单时间：</td><td><?php echo date('Y-m-d H:i:s', $row['add_time']);?><!-- 下订单时间 --></td>
	        <td align="right">支付方式：</td><td><?php echo $row['pay_name'];?><!-- 支付方式 --></td>
	       <td align="right">配送方式：</td><td><?php echo $row['shipping_name'];?><!-- 配送方式 --></td>
	    </tr>
	    <tr>
	        <td>收货地址：</td>
	        <td colspan="7">
	        <?php echo $row['province'];?>&nbsp;<?php echo $row['city'];?>&nbsp;<?php echo $row['district'];?>&nbsp;&nbsp;&nbsp;<?php echo $row['address'];?><!-- 收货人地址 -->
	        收货人：<?php echo $row['consignee'];?>&nbsp;<!-- 收货人姓名 -->
	        邮政编码：<?php echo $row['zipcode'];?><!-- 邮政编码 -->
	        电话：<?php echo $row['tel'];?> <!-- 联系电话 -->
	        手机：<?php echo $row['mobile'];?><!-- 手机号码 -->
	        </td>
			<!--<td align="right">要求配送时间：</td>
			<td align="left" width="12%"></td>-->
	    </tr>
		<tr>
				<td><b>备注：</b></td><td colspan="7"></td>
		</tr>
	</table>
	<p style="border-left:1px solid #333;border-right:1px solid #333; height:16px;"></p>
	<table width="100%" border="1" style="border-collapse:collapse;border-color:#333;">
	    	<tr align="center">
				  <th bgcolor="#cccccc">序号</th>
				  <th bgcolor="#cccccc">商品名称</th>
				  <th bgcolor="#cccccc">规格</th>
				  <th bgcolor="#cccccc">优惠价</th>
				  <th bgcolor="#cccccc">购买数量</th>
				  <th bgcolor="#cccccc">小计</th>
			 </tr>
			<?php 
			if(!empty($row['goods'])){ 
				$i = 1;
				foreach($row['goods'] as $good){
			?>
	 		 <tr>
			 	  <td align="center"><?php echo $i++; ?></td>
				  <td align="left" style="padding-left:5px;"><?php echo $good['goods_name']; ?></td>
				  <td align="center"><?php echo $good['goods_unit']; ?></td>
				  <td align="center">￥<?php echo $good['goods_price']; ?></td>
				  <td align="center"><?php echo $good['goods_number']; ?></td>
				  <td align="center">￥<?php echo $good['goods_price']; ?></td>
			 </tr>
			 <?php 
					}
				}
				?>
			<!--<tr>
					<td colspan="6" align="right">供应商会员号：<font color="red" style="font-size:14"></font>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
					<td colspan="6" align="right" style="padding-right:22px">实际支付: <font color="#FF0000">￥80.10</font></td>
			</tr>-->
			 <tr><td colspan="6">&nbsp;</td></tr>
			 		<tr>
			  <td colspan="6">
			  商品总价(不计邮费): <font color="#FF0000">￥<?php echo $row['goods_amount']; ?></font>&nbsp;&nbsp;实际收款:<font color="#FF0000">￥ <?php echo $row['goods_amount'] + $row['shipping_fee']; ?></font> &nbsp;&nbsp; 其中配运费：<font color="#FF0000">￥ <?php echo $row['shipping_fee']; ?></font>
			  </td>
			</tr>
		</table>
		<p style="height:20px"></p>
	<?php 
		}
	}
	?>
<table width="100%" border="0">
    <tr align="right"><!-- 订单操作员以及订单打印的日期 -->
        <td>打印时间： <?php echo date('Y-m-d H:i:s'); ?>&nbsp;&nbsp;&nbsp;操作者：<?php echo $this->Session->read('adminname'); ?></td>
    </tr>
</table>
<script type="text/javascript">
function load_suppliers_address(sid,obj){
	/*$.post('http://weixin.apiqq.com/user.php',{action:'get_suppliers_address',suppliers_id:sid},function(data){
		$(obj).parent().html(data);
	});
	return false;*/
}
</script>