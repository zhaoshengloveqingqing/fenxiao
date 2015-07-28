
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main" style="min-height:300px">
	<div style="margin:10%; margin-bottom:0px; background:#FFF; padding:10%; text-align:center">
		<img src="<?php echo $qcodeimg;?>" style=" width:100%;max-width:100%; cursor:pointer" />
	</div>
	<div style="margin:10%; margin-top:0px; text-align:center; font-size:14px; font-weight:bold; margin-bottom:15px;">
	快来扫一扫，抢占合伙人地盘！
	</div>
	<div style="margin:10%; margin-top:0px;height:45px; line-height:45px; font-size:14px; font-weight:bold; color:#FFF;margin-bottom:5px; line-height:22px">
<div style='text-align: center'>
	<span style=" display:block; color:red;">我的推广链接</span>
	<p class="copyurl" style="width:100%; color:red; background:#FAFAFA; border:none; overflow:hidden" onclick="clickselect()"><?php echo $thisurl;?></p>
</div>
	</div>
	<!-- <a href="<?php echo ADMIN_URL;?>user.php?act=ajax_down_img" class="addcar" style=" width:90px; background:#4f82b4; position:fixed; left:5px; bottom:55px;height:24px; line-height:24px; color:#FFF">下载二维码</a> -->
</div>
<div style="height:40px; clear:both"></div>
<script type="text/javascript">
function clickselect(obj){
	$(obj).select();
}
</script>

<?php $this->element('10/footer',array('lang'=>$lang)); ?>
