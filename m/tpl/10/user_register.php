<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_register.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="register_main">
	<form id="register">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机帐号:</label>
			<input type="email" class="" id="doc-ipt-email-1" placeholder="11位手机号码">
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">用户密码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="输入密码">
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">确认密码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="再次输入密码">
		</div>
		<input value="同意协议并注册" type="button" id="submit" />
	</form>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>

