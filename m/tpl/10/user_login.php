<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_login.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="login_main">
	<form id="login">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">账号:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="11位手机号码"  name="username" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">密码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="输入密码" name="password" >
		</div>
		<div class="other">
			<a class="registration" href="<?php echo ADMIN_URL;?>user.php?act=register">新用户注册</a>
		</div>
		<input value="提交" type="button" id="submit"  onclick="return submit_login_data()">
	</form>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
