<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/postmoney.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_login.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<form id="login">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">银行卡:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="银行卡"  value="<?php echo isset($rts['banksn']) ? $rts['banksn'] : '';?>" name="banksn" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机号:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="11位手机号码"  value="<?php echo isset($rts['bankaddress']) ? $rts['bankaddress'] : '';?>" name="bankaddress">
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">户名:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="户名"   value="<?php echo isset($rts['uname']) ? $rts['uname'] : '';?>" name="uname"  >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">你的余额:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="11位手机号码" value="<?php echo isset($mymoney) ? $mymoney : '0.00';?>元" name="banksn"  >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">提款资金:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="提款金额"  value="" name="postmoney" >
		</div>
		<div class="action">
			<input value="确认提交" type="button" id="submit" onclick="return ajax_postmoney();">
			<input value="修改提款信息" type="button" id="submit" class="info"  onclick="modify_postmoney();">
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

	function ajax_postmoney(){
		//passs = $('input[name="pass"]').val();
		money = $('input[name="postmoney"]').val();
		if(parseInt(<?php echo isset($mymoney) ? $mymoney : '0';?>) < 50){
			alert('暂时不能为你服务，先赚取50以上佣金再来吧！');
			return false;
		}
		if(money=="" ){
			alert('请输入提款金额');
			return false;
		}

		if(confirm('确认信息无误提款吗')){
			createwindow();
			$.post('<?php echo ADMIN_URL;?>daili.php',{action:'ajax_postmoney',money:money,id:'<?php echo $rts['id'];?>'},function(data){ 
				$('.returnmes2').html(data);
				removewindow();
			});
		}
		return false;
	}

	function modify_postmoney(){
		location.href = "<?php echo ADMIN_URL.'user.php?act=myinfos_b';?>";
	}
	
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>