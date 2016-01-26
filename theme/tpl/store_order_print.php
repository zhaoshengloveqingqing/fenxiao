<style type="text/css">
body,td {font-size:13px;}
p{ line-height:22px; margin:0px; padding:0px}
</style>
<table width="350" border="1" style="border-collapse:collapse;border-color:#333;">
	<tr>
		<td style="padding-left:2px;" valign="bottom" colspan="2"><img src="<?php echo $this->img('logo.gif');?>" width="120" /><b style="font-weight:bold; font-size:20px;">商品发货单</b></td>
		<td align="center" colspan="2"><img src="<?php echo $this->img('sn.jpg');?>" /><br/><?php echo $rt['orderinfo']['order_sn'];?></td>
	</tr>
	<tr>
		<td colspan="5" style="padding:5px; text-align:left">
		<p>如你有任何疑问，请根据以下信息与我们联系；</p>
		<p>官方网站：<?php echo $GLOBALS['LANG']['site_name'];?>(<?php echo SITE_URL;?>)</p>
		<p>客服电话：<?php echo implode(',',$GLOBALS['LANG']['custome_phone']);?><br/>客服邮箱：<?php echo $GLOBALS['LANG']['custome_email'];?><br/>公司地址：<?php echo $GLOBALS['LANG']['company_url'];?></p>
		</td>
	</tr>
</table>
<p style="border-left:1px solid #333;border-right:1px solid #333;height:16px; width:348px"></p>
<table width="350" border="1" style="border-collapse:collapse;border-color:#333;">
    <tr>
        <td width="20%">客户:</td><td><?php echo $rt['orderinfo']['consignee'];?><!-- 购货人姓名 --></td>
        <td>下单时间：</td><td><?php echo date('Y-m-d H:i:s',$rt['orderinfo']['add_time']);?><!-- 下订单时间 --></td>
	</tr>
	<tr>
       <td>支付方式：</td><td><?php echo $rt['orderinfo']['pay_name'];?><!-- 支付方式 --></td>
       <td>配送方式：</td><td><?php echo $rt['orderinfo']['shipping_name'];?><!-- 配送方式 --></td>
    </tr>
    <tr>
        <td>收货地址：</td>
        <td colspan="3">
        <?php echo $rt['orderinfo']['province'].'&nbsp;'.$rt['orderinfo']['city'].'&nbsp;'.$rt['orderinfo']['district'].'&nbsp;'.$rt['orderinfo']['towns'].'&nbsp;'.$rt['orderinfo']['villages'].'&nbsp;';?><?php echo $rt['orderinfo']['shipping_id']==6? $rt['orderinfo']['peisongname'] : $rt['orderinfo']['address'];?><br/>
        收货人：<?php echo $rt['orderinfo']['consignee'];?><br/>
        <!-- 邮政编码 -->
        电话：<?php echo $rt['orderinfo']['tel'];?>&nbsp; <!-- 联系电话 -->
        手机：<?php echo $rt['orderinfo']['mobile'];?><!-- 手机号码 -->
        </td>
		<!--<td align="right">要求配送时间：</td>
		<td align="left" width="12%"><?php echo $rt['orderinfo']['best_time'];?></td>-->
    </tr>
</table>
<p style="border-left:1px solid #333;border-right:1px solid #333; height:16px; width:348px"></p>
<table width="350" border="1" style="border-collapse:collapse;border-color:#333;">
    	<tr align="center">
			  <th bgcolor="#cccccc">序号</th>
			  <th bgcolor="#cccccc">商品名称</th>
			  <th bgcolor="#cccccc">规格</th>
			  <th bgcolor="#cccccc">优惠价</th>
			  <th bgcolor="#cccccc">数量</th>
			  <th bgcolor="#cccccc">小计</th>
		 </tr>
		 <?php
		  if(!empty($rt['goodslist'])){
		  $total= 0;
		  $jifen_total = 0;
		  foreach($rt['goodslist'] as $k=>$row){
			  if($row['from_jifen'] > 0){
				$jifen_total +=$row['from_jifen'];
			  }else{
				$total +=$row['goods_price']*$row['goods_number'];
			  }
		  ?>
		 <tr>
		 	  <td><?php echo ++$k;?></td>
			  <td align="left" style="padding-left:5px;">
			  <?php echo ($row['is_gift']==1 ? $row['goods_name'] : $row['goods_name']); if(!empty($row['buy_more_best'])){echo '<br /><font style="color:#FE0000;font-weight:bold">['.$row['buy_more_best'].']</font>';}?>
			  </td>
			  <td align="center"><?php echo $row['goods_attr'];?></td>
			  <td align="center">￥<?php echo $row['goods_price'];?></td>
			  <td align="center"><?php echo $row['goods_number'].' '.$row['goods_unit'];?></td>
			  <td align="center">￥<?php echo $row['goods_price']*$row['goods_number']; if($row['from_jifen']>0) echo '&nbsp;&nbsp;<font color="red">[积分换取商品]</font>';?></td>
		   </tr>
		 <?php }?>
		<tr>
		  <td colspan="6">
		  购物金额小计(不计邮费) ￥<span class="totalprice" style="color:red"><?php echo $total;?> </span><?php if($jifen_total>0){?>&nbsp;&nbsp;支付积分：<span style="color:red"><?php echo $jifen_total;?></span><?php } ?>&nbsp;&nbsp;&nbsp;配运费：<span class="free_shopping" style="color:red">￥<?php echo $rt['orderinfo']['shipping_fee'];?></span>
		  </td>
		</tr>
		<tr>
			<td colspan="6"><b>备注：</b><?php echo $rt['orderinfo']['postscript'];?></td>
		</tr>
	<?php 
	}
	?>
</table>
<table width="350" border="0">
    <tr align="right"><!-- 订单操作员以及订单打印的日期 -->
        <td>打印时间：<?php echo date('Y-m-d H:i:s',mktime());?>&nbsp;&nbsp;&nbsp;操作者：<?php echo $this->Session->read('User.username');?></td>
    </tr>
</table>