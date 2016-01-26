<?php
//后台菜单
$menu[1] = array(
	'en_name'=>'1',
	'big_key'=>'s01',
	'small_mod'=>'基本设置',
	'big_mod'=>'管理首页',
	'sub_mod'=>array(
		array('name'=>'信息设置','en_name'=>'101','url'=>'systemconfig.php?type=basic'),
		array('name'=>'站点SEO', 'en_name'=>'102','url'=>'systemconfig.php?type=seo'),
		array('name'=>'参数设置','en_name'=>'103','url'=>'systemconfig.php?type=arg'),
		array('name'=>'分销设置','en_name'=>'104','url'=>'weixin.php?type=userconfig'),
		array('name'=>'清空缓存','en_name'=>'105','url'=>'systemconfig.php?type=clear'),
		array('name'=>'手机预览','en_name'=>'106','url'=>'systemconfig.php?type=viewshop')
	)
);


/*$menu[2] = array(
	'en_name'=>'2',
	'big_key'=>'s01',
	'small_mod'=>'我们服务',
	'big_mod'=>'管理首页',
	'sub_mod'=>array(
		array('name'=>'在线升级','en_name'=>'201','url'=>'updates.php?f=online_update'),
		array('name'=>'提交信息','en_name'=>'202','url'=>'updates.php?f=submit_question'),
		array('name'=>'提交授权','en_name'=>'203','url'=>'updates.php?f=submit_shouquan')
	)
);*/

$menu[3] = array(
	'en_name'=>'3',
	'big_key'=>'s02',
	'small_mod'=>'数据库设置',
	'big_mod'=>'系统设置',
	'sub_mod'=>array(
		array('name'=>'备份数据库','en_name'=>'301','url'=>'backdb.php?type=backdb'),
		array('name'=>'还原数据库','en_name'=>'302','url'=>'backdb.php?type=restoredb'),
		array('name'=>'数据表优化','en_name'=>'303','url'=>'backdb.php?type=youhua')
	)
);
/*
$menu[4] = array(
	'en_name'=>'4',
	'big_key'=>'s02',
	'small_mod'=>'邮箱服务器设置',
	'big_mod'=>'系统设置',
	'sub_mod'=>array(
		array('name'=>'服务器账号设置','en_name'=>'401','url'=>'email.php?type=email_config'),
		array('name'=>'发送模板设置','en_name'=>'402','url'=>'email.php?type=tpl'),
		array('name'=>'发送开启设置','en_name'=>'403','url'=>'email.php?type=send')
	)
);*/

$menu[5] = array(
	'en_name'=>'5',
	'big_key'=>'s02',
	'small_mod'=>'管理员设置',
	'big_mod'=>'系统设置',
	'sub_mod'=>array(
		array('name'=>'管理员列表','en_name'=>'501','url'=>'manager.php?type=list'),
		array('name'=>'添加管理员','en_name'=>'502','url'=>'manager.php?type=add'),
		array('name'=>'管理员日记','en_name'=>'503','url'=>'manager.php?type=loglist'),
		array('name'=>'修改密码',		'en_name'=>'504','url'=>'manager.php?type=edit'),
		array('name'=>'权限组列表','en_name'=>'505','url'=>'manager.php?type=group'),
		array('name'=>'添加权限组','en_name'=>'506','url'=>'manager.php?type=group&tt=add')
	)
);
$menu[6] = array(
	'en_name'=>'6',
	'big_key'=>'s03',
	'small_mod'=>'会员管理',
	'big_mod'=>'用户管理',
	'sub_mod'=>array(
		array('name'=>'会员列表','en_name'=>'601','url'=>'user.php?type=list'),
		array('name'=>'添加会员','en_name'=>'602','url'=>'user.php?type=info'),
		array('name'=>'会员关系','en_name'=>'603','url'=>'user.php?type=userrelate'),
		array('name'=>'邀请统计','en_name'=>'604','url'=>'user.php?type=yaoqing'),
		array('name'=>'分享统计','en_name'=>'605','url'=>'user.php?type=sharetongji'),
		array('name'=>'积分统计','en_name'=>'606','url'=>'user.php?type=userjifen'),
		array('name'=>'会员等级','en_name'=>'607','url'=>'user.php?type=levellist')
       
	)
);
$menu[7] = array(
	'en_name'=>'7',
	'big_key'=>'s03',
	'small_mod'=>'分销会员',
	'big_mod'=>'用户管理',
	'sub_mod'=>array(
		array('name'=>'提款申请','en_name'=>'701','url'=>'user.php?type=drawmoney'),
		array('name'=>'分销申请','en_name'=>'702','url'=>'user.php?type=dailiapply'),
		array('name'=>'分销列表','en_name'=>'703','url'=>'user.php?type=suppliers'),
		array('name'=>'帐变明细','en_name'=>'704','url'=>'user.php?type=usermoney'),
		array('name'=>'添加分销','en_name'=>'705','url'=>'user.php?type=infodaili_step1'),
		array('name'=>'推广二维码','en_name'=>'706','url'=>'user.php?type=usererweima'),
//		array('name'=>'会员分红','en_name'=>'609','url'=>'user.php?type=user_bonus'),
//		array('name'=>'分红列表','en_name'=>'609','url'=>'user.php?type=user_bonus_list') 
		
	)
);

