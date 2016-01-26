<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<div class="main">
	<div class="user">
		<a href="<?php echo ADMIN_URL;?>user.php?act=myinfos" data-ajax="false"><img src="<?php echo !empty($rt['userinfo']['headimgurl']) ? $rt['userinfo']['headimgurl'] : (!empty($rt['userinfo']['avatar']) ? SITE_URL.$rt['userinfo']['avatar'] : $this->img('noavatar_big.jpg'));?>"></a>
		<div class="user_info">
			<p><span class="name"><?php echo empty($rt['userinfo']['nickname']) ? '未知' : $rt['userinfo']['nickname'];?></span></p>
			<p>会员ID:<span class="huiyuan">100<?php echo $rt['userinfo']['user_id'];?></span></p>
			<p>
				<?php if(empty($rt['userinfo']['subscribe_time'])){ ?>
					邀请时间：<span class="time"><?php echo date('Y-m-d',$rt['userinfo']['reg_time']);?></span>
				<?php }else{?>
					关注时间：<span class="time"><?php echo date('Y-m-d',$rt['userinfo']['subscribe_time']);?></span>
				<?php } ?>
			</p>
			<p>
				东家:<span class="dongjia">
				<?php echo $rt['userinfo']['user_rank']=='1' ? '否' : '是'; if($rt['userinfo']['user_rank']=='1'){?><a href="<?php echo ADMIN_URL.'in.php';?>">(点此购买成为东家)</a><?php } ?>
				</span>
			</p>
		</div>
	</div>
	<div class="point">
		<div class="point_info">
			<span>佣金</span>
			<span class="yongjin">￥<?php echo !empty($rt['pay5']) ? $rt['pay5'] : '0.00'; ?></span>
		</div>
		<div class="point_info">
			<span>个人积分</span>
			<span class="jifen"><?php echo empty($rt['userinfo']['mypoints']) ? '0' : $rt['userinfo']['mypoints'];?></span>
		</div>
	</div>
	<div class="tuijian">
		<p >
			你是由【<?php echo empty($rt['tjren']) ? '官网':$rt['tjren'];?>】推荐
			<!-- 你是由<em>官网</em>推荐 -->
		</p>
		<?php if(!empty($lang['site_notice'])){?>
		<div style="height:30px; line-height:30px; overflow:hidden">
			<marquee style="width:100%;"  scrollamount="4" direction="left"><?php echo $lang['site_notice'];?></marquee>
		</div>
		<?php } ?>
	</div>
	<div class="user_details">
		<ul>
			<li class="member">
				<a  href="javascript:;" onclick="ajax_show_sub(1,this);">
					我的会员<span><?php echo empty($rt['zcount']) ? '0' : $rt['zcount'];?></span>
				</a>
			</li>
			<div class="sub-menu clearfix gg1">
				<ul>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=1';?>">一级会员<span><?php echo empty($rt['zcount1']) ? '0' : $rt['zcount1'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=2';?>">二级会员<span><?php echo empty($rt['zcount2']) ? '0' : $rt['zcount2'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=3';?>">三级会员<span><?php echo empty($rt['zcount3']) ? '0' : $rt['zcount3'];?>人</span></a></li>
				</ul>
			</div>
			<li class="spread"><a href="javascript:;" onclick="ajax_show_sub(2,this);">我的推广<span><?php echo $rt['userinfo']['share_ucount']> 0 ? $rt['userinfo']['share_ucount'] : '0';?></span></a> </li>
			<div class="sub-menu clearfix gg2">
				<ul>
					<li><a href="<?php echo ADMIN_URL.'user.php?act=myshare';?>">点击链接<span><?php echo empty($rt['userinfo']['share_ucount']) ? '0' : $rt['userinfo']['share_ucount'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'user.php?act=myuser';?>">成功关注<span><?php echo empty($rt['userinfo']['guanzhu_ucount']) ? '0' : $rt['userinfo']['guanzhu_ucount'];?>人</span></a></li>
					<li><a href="javascript:void(0)">下单购买<span><?php echo empty($rt['userinfo']['ordercount']) ? '0' : $rt['userinfo']['ordercount'];?>单</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=my_is_daili';?>">成为分销<span><?php echo empty($rt['userinfo']['fxcount']) ? '0' : $rt['userinfo']['fxcount'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'user.php?act=myerweima';?>">我的二维码</a></li>
				</ul>
			</div>
			<li class="commision">
				<a href="javascript:;" onclick="ajax_show_sub(3,this);">我的佣金<span  class="commision">￥<?php echo !empty($rt['pay5']) ? $rt['pay5'] : '0.00';?></span></a>
			</li>
			<div class="sub-menu clearfix gg3">
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
			<li class="info"><a href="javascript:;" onclick="ajax_show_sub(4,this);">我的资料</a> </li>
			<div class="sub-menu clearfix gg4">
				<li><a href="<?php echo ADMIN_URL.'user.php?act=myinfos_u';?>">我的账号资料<i></i></a></li>
				<li><a href="<?php echo ADMIN_URL.'user.php?act=myinfos_s';?>">我的收货资料<i></i></a></li>
				<li><a href="<?php echo ADMIN_URL.'user.php?act=myinfos_b';?>">银行卡号资料<i></i></a></li>
			</div>
			<li class="order"><a href="<?php echo ADMIN_URL;?>user.php?act=orderlist">我的订单<i></i></a></li>
			<li class="collection"><a href="<?php echo ADMIN_URL;?>user.php?act=mycoll">我的收藏<i></i></a></li>
		</ul>
	</div>
</div>
<script type="text/javascript">
function ajax_show_sub(k,obj){
	$(".gg"+k).toggle();
	ll = $(".gg"+k).css('display');
	/*if(ll=='none'){
		$(obj).find('i').css('background','url(<?php echo $this->img('+h.png');?>) 10% center no-repeat');
	}else{
		$(obj).find('i').css('background','url(<?php echo $this->img('-h.png');?>) 10% center no-repeat');
	}*/
}
</script>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
