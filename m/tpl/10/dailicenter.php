<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/daillicenter.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<div class="user_details">
		<ul>
			<li class="plute">
				<a  href="javascript:;" onclick="ajax_show_sub(1,this);">富豪榜<i></i></a>
			</li>
			<li class="member">
				<a href="javascript:;" onclick="ajax_show_sub(4,this);">我的团队<i></i></a>
			</li>
			<li class="spread">
				<a href="javascript:;" onclick="ajax_show_sub(2,this);">我的推广<i></i></a>
			</li>
			<li class="commision">
				<a href="javascript:;" onclick="ajax_show_sub(3,this);">我的佣金<i></i></a>
			</li>

			<li class="refund">
				<a href="<?php echo ADMIN_URL;?>user.php?act=orderlist">申请退款<i></i></a>
			</li>
			<li class="drawings">
				<a href="<?php echo ADMIN_URL;?>user.php?act=mycoll">提款记录<i></i></a>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	function ajax_show_sub(k,obj){
		$(".gg"+k).toggle();
		ll = $(".gg"+k).css('display');
		/*if(ll=='none'){
		 $(obj).find('i').css('background','url(<?php echo $this->img('+h.png');?>) 10% center no-repeat');
		 }else{
		 $(obj).find('i').css('background','url(<?php echo $this->img('-h.png');?>) 10% center no-repeat');
		 }*/
	}
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
