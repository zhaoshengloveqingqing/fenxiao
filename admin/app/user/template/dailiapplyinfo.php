<style type="text/css">
.gototype a{ padding:2px; border-bottom:2px solid #ccc; border-right:2px solid #ccc;}
</style>
<div class="contentbox">
<form id="form1" name="form1" method="post" action="">
     <table cellspacing="2" cellpadding="5" width="100%">
	 	<tr>
			<td class="label">手机号码：</td>
			<td>
			<input name="mobile_phone" value="<?php echo isset($rt['userinfo']['mobile_phone']) ? $rt['userinfo']['mobile_phone'] : '';?>" size="40" type="text" />
			</td>
		</tr>

	 	<tr>
			<td class="label">登录密码：</td>
			<td>
			<input name="password" value="" size="42" type="text" />
			</td>
		</tr>
		<tr>
			<td class="label">确认密码：</td>
			<td>
			<input id="confirm_pass" value="" size="42" type="text" />
			</td>
		</tr>
		<tr style=" display:none">
			<td class="label">类别：</td>
			<td>
			  <label>
              <input type="radio" name="types" value="1" <?php if(isset($rt['userinfo']['types'])&&$rt['userinfo']['types']==1){ echo 'checked="checked"';}?>/>全职
              </label>		
			  <label>
              <input type="radio" name="types" value="2" <?php if(isset($rt['userinfo']['types'])&&$rt['userinfo']['types']==2){ echo 'checked="checked"';}?>/>兼职
              </label>
			  </td>
		</tr>
		<tr>
			<td class="label" width="15%">级别：</td>
			<td>
				<select name="user_rank">
				<?php 
				if(!empty($rt['userinfo']['user_jibie'])){
				foreach($rt['userinfo']['user_jibie'] as $row){
				if($row['lid']=='1') continue;
				?>
				  <option value="<?php echo $row['lid'];?>" <?php echo isset($rt['userinfo']['user_rank'])&&$row['lid']==$rt['userinfo']['user_rank'] ? 'selected="selected"' : "";?>><?php echo $row['level_name'];?></option>
				  <?php }}?>
			    </select>
		</td>
		</tr>
		<tr>
			<td class="label" width="15%">昵称：</td>
			<td>
			<input name="nickname" value="<?php echo isset($rt['userinfo']['nickname']) ? $rt['userinfo']['nickname'] : '';?>" size="40" type="text" />&nbsp;(微信公众号名称)
			</td>
		</tr>
		<tr>
			<td class="label">微信号：</td>
			<td>
			<input name="msn" value="<?php echo isset($rt['userinfo']['msn']) ? $rt['userinfo']['msn'] : '';?>" size="40" type="text" />
			</td>
		</tr>
		<tr>
			<td class="label">电子邮箱：</td>
			<td>
			<input name="email" value="<?php echo isset($rt['userinfo']['email']) ? $rt['userinfo']['email'] : '';?>" size="40" type="text" />
			</td>
		</tr>
		<tr>
			<td class="label">地区：</td>
			<td>
		<select name="province" id="select_province" onchange="ger_ress_copy('2',this,'select_city')">
			<option value="0">选择省</option>
			<?php 
			if(!empty($rt['province'])){
			foreach($rt['province'] as $row){
			?>
			
			<option value="<?php echo $row['region_id'];?>" <?php echo $rt['userress']['province']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
			<?php } } ?>													
		</select>
			
		<select name="city" id="select_city" onchange="ger_ress_copy('3',this,'select_district')">
			<option value="0">选择城市</option>
			<?php
			if(!empty($rt['city'])){
			foreach($rt['city'] as $row){
			?>
			<option value="<?php echo $row['region_id'];?>" <?php echo $rt['userress']['city']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
			<?php } } ?>	
		</select>
			
		<select <?php echo !isset($rt['userress']['district'])? 'style="display: none;"':"";?> name="district" id="select_district" onchange="ger_ress_copy('4',this,'select_town')">
			<option value="0">选择社区/县</option>	
				
			<?php 
			if(!empty($rt['district'])){
			foreach($rt['district'] as $row){
			?>
			<option value="<?php echo $row['region_id'];?>" <?php echo $rt['userress']['district']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
			<?php } } ?>													
		</select>
			 </td>
		</tr>
		<tr>
			<td class="label">详细地址：</td>
			<td>
			<input name="address" value="<?php echo isset($rt['userress']['address'])&&!empty($rt['userress']['address']) ? $rt['userress']['address'] : "";?>" size="40" type="text" />
			 </td>
		</tr>
		<tr>
			<td class="label">姓名：</td>
			<td>
			<input name="consignee" value="<?php echo isset($rt['userress']['consignee']) ? $rt['userress']['consignee'] : '';?>" size="40" type="text" />
			</td>
		</tr>
		<tr>
		<td class="label">身份证:</td>
		<td>
		  <input name="avatar" id="sfz" type="hidden" value="<?php echo isset($rt['userinfo']['avatar']) ? $rt['userinfo']['avatar'] : '';?>" size="43"/>
		  <iframe id="iframe_t" name="iframe_t" border="0" src="upload.php?action=<?php echo isset($rt['userinfo']['avatar'])&&!empty($rt['userinfo']['avatar'])? 'show' : '';?>&ty=sfz&files=<?php echo isset($rt['userinfo']['avatar']) ? $rt['userinfo']['avatar'] : '';?>" scrolling="no" width="445" frameborder="0" height="25"></iframe>
		</td>
	  </tr>
	  <tr>
			<td>&nbsp;</td>
			<td><label>
			  <?php if($rt['userinfo']['user_rank']!='1'&&$rt['userinfo']['is_salesmen']=='2'){?>
			  <input type="submit" value="已申请(修改)" class="submit" style="cursor:pointer; padding:2px 4px 2px 4px; margin-right:10px;"/>
			  <input type="button" value="取消代理" onclick="ajax_quxiao_daili('<?php echo $rt['userinfo']['user_id'];?>',this);" style="cursor:pointer; padding:2px 4px 2px 4px"/>
			  <?php }else{?>
			  <input type="button" value="开通代理" style="cursor:pointer; padding:2px 4px 2px 4px" onclick="return ajax_kaitong_daili('<?php echo $rt['userinfo']['user_id'];?>',this);"/>
			  <?php } ?>
			</label></td>
		</tr>
	 </table>
</form>
</div>
<script language="javascript">
function ajax_kaitong_daili(uid,obj){
	if(confirm('确定开通吗')){
		$(obj).val('正在开通，请耐心等待...');
		$.post('user.php',{action:'ajax_kaitong_daili',uid:uid},function(data){
			$(obj).val('正在开通下一步');
			if(data=="1"){
				$('#form1').submit();
			}else{
				alert("意外错误，请从新提交");
			}
		});
	}
	return false;
}

function ajax_quxiao_daili(uid,obj){
	$.post('user.php',{action:'ajax_quxiao_daili',uid:uid},function(data){
		$(obj).val('已经取消代理权限');
		$('.submit').hide();
	});
}

$('.submit').click(function(){

	
	return true;
});



function ger_ress_copy(type,obj,seobj){
	parent_id = $(obj).val();
	if(parent_id=="" || typeof(parent_id)=='undefined'){ return false; }
	$.post('user.php',{action:'get_ress',type:type,parent_id:parent_id},function(data){
		if(data!=""){
			$(obj).parent().find('#'+seobj).html(data);
			
			if(type==5){ //村
				$(obj).parent().find('#'+seobj).show();
				$(obj).parent().find('#select_peisong').hide();
			}else if(type==4){ //城镇
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				$(obj).parent().find('#select_peisong').hide();
				
				$(obj).parent().find('#select_town').show();
				//$(obj).parent().find('#select_town').html("");
			}else if(type==3){ //区
				$(obj).parent().find('#select_peisong').hide();
				$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
				
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				
				$(obj).parent().find('#select_town').hide();
				$(obj).parent().find('#select_town').html('<option value="0" >选择城镇</option>');
				
				$(obj).parent().find('#select_district').show();
				//$(obj).parent().find('#select_district').html("");
				
			}else if(type==2){ //市
				$(obj).parent().find('#select_peisong').hide();
				$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
				
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				
				$(obj).parent().find('#select_town').hide();
				$(obj).parent().find('#select_town').html('<option value="0" >选择城镇</option>');
				
				$(obj).parent().find('#select_district').hide();
				$(obj).parent().find('#select_district').html('<option value="0" >选择区</option>');
				
				//$(obj).parent().find('#select_city').hide();
				//$(obj).parent().find('#select_city').html("");
			}

		}else{
			alert(data);
		}
	});
}




function change_user_points_money(uid,thisobj,type){
	val = $(thisobj).val();
	if(val>0 || val<0){
		if(confirm("你确定执行该操作吗？")){
			createwindow();
			$.post('user.php',{action:'change_user_points_money',uid:uid,type:type,val:val},function(data){
				if(typeof(data)!='undefined' && data!=""){
					removewindow();
					if(parseInt(data)>0){
						if(type=='money'){
							$(thisobj).parent().find('.thismoney').html(data);
						}else if(type =='points'){
							$(thisobj).parent().find('.thispoints').html(data);
						}
					}
					alert("操作成功！");
				}else{
					alert("操作失败！");
				}
			});
		}
	}
	return false;
}

  function get_userpoint_page_list(page,uid){
  		createwindow();
		$.post('user.php',{action:'pointinfo',page:page,uid:uid},function(data){
			removewindow();
			if(data !="" && typeof(data)!='undefined'){
				$('.user_point').html(data);
			}
		});
  }
  
  function get_usermoney_page_list(page,uid){
  		createwindow();
		$.post('user.php',{action:'mymoney',page:page,uid:uid},function(data){
			removewindow();
			if(data !="" && typeof(data)!='undefined'){
				$('.user_money').html(data);
			}
		});
}
</script>
