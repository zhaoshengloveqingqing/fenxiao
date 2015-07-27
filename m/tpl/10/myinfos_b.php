<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/myinfos_u.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/myinfos_b.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<form name="USERINFO2" id="USERINFO2"  method="post">
		<div class="am-form-group">
			<label for="doc-ipt-email-1">开户银行:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="开户银行"  value="<?php echo isset($rts['bankname']) ? $rts['bankname'] : '';?>" name="bankname"  >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">真实姓名:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="开户人姓名" value="<?php echo isset($rts['uname']) ? $rts['uname'] : '';?>" name="uname" >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">银行卡号:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="银行卡号"   value="<?php echo isset($rts['banksn']) ? $rts['banksn'] : '';?>" name="banksn"  >
		</div>
		<div class="am-form-group">
			<label for="doc-ipt-email-1">手机号码:</label>
			<input type="text" class="" id="doc-ipt-email-1" placeholder="11位手机号码"   value="<?php echo isset($rts['bankaddress']) ? $rts['bankaddress'] : '';?>" name="bankaddress"  >
		</div>
		<input value="提交" type="button" id="submit"  onclick="return update_user_bank()">
	</form>
</div>
<script type="text/javascript">
	function update_user_bank(){
		//passs = $('input[name="ppass"]').val();
		banknames = $('input[name="bankname"]').val();
		bankaddresss = $('input[name="bankaddress"]').val();
		unames = $('input[name="uname"]').val();
		banksns = $('input[name="banksn"]').val();
	
		if( banknames=="" || unames=="" || banksns==""){
			$('.returnmes2').html('请输入完整信息');
			return false;
		}
	
		if(confirm('确认修改吗')){
			createwindow();
			
			$.post('<?php echo ADMIN_URL;?>daili.php',{action:'update_user_bank',bankname:banknames,bankaddress:bankaddresss,uname:unames,banksn:banksns},function(data){ 
				$('.returnmes2').html(data);
				window.location.href = '/m/daili.php?act=postmoney';
				removewindow();
			});
		}
		return false;
	}
	
	function update_user_pass2(){
		passs = $('input[name="pass"]').val();
		newpasss = $('input[name="newpass"]').val();
		rpnewpasss = $('input[name="rpnewpass"]').val();
		if(passs=="" || newpasss=="" || newpasss==""){
			$('.returnmes').html('请输入完整信息');
			return false;
		}
		if(newpasss!=rpnewpasss){
			$('.returnmes').html('密码与确认密码不一致');
			return false;
		}
		if(confirm('确认修改吗')){
			createwindow();
			
			$.post('<?php echo ADMIN_URL;?>daili.php',{action:'update_user_pass',pass:passs,newpass:newpasss,rpnewpass:rpnewpasss},function(data){ 
				$('.returnmes').html(data);
				removewindow();
			});
		}
		return false;
	}
	function ajax_open_dailiapply(tt){
		if(tt==true){
			ty = '1';
		}else{
			ty = '2';
		}
		$.post('<?php echo ADMIN_URL;?>daili.php',{action:'ajax_open_dailiapply',ty:ty},function(data){ 
			
		});
	}

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