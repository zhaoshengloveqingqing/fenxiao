<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/myinfos_u.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<form id="register">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机号码:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="手机号码为登录帐号"  name="username" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">密码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="6位密码并记录好" name="password" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">QQ号码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="QQ号码" name="password" >
		</div>
		<input value="确认修改" type="button" id="submit"  onclick="return submit_login_data()">
	</form>
</div>
<script type="text/javascript">
	$('input').click(function(){
		alert(1);
		$(this).parent().addClass('border-bottom','1px solid #ff0000');
	})
//	function ajax_show_sub(k,obj){
//		$(".gg"+k).toggle();
//		ll = $(".gg"+k).css('display');
//		/*if(ll=='none'){
//		 $(obj).find('i').css('background','url(<?php //echo $this->img('+h.png');?>//) 10% center no-repeat');
//		 }else{
//		 $(obj).find('i').css('background','url(<?php //echo $this->img('-h.png');?>//) 10% center no-repeat');
//		 }*/
//	}
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
