<select name="province" id="select_province" onchange="ger_ress('2',this,'select_city')" class="pw">
<option value="0">选择省</option>
<?php 
if(!empty($resslist)){
foreach($resslist as $row){
?>
<option value="<?php echo $row['region_id'];?>" <?php echo $dbtype['province']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
<?php } } ?>													
</select>

<select name="city" id="select_city" onchange="ger_ress('3',this,'select_district')" class="pw">
<option value="0">选择城市</option>
<?php
if(!empty($dbress['city'])){
foreach($dbress['city'] as $row){
?>
<option value="<?php echo $row['region_id'];?>" <?php echo $dbtype['city']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
<?php } } ?>	
</select>

<select <?php echo !isset($dbtype['district'])? 'style="display: none;"':"";?> name="district" id="select_district" class="pw">
<option value="0">选择区</option>	
<?php 
if(!empty($dbress['district'])){
foreach($dbress['district'] as $row){
?>
<option value="<?php echo $row['region_id'];?>" <?php echo $dbtype['district']==$row['region_id']? 'selected="selected"' :"";?>><?php echo $row['region_name'];?></option>	
<?php } } ?>													
</select>
</span>

<script type="text/javascript">
function ger_ress(type,obj,seobj){
	parent_id = $(obj).val();
	if(parent_id=="" || typeof(parent_id)=='undefined'){ return false; }
	$.post(SITE_URL+'user.php',{action:'get_ress',type:type,parent_id:parent_id},function(data){
		if(data!=""){
			$(obj).parent().find('#'+seobj).html(data);
			
			if(type==5){ //村
				
				$(obj).parent().find('#'+seobj).show();
				$(obj).parent().find('#select_peisong').hide();

			}else if(type==4){ //城镇
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				$(obj).parent().find('#select_peisong').hide();
				$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
				$(obj).parent().find('#select_town').show();

			}else if(type==3){ //区
				$(obj).parent().find('#select_peisong').hide();
				$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
				
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				
				$(obj).parent().find('#select_town').hide();
				$(obj).parent().find('#select_town').html('<option value="0" >选择城镇</option>');
				
				$(obj).parent().find('#select_district').show();
				
			}else if(type==2){ //市
				$(obj).parent().find('#select_peisong').hide();
				$(obj).parent().find('#select_peisong').html('<option value="0" >选择配送店</option>');
				
				$(obj).parent().find('#select_village').hide();
				$(obj).parent().find('#select_village').html('<option value="0" >选择村</option>');
				
				$(obj).parent().find('#select_town').hide();
				$(obj).parent().find('#select_town').html('<option value="0" >选择城镇</option>');
				
				$(obj).parent().find('#select_district').hide();
				$(obj).parent().find('#select_district').html('<option value="0" >选择区</option>');
			}

		}else{
			//alert(data);
			$(obj).parent().find('#select_district').hide();
			$(obj).parent().find('#'+seobj).html('');
		}
	});
}
//获取配送店

function get_peisong(obj,seobj){
//	village_id = $(obj).val();
	village_id = $(obj).parent().find('select[name="village"]').val();
	town_id = $(obj).parent().find('select[name="town"]').val();
	district_id = $(obj).parent().find('select[name="district"]').val();

	if(village_id=="" || typeof(village_id)=='undefined'){ return false; }
	$.post(SITE_URL+'user.php',{action:'get_peisong',village_id:village_id,town_id:town_id,district_id:district_id,type:'ajax'},function(data){
		if(data!=""){ 
			$(obj).parent().find('#'+seobj).html(data);
			
			$(obj).parent().find('#'+seobj).show();
			
		}else{
			$(obj).parent().find('#'+seobj).html('<option value="0" >此处暂无配送店</option>');
			
			$(obj).parent().find('#'+seobj).show();
		}
	});
}
</script>