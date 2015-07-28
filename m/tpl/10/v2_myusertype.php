<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="user_details">
		<div class="sub-menu clearfix gg1" style="display:inline;">
			<ul>
				<?php if($rt['zcount']>0){?>
					<!--<li>
					<a href="<?php echo ADMIN_URL.'daili.php?act=myuser';?>"><i></i>我的全部下级<span><?php echo empty($rt['zcount']) ? '0' : $rt['zcount'];?>人</span></a>
					</li>-->
				<?php } ?>
				<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=1';?>">一级会员<span><?php echo empty($rt['zcount1']) ? '0' : $rt['zcount1'];?>人</span></a></li>
				<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=2';?>">二级会员<span><?php echo empty($rt['zcount2']) ? '0' : $rt['zcount2'];?>人</span></a></li>
				<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=3';?>">三级会员<span><?php echo empty($rt['zcount3']) ? '0' : $rt['zcount3'];?>人</span></a></li>
			</ul>
		</div>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
