<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/myinfos_u.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<form id="register">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">开户银行:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="开户银行"  name="username" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">真实姓名:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="开户人姓名" name="password" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">银行卡号:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="银行卡号" name="password" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机号码:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="11位手机号码" name="password" >
		</div>
		<input value="提交" type="button" id="submit"  onclick="return submit_login_data()">
	</form>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>