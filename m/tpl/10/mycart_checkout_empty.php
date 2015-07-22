<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/checkout_empty.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="ctop">
		<img src="<?php echo ADMIN_URL;?>tpl/10/images/gouwuche_icon.png"/>
	</div>
	<p>购物车还空着</p>
	<p>去选几件中意的商品吧</p>
	<p class="action">
		<a class="button" href="<?php echo ADMIN_URL;?>">去逛逛</a>
	</p>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>





