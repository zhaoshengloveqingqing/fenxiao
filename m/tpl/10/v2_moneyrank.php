<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/v2_moneyrank.css<?php echo '?'.time();?>" media="all" />
<?php $this->element('10/top',array('lang'=>$lang)); ?>
<div id="main">
	<div class="money">
		<i></i>
		<p><span class="title">我的资金</span><span>￥<?php echo empty($rt['userinfo']['money_ucount']) ? '0' : $rt['userinfo']['money_ucount'];?></span></p>
		<p><span class="title">我的排名</span><span><?php echo $rt['userinfo']['thisrank'];?></span></p>
	</div>
	<ul class="ranking">
		<?php if(!empty($rt['ulist']))foreach($rt['ulist'] as $k=>$row){ ?>
		<li>
			<a class="ranking-list" href="">
				<img src="<?php echo !empty($row['headimgurl']) ? $row['headimgurl'] : $this->img('noavatar_big.jpg');?>">
				<?php if($row['is_subscribe']=='1'){?><img class="biaozhu" src="<?php echo $this->img('dui2.png');?>"/><?php } ?>
				<div class="info">
					<p><?php echo $row['nickname'];?></p>
					<p><?php echo !empty($row['subscribe_time']) ? date('Y-m-d H:i:s',$row['subscribe_time']) : date('Y-m-d H:i:s',$row['reg_time']);?></p>
					<p>资金<span>￥<?php echo $row['money_ucount'];?></span>邀请<span><?php echo $row['share_ucount'];?></span></p>
				</div>
			</a>
			<span>4</span>
			<?php if($k<3){

			$s = $k==0 ? 'gold_medal.png' : ($k==1?'silver_medal.png':'bronze_medal.png');
			?>
			<img src="<?php echo ADMIN_URL;?>tpl/10/images/<?php echo $s; ?>"/>
			<?php }?>
		</li>
		<?php } ?>
	</ul>
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
	tops = getScrollHeight();
	$('.loadsss').html('<img src="<?php echo $this->img('loadings.gif');?>" style="width:16px!important; height:16px;" />加载中');
	setTimeout(function(){
		isrun = true;
	},15000);
	if(isrun==true){
		isrun = false;
		$.post('<?php echo ADMIN_URL;?>daili.php',{action:'ajax_moneyrank_page',tops:tops,hh:hh},function(data){ 
			$('.loadsss').html("");
			if(data!=""){
				tops += hh;
				$('.v12_ul').append(data);
				isrun = true;
			}else{
				$('.loadsss').html("加载完毕");
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