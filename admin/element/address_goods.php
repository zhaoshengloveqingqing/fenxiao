<select name="province" id="select_province" onchange="ger_ress('2',this,'select_city')">
<option value="0">选择省</option>
<?php 
if(!empty($dbress['province'])){
foreach($dbress['province'] as $row){
?>
<option value="<?php echo $row['region_id'];?>" <?php echo $dbtype['province']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
<?php } } ?>													
</select>

<select name="city" id="select_city" onchange="ger_ress('3',this,'select_district')">
<option value="0">选择城市</option>
<?php
if(!empty($dbress['city'])){
foreach($dbress['city'] as $row){
?>
<option value="<?php echo $row['region_id'];?>" <?php echo $dbtype['city']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
<?php } } ?>	
</select>


<script type="text/javascript">
function ger_ress(type,obj,seobj){
	parent_id = $(obj).val();
	if(parent_id=="" || typeof(parent_id)=='undefined'){ return false; }
	$.post('user.php',{action:'get_ress',type:type,parent_id:parent_id},function(data){
		if(data!=""){
			$(obj).parent().find('#'+seobj).html(data);
			
			if(type==5){ //村
				
				$(obj).parent().find('#'+seobj).show();
				$(obj).parent().find('#select_peisong').hide();
			//	$(obj).parent().find('#select_peisong').show();
			//	$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
			//	$(obj).parent().find('#select_village').show();
				
			//	$(obj).parent().find('#'+seobj).show();
		//	  	$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
		//		$(obj).parent().find('#select_peisong').hide();
			}else if(type==4){ //城镇
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				$(obj).parent().find('#select_peisong').hide();
				$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
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
</script>