/*$menu[8] = array(
	'en_name'=>'8',
	'big_key'=>'s03',
	'small_mod'=>'附近商家',
	'big_mod'=>'用户管理',
	'sub_mod'=>array(
		array('name'=>'商家列表','en_name'=>'801','url'=>'con_new.php?type=newlist'),
		array('name'=>'添加商家','en_name'=>'802','url'=>'con_new.php?type=newadd')
	)
);

$menu[9] = array(
	'en_name'=>'9',
	'big_key'=>'s03',
	'small_mod'=>'群发工具',
	'big_mod'=>'用户管理',
	'sub_mod'=>array(
		array('name'=>'站内群发','en_name'=>'901','url'=>'user.php?type=send_message'),
		array('name'=>'客服群发','en_name'=>'902','url'=>'user.php?type=send_message_kefu'),
		array('name'=>'消息列表','en_name'=>'903','url'=>'user.php?type=messagelist')
	)
);*/

$menu[10] = array(
	'en_name'=>'10',
	'big_key'=>'s05',
	'small_mod'=>'商品管理',
	'big_mod'=>'产品管理',
	'sub_mod'=>array(
//		array('name'=>'积分商品','en_name'=>'1001','url'=>'exchange.php?type=lists'),
		array('name'=>'实体商品','en_name'=>'1003','url'=>'goods.php?type=goods_list'),
//		array('name'=>'虚拟商品','en_name'=>'1004','url'=>'vgoods.php?type=lists'),
		array('name'=>'我的回收站','en_name'=>'1005','url'=>'goods.php?type=goods_list_all'),
		array('name'=>'分类列表','en_name'=>'1007','url'=>'goods.php?type=cate_list'),
		array('name'=>'添加分类','en_name'=>'1008','url'=>'goods.php?type=cate_info'),
		array('name'=>'品牌列表','en_name'=>'1009','url'=>'brand.php?type=band_list'),
		array('name'=>'添加品牌','en_name'=>'1010','url'=>'brand.php?type=band_info'),
		array('name'=>'商品属性','en_name'=>'1011','url'=>'goods.php?type=goods_attr_list'),
//		array('name'=>'批量上传','en_name'=>'1012','url'=>'goods.php?type=batch_add_text'),
//		array('name'=>'批量传图','en_name'=>'1013','url'=>'goods.php?type=batch_add'),
//		array('name'=>'派放红包','en_name'=>'1013','url'=>'coupon.php?type=list'),
		array('name'=>'单品推荐','en_name'=>'1014','url'=>'goods.php?type=goods_tuijian'),
		array('name'=>'用户评论','en_name'=>'1015','url'=>'goods.php?type=comment_list')
	)
);

/*$menu[11] = array(
	'en_name'=>'11',
	'big_key'=>'s05',
	'small_mod'=>'促销活动',
	'big_mod'=>'产品管理',
	'sub_mod'=>array(
		array('name'=>'单品推荐','en_name'=>'1101','url'=>'goods.php?type=goods_tuijian'),
		array('name'=>'扫描产品','en_name'=>'1102','url'=>'cuxiao.php?type=saogoods'),
		array('name'=>'派放红包','en_name'=>'1103','url'=>'coupon.php?type=list'),
		array('name'=>'万能专区','en_name'=>'1107','url'=>'topgoods.php?type=clist'),
		array('name'=>'团购管理','en_name'=>'1108','url'=>'groupbuy.php?type=list'),
		array('name'=>'天天新品','en_name'=>'1109','url'=>'goods.php?type=goods_list&is_goods_attr=is_new'),
		array('name'=>'热销产品','en_name'=>'1110','url'=>'goods.php?type=goods_list&is_goods_attr=is_hot'),
		array('name'=>'推荐商品','en_name'=>'1111','url'=>'goods.php?type=goods_list&is_goods_attr=is_best')
	)
);*/

