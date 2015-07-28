<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="user_details">
		<div class="sub-menu clearfix">
					<ul>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=mymoneydata&status=weifu';?>">未付款订单<span><?php echo !empty($rt['pay1']) ? $rt['pay1'] : '0.00';?>元</span></a></li>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=mymoneydata&status=yifu';?>">已付款订单<span><?php echo !empty($rt['pay2']) ? $rt['pay2'] : '0.00';?>元</span></a></li>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=mymoneydata&status=shouhuo';?>">已收货订单<span><?php echo !empty($rt['pay3']) ? $rt['pay3'] : '0.00';?>元</span></a></li>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=mymoneydata&status=quxiao';?>">已取消作废<span><?php echo !empty($rt['pay4']) ? $rt['pay4'] : '0.00';?>元</span></a></li>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=mymoneydata&status=tongguo';?>">审核通过的<span><?php echo !empty($rt['pay5']) ? $rt['pay5'] : '0.00';?>元</span></a></li>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=postmoney';?>">申请提款</a></li>
						<li><a href="<?php echo ADMIN_URL.'daili.php?act=postmoneydata';?>">提款记录</a></li>
				</ul>		
		</div>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
