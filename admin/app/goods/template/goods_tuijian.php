<?php
$thisurl = ADMIN_URL.'goods.php'; 
?>
<style>.vieworder{ width:55px; height:25px; display:block; cursor:pointer}</style>
<div class="contentbox">
     <table cellspacing="2" cellpadding="5" width="100%">
	 <tr>
		<th colspan="5" align="left"><span style="float:left">推荐列表</span><a href="goods.php?type=goods_tuijian_info" style="float:right">添加推荐</a></th>
	</tr>
    <tr>
	   <th>商品图</th>
	   <th>标题</th>
	   <th>市场价</th>
	    <th>折扣价</th>
	   <th>操作</th>
	</tr>
	<?php
	if(!empty($rt)){ 
	foreach($rt as $row){
	?>
	<tr>
	<td><a target="_blank" href="<?php echo $row['url'];?>"><img src="<?php echo !empty($row['goods_thumb']) ? 	dirname(ADMIN_URL).'/'.$row['goods_thumb'] : $this->img('no_picture.gif');?>" width="60"/></a></td>
	<td><?php echo $row['goods_name'];?></td>
	<td><?php echo $row['shop_price'];?></td>
	<td><?php echo $row['pifa_price'];?></td>
	<td>
	<a href="goods.php?type=goods_tuijian_info&id=<?php echo $row['id'];?>" title="编辑"><img src="<?php echo $this->img('icon_edit.gif');?>" title="编辑"/></a>&nbsp;
	<img src="<?php echo $this->img('icon_drop.gif');?>" title="删除" alt="删除" id="<?php echo $row['id'];?>" class="delgoodsid"/>
	</td>
	</tr>
	<?php
	 } ?>
		<?php } ?>
	 </table>
	 <?php $this->element('page',array('pagelink'=>$pagelink));?>
</div>
<?php  $thisurl = ADMIN_URL.'goods.php'; ?>
<script type="text/javascript">
	$('.delgoodsid').click(function (){
		ids = $(this).attr('id');
		thisobj = $(this).parent().parent();
		if(confirm("确定加入删除吗？")){
			createwindow();
			$.post('<?php echo $thisurl;?>',{action:'goods_tuijian_del',ids:ids},function(data){
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
	});
</script>