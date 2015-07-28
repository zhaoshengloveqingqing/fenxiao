<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_login.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/postmoney.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<form id="login">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">银行卡:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="银行卡"  name="username" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机号:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="11位手机号码" name="password" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">户名:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="银行卡"  name="username" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">你的余额:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="11位手机号码" name="password" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">提款资金:</label>
			<input type="password" class="" id="doc-ipt-email-1" placeholder="提款金额" name="password" >
		</div>
		<div class="action">
			<input value="确认提交" type="button" id="submit">
			<input value="修改提款信息" type="button" id="submit" class="info">
		</div>
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