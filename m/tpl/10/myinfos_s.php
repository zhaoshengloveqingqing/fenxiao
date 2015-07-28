<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/myinfos_s.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>

<div id="main" style=" min-height:300px">
	<?php if(!empty($rt['userress'])){
	foreach($rt['userress'] as $row){
	?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #d1d1d1;padding:10px; margin:0px; line-height:24px; background-color:#fafafa;">
			<tr>
				<td >收货人：<?php echo $row['consignee'];?></td>
			</tr>
			<tr>
				<td>收货地址：<?php echo $row['provinces'].$row['citys'].$row['districts'].$row['address'];?></td>
			</tr>
			<tr>
				<td>电话：<?php echo $row['mobile'];?></td>
			</tr>
			<tr>
				<td>
					<!-- <a href="<?php echo ADMIN_URL.'user.php?act=myinfos_s&id='.$row['address_id'];?>">--><img src="<?php echo SITE_URL.'theme/images/btu_up.gif';?>" height="26" width="66" border="0" onclick="ressinfoop('<?php echo $row['address_id'];?>','showupdate',this)" style="cursor:pointer"/></a>&nbsp;
					<img src="<?php echo SITE_URL.'theme/images/btu_dell.gif';?>" height="26" width="66" border="0" onclick="ressinfoop('<?php echo $row['address_id'];?>','delete',this)" style="cursor:pointer"/>&nbsp;
					<?php if($row['is_default']=='1'){?>
					<img class="set_quxiao_icon" src="<?php echo ADMIN_URL.'images/quxiaodefaultress.png';?>" height="26" border="0" onclick="ressinfoop('<?php echo $row['address_id'];?>','quxiao',this)" style="cursor:pointer"/>&nbsp;
					<?php }else{?>
					<img class="set_quxiao_icon" src="<?php echo ADMIN_URL.'images/setdefaultress.png';?>" height="26" border="0" onclick="ressinfoop('<?php echo $row['address_id'];?>','setdefaut',this)" style="cursor:pointer"/>&nbsp;
					<?php } ?>
				</td>
			</tr>
		</table>
	<?php } }  ?>
	<div class="myaddress">
		<form  action="<?php echo ADMIN_URL;?>mycart.php?type=confirm" method="post" name="CONSIGNEE_ADDRESS" id="CONSIGNEE_ADDRESS">
			<div class="edit userreddinfo">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名：</label>
					<div class="am-u-sm-10">
						<input type="text" id="doc-ipt-3" placeholder="输入你的姓名"  value="" name="consignee"  >
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
				<p class="action"><input value="提交" type="button" id="submit"  onclick="ressinfoop('0','add','CONSIGNEE_ADDRESS');">
			</div>
		</form>
	</div>

<script type="text/javascript">
function ger_ress_copy(type,obj,seobj){
	parent_id = $(obj).val();
	if(parent_id=="" || typeof(parent_id)=='undefined'){ return false; }
	$.post(SITE_URL+'user.php',{action:'get_ress',type:type,parent_id:parent_id},function(data){
		if(data!=""){
			$(obj).parent().find('#'+seobj).html(data);
			if(type==3){
				$(obj).parent().find('#'+seobj).show();
			}
			if(type==2){
				$(obj).parent().find('#select_district').hide();
				$(obj).parent().find('#select_district').html("");
			}
		}else{
			//alert(data);
			$(obj).parent().find('#select_district').hide();
			$(obj).parent().find('#'+seobj).html('');
		}
	});
}

</script>

</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>