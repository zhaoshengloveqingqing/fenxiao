<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/catalog_index.css" media="all" />
<div id="catalog_main">
	<form id="search"  method="get" action="<?php echo ADMIN_URL;?>catalog.php">
		<input type="text" placeholder="输入商品关键字"  name="keyword" id="title" value="<?php echo !empty($keyword)&&!in_array($keyword,array('is_promote','is_qianggou','is_hot','is_best','is_new')) ? $keyword : "输入商品关键字";?>"  onfocus="if(this.value=='输入商品关键字'){this.value='';}" onblur="if(this.value==''){this.value='输入商品关键字';}"/>
		<input type="submit" value="submit" class="submit"/>
	</form>
	<div class="catalog_list">
		<ul class="catalog">
			<?php $imgs = array(); if(!empty($rt['categoodslist']))foreach($rt['categoodslist'] as $k=>$row){ $imgs[] = $row['goods_img'];?>
			<li>
				<a href="<?php echo ADMIN_URL.($row['is_jifen']=='1'?'exchange':'product').'.php?id='.$row['goods_id'];?>">
					<img src="<?php echo $row['goods_img'];?>"  alt="<?php echo $row['goods_name'];?>"/>
					<h3><?php echo $row['goods_name'];?></h3>
				</a>
				<p><span class="price"><?php echo str_replace('.00','',$row['pifa_price']);?>元<i class="discount_price">￥<?php echo str_replace('.00','',$row['shop_price']);?>元</i></span></p>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div class="clear10"></div>
			<?php if(!empty($rt['categoodspage'])){?>
			<div class="pages">
				<?php echo str_replace('上一页','<img src="'.ADMIN_URL.'images/prev.jpg" align="absmiddle" />',$rt['categoodspage']['previ']);?>
				<?php 
				if(!empty($rt['categoodspage']['list']))foreach($rt['categoodspage']['list'] as $kk=>$v){
					?>
					<a href="<?php echo $v;?>" class="<?php echo $kk==$page?'ll this' : 'll';?>"><?php echo $kk;?></a>
					<?php
				}
				?>	
				<?php echo str_replace('下一页','<img src="'.ADMIN_URL.'images/next.jpg" align="absmiddle" />',$rt['categoodspage']['next']);?>
			</div>
			<div class="clear"></div>
			<?php } ?>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
<?php
$title = !empty($rt['cateinfo']['cat_title']) ? $rt['cateinfo']['cat_title'] : $rt['cateinfo']['cat_name'];
$imgs = $imgs[rand(0,count($imgs)-1)];
?>
<?php
 $thisurl = Import::basic()->thisurl();
 $rr = explode('?',$thisurl);
 $t2 = isset($rr[1])&&!empty($rr[1]) ? $rr[1] : "";
 $dd = array();
 if(!empty($t2)){
 	$rr2 = explode('&',$t2);
	if(!empty($rr2))foreach($rr2 as $v){
		$rr2 = explode('=',$v);
		if($rr2[0]=='from' || $rr2[0]=='isappinstalled'|| $rr2[0]=='code'|| $rr2[0]=='state') continue;
		$dd[] = $v;
	}
 }
 $thisurl = $rr[0].'?'.(!empty($dd) ? implode('&',$dd) : 'tid=0');
?>
<?php 
	$imgurl =   $imgs;
	$params = array(
		'title' => $title,
		'action' => 'ajax_share',
		'thisurl' => $thisurl,
		'imgurl' => $imgurl
	);
	$wxshare = array(
		'title' => $title,
		'imgUrl' =>  $imgurl,
		'desc' =>  !empty($rt['cateinfo']['cat_desc']) ? $rt['cateinfo']['cat_desc'] : $title,
		'link' => $thisurl,
		'is_record' => 1,
		'ajax_url' => ADMIN_URL.'product.php',
		'ajax_params' => $params,
	);
   $this->element('10/wxshare',array('lang' =>  array_merge($lang, $wxshare) )); 
 ?>