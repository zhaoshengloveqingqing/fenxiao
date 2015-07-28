<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/daillicenter.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div class="main">
	<div class="user_details">
		<ul>
			<li class="plute">
				<a  href="<?php echo ADMIN_URL.'daili.php?act=moneyrank';?>" >富豪榜<i></i></a>
			</li>
			<li class="member">
				<a href="<?php echo ADMIN_URL.'daili.php?act=myusertype';?>">我的团队<i></i></a>
			</li>
			<li class="spread">
				<a href="<?php echo ADMIN_URL.'daili.php?act=mydata';?>">我的推广<i></i></a>
			</li>
			<li class="commision">
				<a href="<?php echo ADMIN_URL.'daili.php?act=v2_mymoney';?>">我的佣金<i></i></a>
			</li>

			<li class="refund">
				<a href="<?php echo ADMIN_URL.'daili.php?act=postmoney';?>">申请退款<i></i></a>
			</li>
			<li class="drawings">
				<a href="<?php echo ADMIN_URL.'daili.php?act=postmoneydata';?>">提款记录<i></i></a>
			</li>
		</ul>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
