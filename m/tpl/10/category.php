<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/category.css" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>

<div id="opquyubox">
	<div  style="height: 100%;">
		<h2 style="text-align: left;">商品分类</h2>
		<ul class="menu" style="overflow-y: scroll; text-align: left; display: block; height: 100%;">
			<?php if(!empty($lang['menu']))foreach($lang['menu'] as $row){?>
			<li>
				<a href="<?php echo ADMIN_URL.'catalog.php?cid='.$row['id'];?>">
					<?php echo $row['name'];?>
					<?php if(!empty($row['cat_id'])){?>
						<ul class="sub-menu">
							<?php foreach($row['cat_id'] as $rows){?>
								<li><a href="<?php echo ADMIN_URL.'catalog.php?cid='.$rows['id'];?>"><?php echo $rows['name'];?></a></li>
							<?php } ?>
						</ul>
					<?php } } ?>
				</a>
			</li>
		</ul>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>