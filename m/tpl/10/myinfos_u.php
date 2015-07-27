<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/myinfos_u.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<form name="USERINFO" id="register" action="" method="post">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机号码:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="手机号码为登录帐号"  value="<?php echo isset($rt['userinfo']['mobile_phone'])&&!empty($rt['userinfo']['mobile_phone']) ? $rt['userinfo']['mobile_phone'] : "";?>" name="mobile_phone" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">密码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="6位密码并记录好" name="pass"  value="" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">QQ号码:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="QQ号码"  value="<?php echo isset($rt['userinfo']['qq'])&&!empty($rt['userinfo']['qq']) ? $rt['userinfo']['qq'] : "";?>" name="qq"  >
		</div>
		<input value="确认修改" type="button" id="submit"  onclick="return update_user_info(1);">
		<p>
			<span class="returnmes" style="color:#FF0000"></span>
		</p>
	</form>
</div>
<script type="text/javascript">
	$('input').each(function (index) {
		$(this).click(function(){
			$(this).parent().addClass('am-form');
		});
		$(this).blur(function(){
			$(this).parent().removeClass('am-form');
		});

	});
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
