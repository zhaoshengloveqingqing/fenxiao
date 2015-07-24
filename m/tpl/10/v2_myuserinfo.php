<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css<?php echo '?'.time();?>" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/user_index.css<?php echo '?'.time();?>" media="all" />
<div class="main">
	<div class="user">
		<img src="<?php echo ADMIN_URL;?>tpl/10/images/user.png"/>
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
				<?php echo $rt['userinfo']['user_rank']=='1' ? '否' : '是'; if($rt['userinfo']['user_rank']=='1'){?>(<a href="<?php echo ADMIN_URL.'in.php';?>">点此购买成为东家</a>)<?php } ?>
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
	<div class="user_details">
		<ul>
			<li class="member">
				<a  href="javascript:;" onclick="ajax_show_sub(1,this);">
					他的一级客户<span><?php echo empty($rt['zcount']) ? '0' : $rt['zcount'];?></span>
				</a>
			</li>
			<div class="sub-menu clearfix gg1">
				<ul>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=1';?>">代理人数<span><?php echo empty($rt['zcount1']) ? '0' : $rt['zcount1'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=2';?>">消费金额<span><?php echo empty($rt['zcount2']) ? '0' : $rt['zcount2'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=3';?>">贡献佣金<span><?php echo empty($rt['zcount3']) ? '0' : $rt['zcount3'];?>人</span></a></li>
				</ul>
			</div>
			<li class="spread"><a href="javascript:;" onclick="ajax_show_sub(2,this);">他的二级客户<span><?php echo $rt['userinfo']['share_ucount']> 0 ? $rt['userinfo']['share_ucount'] : '0';?></span></a> </li>
			<div class="sub-menu clearfix gg2">
				<ul>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=1';?>">代理人数<span><?php echo empty($rt['zcount1']) ? '0' : $rt['zcount1'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=2';?>">消费金额<span><?php echo empty($rt['zcount2']) ? '0' : $rt['zcount2'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=3';?>">贡献佣金<span><?php echo empty($rt['zcount3']) ? '0' : $rt['zcount3'];?>人</span></a></li>
				</ul>
			</div>
			<li class="commision">
				<a href="javascript:;" onclick="ajax_show_sub(3,this);">他的三级客户<span  class="commision">￥<?php echo !empty($rt['pay5']) ? $rt['pay5'] : '0.00';?></span></a>
			</li>
			<div class="sub-menu clearfix gg3">
				<ul>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=1';?>">代理人数<span><?php echo empty($rt['zcount1']) ? '0' : $rt['zcount1'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=2';?>">消费金额<span><?php echo empty($rt['zcount2']) ? '0' : $rt['zcount2'];?>人</span></a></li>
					<li><a href="<?php echo ADMIN_URL.'daili.php?act=myuser&t=3';?>">贡献佣金<span><?php echo empty($rt['zcount3']) ? '0' : $rt['zcount3'];?>人</span></a></li>
				</ul>
			</div>
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