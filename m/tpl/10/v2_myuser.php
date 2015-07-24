<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/15/css.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<style type="text/css">
#main li:hover{ background:#ededed}
#search {
	height: 60px;
	line-height: 60px;
	width: 96%;
	margin: 0 auto;
	position: relative;
}
#search input[type='text']{
	border: 1px solid #D3D3D3;
	height: 35px;
	margin: 0 auto;
	width: 96%;
	padding-left: 8px;
	color: #A4A4A4;
	font-size: 13px;
}
#search input.submit {
	background:url(../m/tpl/10/images/search_icon.png)  no-repeat;
	width: 21px;
	height: 21px;
	color: transparent;
	position: absolute;
	right:12px;
	top:18px;
}
</style>
<div style="line-height:44px; padding-left:10px; padding-right:10px;">
	<form id='search'method="post" action="<?php echo ADMIN_URL;?>daili.php?act=myuser&t=<?php echo $level;?>">
		<input type="text" placeholder="输入商品关键字"  name="keyword" id="title" value="<?php echo !empty($keyword)&&!in_array($keyword,array('is_promote','is_qianggou','is_hot','is_best','is_new')) ? $keyword : "输入商品关键字";?>"  onfocus="if(this.value=='输入商品关键字'){this.value='';}" onblur="if(this.value==''){this.value='输入商品关键字';}"/>
		<input type="submit" value="submit" class="submit"/>
	</form>
</div>

<div id="main" style="min-height:300px;margin-bottom:78px;">
	<ul class="v12_ul">
	<?php if(!empty($rt['lists']))foreach($rt['lists'] as $k=>$row){?>
		<li style="padding:5px; border-bottom:1px solid #d8d8d8; position:relative">
			<a href="<?php echo ADMIN_URL;?>daili.php?act=myuserinfo&uid=<?php echo $row['uid'];?>" style="display:block">
			<div style="position:relative; width:20%;float:left;"><img src="<?php echo !empty($row['headimgurl']) ? $row['headimgurl'] : $this->img('noavatar_big.jpg');?>" width="100%" style="margin-right:5px; padding:1px; border:1px solid #fafafa" />
			<?php if($row['is_subscribe']=='1'){?><img src="<?php echo $this->img('dui2.png');?>" style="position:absolute; bottom:5px; right:-2px; z-index:7" /><?php } ?>
			</div>
			<div style="float:right; width:78%;">
			<p style="line-height:23px"><?php echo $row['nickname'];?>&nbsp;&nbsp;<?php echo $row['subscribe_time']>0 ? date('Y-m-d H:i:s',$row['subscribe_time']) : date('Y-m-d H:i:s',$row['reg_time']);?></p>
			<p style="line-height:23px">资金&nbsp;<font color="#FF0000">￥<?php echo $row['money_ucount'];?></font>&nbsp;|&nbsp;积分&nbsp;<font color="#FF0000"><?php echo $row['points_ucount'];?></font>&nbsp;|&nbsp;邀请&nbsp;<font color="#FF0000"><?php echo $row['share_ucount']>0 ? $row['share_ucount'] : 0;?></font></p>
			</div>
			<div class="clear"></div>
			</a>
			<span style="border-radius:50%; height:22px; line-height:22px; width:22px; float:right; display:block;background:#EF7783; text-align:center; font-size:12px; font-weight:bold; color:#FFF; cursor:pointer; position:absolute;right:5px; top:17px; z-index:99" id="62"><i style="font-style:normal"><?php echo ++$k;?></i></span>
		</li>
	<?php }else{
	?>
	<li style="padding-top:60px; padding-bottom:60px; font-size:16px; text-align:center">
	目前数据为空的
	</li>
	<?php
	} ?>
	<div class="clear"></div>
	</ul>
	<div class="clear10"></div>
	<div class="loadsss" style="text-align:center">

	</div>
</div>
<script type="text/javascript">
var hh = 0;
var isrun = true;
var tops = 0;
function page_init(){
	hh = $('.v12_ul').height();
	tops = parseInt(hh);
}
//获取滚动条当前的位置
function getScrollTop() {
var scrollTop = 0;
if (document.documentElement && document.documentElement.scrollTop) {
scrollTop = document.documentElement.scrollTop;
}
else if (document.body) {
scrollTop = document.body.scrollTop;
}
return scrollTop;
}

//获取当前可是范围的高度
function getClientHeight() {
var clientHeight = 0;
if (document.body.clientHeight && document.documentElement.clientHeight) {
clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
}
else {
clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight);
}
return clientHeight;
}

//获取文档完整的高度
function getScrollHeight() {
return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
}

window.onscroll = function () {

if (getScrollTop() + getClientHeight() == getScrollHeight()) {
	//tops = getScrollHeight();

	$('.loadsss').html('<img src="<?php echo $this->img('loadings.gif');?>" style="width:16px!important; height:16px;" />加载中');
	setTimeout(function(){
		isrun = true;
	},15000);
	if(isrun==true){
		isrun = false;
		$.post('<?php echo ADMIN_URL;?>daili.php',{action:'ajax_myuser_page',tops:tops,hh:hh,level:'<?php echo $level;?>'},function(data){
			$('.loadsss').html("");
			if(data!=""){
				tops += hh;
				$('.v12_ul').append(data);
				isrun = true;
			}
		})
	}
}
}

$(document).ready(function(){
	page_init();
});
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