$menu[23] = array(
	'en_name'=>'23',
	'big_key'=>'s08',
	'small_mod'=>'订单管理',
	'big_mod'=>'订单管理',
	'sub_mod'=>array(
		array('name'=>'订单列表','en_name'=>'2301','url'=>'goods_order.php?type=list'),
		array('name'=>'待发货','en_name'=>'2302','url'=>'goods_order.php?type=list&status=210'),
		array('name'=>'物流单','en_name'=>'2303','url'=>'goods_order.php?type=list&tt=delivery&status=212'),
		array('name'=>'退货单','en_name'=>'2304','url'=>'goods_order.php?type=list&tt=back&status=314'),
		array('name'=>'退款单','en_name'=>'2305','url'=>'goods_order.php?type=list&tt=back&status=2'),
		array('name'=>'退货申请单','en_name'=>'2306','url'=>'goods_order.php?type=list&tt=back&status=5'),
		array('name'=>'退款申请单','en_name'=>'2307','url'=>'goods_order.php?type=list&tt=back&status=7')
	)
);

$menu[24] = array(
	'en_name'=>'24',
	'big_key'=>'s08',
	'small_mod'=>'其他设置',
	'big_mod'=>'订单管理',
	'sub_mod'=>array(
		array('name'=>'地区设置','en_name'=>'2401','url'=>'area.php?type=list'),
		array('name'=>'支付方式','en_name'=>'2402','url'=>'payment.php?type=list'),
		array('name'=>'配送方式','en_name'=>'2403','url'=>'shopping.php?type=shoppinglist'),
		array('name'=>'邮费设置','en_name'=>'2404','url'=>'delivery.php?type=list')
	)
);

$menu[16] = array(
	'en_name'=>'16',
	'big_key'=>'s06',
	'small_mod'=>'广告设置',
	'big_mod'=>'其他扩展',
	'sub_mod'=>array(
		array('name'=>'广告列表','en_name'=>'1601','url'=>'ads.php?type=adslist'),
		array('name'=>'广告标签','en_name'=>'1602','url'=>'ads.php?type=adstaglist'),
		array('name'=>'添加标签','en_name'=>'1603','url'=>'ads.php?type=adstag_add'),
		array('name'=>'添加广告','en_name'=>'1604','url'=>'ads.php?type=ads_add')
	)
);

$menu[32] = array(
	'en_name'=>'32',
	'big_key'=>'s06',
	'small_mod'=>'平台设置',
	'big_mod'=>'其他扩展',
	'sub_mod'=>array(
		array('name'=>'导航栏列表','en_name'=>'3202','url'=>'systemconfig.php?type=nav_list_wx'),
		array('name'=>'添加导航栏','en_name'=>'3203','url'=>'systemconfig.php?type=nav_info_wx'),
//		array('name'=>'模板设置','en_name'=>'3202','url'=>'muban.php?type=index'),
//		array('name'=>'新版模板设置','en_name'=>'3203','url'=>'muban.php?type=indexnew')
	)
);

/*$menu[17] = array(
	'en_name'=>'17',
	'big_key'=>'s06',
	'small_mod'=>'PC端导航',
	'big_mod'=>'其他扩展',
	'sub_mod'=>array(
		array('name'=>'导航栏列表','en_name'=>'1701','url'=>'systemconfig.php?type=nav_list'),
		array('name'=>'添加导航栏','en_name'=>'1702','url'=>'systemconfig.php?type=nav_add')
	)
);*/
/*$menu[33]= array(
	'en_name'=>'33',
	'big_key'=>'s06',
	'small_mod'=>'短信设置',
	'big_mod'=>'其他扩展',
	'sub_mod'=>array(
		array('name'=>'思远电子','en_name'=>'1701','url'=>'smsconfig.php?type=sms_yuansi'),
	)
);*/
$menu[21] = array(
	'en_name'=>'21',
	'big_key'=>'s010',
	'small_mod'=>'数据分析', 
	'big_mod'=>'数据管理',
	'sub_mod'=>array(
		array('name'=>'订单走势','en_name'=>'2101','url'=>'stats.php?type=order_trend'),
		array('name'=>'销售走势','en_name'=>'2102','url'=>'stats.php?type=sale_trend')
	)
);

$menu[26] = array(
	'en_name'=>'26',
	'big_key'=>'s09',
	'small_mod'=>'公众平台',
	'big_mod'=>'公众平台',
	'sub_mod'=>array(
		array('name'=>'公众号管理','en_name'=>'2601','url'=>'weixin.php?type=wxconfig'),
		array('name'=>'关注时回复','en_name'=>'2602','url'=>'weixin.php?type=wxgzreply'),
		array('name'=>'关注外链','en_name'=>'2603','url'=>'weixin.php?type=wxguanzhuurl'),
		array('name'=>'图文信息','en_name'=>'2604','url'=>'weixin.php?type=wxnewlist'),
		array('name'=>'文本信息','en_name'=>'2605','url'=>'weixin.php?type=wxnewlisttxt'),
		array('name'=>'分类列表','en_name'=>'2606','url'=>'weixin.php?type=catelist'),
		array('name'=>'自定义菜单','en_name'=>'2607','url'=>'weixin.php?type=diymenu'),
		array('name'=>'oauth','en_name'=>'2607','url'=>'weixin.php?type=oauth')
	)
);
?>
