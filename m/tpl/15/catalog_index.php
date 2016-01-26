<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/15/css.css" media="all" />
<?php $this->element('15/top',array('lang'=>$lang)); ?>
<?php $this->element('guanzhu',array('shareinfo'=>$lang['shareinfo']));?>
<div id="main">
<style type="text/css">
.search_index {
margin: 5px 0px 3px 5px;
height: 46px;
border-radius: 2px;
background: url(<?php echo $this->img('input_bg.png');?>) repeat-x top left;
}
.search_index .right {
width: 44px;
float: right;
text-align: left;
}
.search_index .left {
text-align: center; height:46px;
}
.search_index .input1 {
height: 46px;
line-height: 46px;
text-indent: 5px;
color: #787575;
border: none;
background: url(<?php echo $this->img('611.png');?>) no-repeat center left;
display: block;
float: left;
width: 75%;
}
.goodslists{ min-height:300px;}
</style>
<form id="form1" name="form1" method="get" action="<?php echo ADMIN_URL;?>catalog.php">
  <div class="search_index">
   <div class="right"><input type="image" src="<?php echo $this->img('submit4.png');?>" value="" style="height:25px;margin-top:10px; margin-right:10px"></div>
    <div class="left"><input type="text" name="keyword" id="title" class="input1" value="<?php echo !empty($keyword)&&!in_array($keyword,array('is_promote','is_qianggou','is_hot','is_best','is_new')) ? $keyword : "输入商品关键字";?>" onfocus="if(this.value=='输入商品关键字'){this.value='';}" onblur="if(this.value==''){this.value='输入商品关键字';}"></div>
  </div>
</form>
<ul class="goodslists">
<?php $imgs = array(); if(!empty($rt['categoodslist']))foreach($rt['categoodslist'] as $k=>$row){ $imgs[] = $row['goods_img'];?>
	<li style="width:50%; float:left; position:relative">
		<div style="padding:4px;">
		<a style="background:#fff; padding:5px; display:block;" href="<?php echo ADMIN_URL.($row['is_jifen']=='1'?'exchange':'product').'.php?id='.$row['goods_id'];?>">
			<div style=" height:150px; overflow:hidden; text-align:center;">
				<img src="<?php echo $row['goods_img'];?>" style="max-width:99%;display:inline;" alt="<?php echo $row['goods_name'];?>"/>
			</div>
			<p style="line-height:20px; height:20px; overflow:hidden; text-align:center"><?php echo $row['goods_name'];?></p>
					<p style="line-height:45px; height:45px; overflow:hidden;"><span style="float:left">本店价:</span><b class="price" style="font-size:14px; float:left; padding-left:3px;">￥<?php echo str_replace('.00','',$row['pifa_price']);?></b></p>
					<!--<p style="line-height:20px; height:20px; overflow:hidden; color:#999999"><del>市场价&nbsp;&nbsp;￥<?php echo str_replace('.00','',$row['shop_price']);?></del></p>-->
		</a>
		</div>
		<a href="<?php echo ADMIN_URL.($row['is_jifen']=='1'?'exchange':'product').'.php?id='.$row['goods_id'];?>"><span class="buyfals">立即购买</span></a>
	</li>
<?php } ?>
<div class="clear"></div>
</ul>
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
   $this->element('15/wxshare',array('lang' =>  array_merge($lang, $wxshare) )); 
 ?>
<?php $this->element('15/footer',array('lang'=>$lang)); ?>