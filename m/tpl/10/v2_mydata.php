<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="user_details">
		<div class="sub-menu clearfix">
			<ul>
				<li><a href="<?php echo ADMIN_URL.'user.php?act=myshare';?>">点击链接<span><?php echo empty($rt['userinfo']['share_ucount']) ? '0' : $rt['userinfo']['share_ucount'];?>人</span></a></li>
				<li><a href="<?php echo ADMIN_URL.'user.php?act=myuser';?>">成功关注<span><?php echo empty($rt['userinfo']['guanzhu_ucount']) ? '0' : $rt['userinfo']['guanzhu_ucount'];?>人</span></a></li>
				<li><a href="javascript:void(0)">下单购买<span><?php echo empty($rt['userinfo']['ordercount']) ? '0' : $rt['userinfo']['ordercount'];?>单</span></a></li>
				<li><a href="<?php echo ADMIN_URL.'daili.php?act=my_is_daili';?>">成为分销<span><?php echo empty($rt['userinfo']['fxcount']) ? '0' : $rt['userinfo']['fxcount'];?>人</span></a></li>
				<li><a href="<?php echo ADMIN_URL.'user.php?act=myerweima';?>">我的二维码</a></li>
			</ul>
		</div>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>

