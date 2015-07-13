<?php
class ShoppingController extends Controller{
    /*
     * @Photo Index
     * @param <type> $page
     * @param <type> $type
     */
 	function  __construct() {
		/*
		*构造函数
		*/
		$this->js(array('jquery.json-1.3.js','goods.js','user.js'));
		$this->css(array('comman.css'));
	}
	
	/*析构函数*/
	function  __destruct() {
        unset($rt);
    }
	////////////////////////////////////////////////////////////////////
	//一个商品对应多个收货地址
	function ajax_get_address($data=array()){
		$province = $data['province'];
		$city = $data['city'];
		$district = $data['district'];
		$resslist = $this->action('user','get_regions',1);  //获取省列表
		$dbress = array();
		if($province>0){
			$dbress['city'] = $this->action('user','get_regions',2,$province); 
		}
		if($city>0){
			$dbress['district'] = $this->action('user','get_regions',3,$city); 
		}
		$dbtype['province'] = $province;
		$dbtype['city'] = $city;
		$dbtype['district'] = $district;
		$this->set('dbtype',$dbtype);
		$this->set('dbress',$dbress);
		$this->set('resslist',$resslist);
		$this->set('goods_id', $data['gid']);
		echo $this->fetch('addressmore',true);
		exit;
	}
	
	function ajax_jisuanprice($data=array()){
		$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
		$rts = $this->App->findrow($sql);
		
		$gid = $data['gid'];
		$num = $data['num'];
		$goodslist = $this->Session->read('cart');
		$shop_price = $goodslist[$gid]['shop_price'];
		$pifa_price = $goodslist[$gid]['pifa_price'];
		
		$issubscribe = $this->Session->read('User.subscribe'); 
		$guanzhuoff = $rts['guanzhuoff'];
		$address3off = $rts['address3off'];
		$address2off = $rts['address2off'];
		if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
			$pifa_price = ($guanzhuoff/100) * $pifa_price;
		}
		if($num >= 2 && $address2off < 101 && $address2off > 0){
			$pifa_price = ($address2off/100) * $pifa_price;
		}
		if($num >= 3 && $address3off < 101 && $address3off > 0){
			$pifa_price = ($address3off/100) * $pifa_price;
		}
		
		echo $pifa_price; exit;
	}
	
	//原始下单版本
	function confirm_daigou(){
		$uid = $this->Session->read('User.uid');
		if(empty($uid)){ $this->jump(ADMIN_URL.'user.php?act=login',0,'请先登录！'); exit;}
		$order_sn = date('Y',mktime()).mktime();
		
		if(isset($_POST)&&!empty($_POST)){
			$totalprice = $_POST['totalprice'];
			if($totalprice < 0){
				$this->jump(ADMIN_URL,0,'非法提交');exit;
			}
			$pay_id = $_POST['pay_id'];
			$pay_name = $this->App->findvar("SELECT pay_name FROM `{$this->App->prefix()}payment` WHERE pay_id='$pay_id' LIMIT 1");
			$shipping_id = $_POST['shipping_id'];
			$shipping_name = $this->App->findvar("SELECT shipping_name FROM `{$this->App->prefix()}shipping` WHERE shipping_id='$shipping_id' LIMIT 1");
			$postscript = $_POST['postscript'];
			
			$goodslist = $this->Session->read('cart');
			if(empty($goodslist)){
				$this->jump(ADMIN_URL,0,'购物车为空');exit;
			}
			//添加订单表
			$orderdata = array();
			$orderdata['pay_id'] = $pay_id;
			$orderdata['shipping_id'] = $shipping_id;
			$orderdata['pay_name'] = $pay_name;
			$orderdata['shipping_name'] = $shipping_name;
			$orderdata['order_sn'] = $order_sn;
			$orderdata['user_id'] = $uid;
			$parent_uid = $this->App->findvar("SELECT parent_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid='$uid' LIMIT 1");
			$orderdata['parent_uid'] = $parent_uid >0 ? $parent_uid : '0';
			$orderdata['postscript'] = $postscript;
			$orderdata['goods_amount'] = $totalprice;
			$orderdata['order_amount'] = $totalprice;
			$orderdata['add_time'] = mktime();
			$this->App->insert('goods_order_info_daigou',$orderdata);
			$orderid = $this->App->iid();
			if($orderid > 0) foreach($goodslist as $row){
				$gid = $row['goods_id'];
				
				$consignees = $_POST['consignee'][$gid];
				$numbers = $_POST['goods_number'][$gid];
				$moblies = $_POST['moblie'][$gid];
				$provinces = $_POST['province'][$gid];
				$citys = $_POST['city'][$gid];
				$districts = $_POST['district'][$gid];
				$addresss = $_POST['address'][$gid];
				if(empty($consignees)) continue;
				
				
				//添加订单商品表
				$ds = array();
				$ds['order_id'] = $orderid;
				$ds['goods_id'] = $gid;
				$ds['brand_id'] = $row['brand_id'];
				$ds['goods_name'] = $row['goods_name'];
				$ds['goods_thumb'] = $row['goods_thumb'];
				$ds['goods_bianhao'] = $row['goods_bianhao'];
				$ds['goods_unit'] = $row['goods_unit'];
				$ds['goods_sn'] = $row['goods_sn'];
				$ds['market_price'] = $row['shop_price'];
				$ds['goods_price'] = $row['pifa_price'];
				if(!empty($row['spec'])) $ds['goods_attr'] = implode("、",$row['spec']);
				$this->App->insert('goods_order_daigou',$ds);
				$rec_id = $this->App->iid();
			
				//添加订单地址表
				if($rec_id > 0){
					foreach($consignees as $k=>$consignee){
						$dd = array();
						$dd['consignee'] = $consignee;
						$dd['goods_number'] = $numbers[$k];
						$dd['moblie'] = $moblies[$k];
						$dd['province'] = $provinces[$k];
						$dd['city'] = $citys[$k];
						$dd['district'] = $districts[$k];
						$dd['address'] = $addresss[$k];
						$dd['rec_id'] = $rec_id;
						$this->App->insert('goods_order_address',$dd);
					}
				}
				
			}
		}
		$this->Session->write('cart',null);
		$this->jump(ADMIN_URL.'mycart.php?type=pay&oid='.$orderid);exit;
		
		exit;
	}
	
	function pay(){
		$this->action('common','checkjump');
		if(!defined(NAVNAME)) define('NAVNAME', "在线支付");		 
		$oid = isset($_GET['oid']) ? $_GET['oid'] : 0;
		if(!($oid > 0)){
			$this->jump(ADMIN_URL);exit;
		}
		$sql = "SELECT * FROM `{$this->App->prefix()}goods_order_info_daigou` WHERE order_id='$oid' LIMIT 1";
		$orderinfo = $this->App->findrow($sql);
		if(empty($orderinfo)){
			$this->jump(ADMIN_URL);exit;
		}
		
		$sql = "SELECT tb1.*,SUM(tb2.goods_number) AS numbers FROM `{$this->App->prefix()}goods_order_daigou` AS tb1 LEFT JOIN `{$this->App->prefix()}goods_order_address` AS tb2 ON tb1.rec_id = tb2.rec_id WHERE tb1.order_id='$oid' GROUP BY tb2.rec_id";
		$ordergoods = $this->App->find($sql);

		$this->set('ordergoods',$ordergoods);
		$this->set('orderinfo',$orderinfo);
		$this->template('order_pay');
	}
	
	function pay2(){
		$this->action('common','checkjump');
		if(!defined(NAVNAME)) define('NAVNAME', "在线支付");		 
		$oid = isset($_GET['oid']) ? $_GET['oid'] : 0;
		if(!($oid > 0)){
			$this->jump(ADMIN_URL);exit;
		}
		$sql = "SELECT tb1.*,tb2.region_name AS province,tb3.region_name AS city,tb4.region_name AS district FROM `{$this->App->prefix()}goods_order_info` AS tb1";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb2 ON tb2.region_id = tb1.province";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb3 ON tb3.region_id = tb1.city";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb4 ON tb4.region_id = tb1.district";
		$sql .=" WHERE tb1.order_id='$oid'";	
		$rt['orderinfo'] = $this->App->findrow($sql);
		if(empty($rt['orderinfo'])){
			$this->jump(ADMIN_URL);exit;
		}
		
		$sql= "SELECT * FROM `{$this->App->prefix()}goods_order` WHERE order_id='$oid' ORDER BY goods_id";
		$rt['goodslist'] = $this->App->find($sql);
		
		$this->set('rt',$rt);
		$mb = $GLOBALS['LANG']['mubanid'] > 0 ? $GLOBALS['LANG']['mubanid'] : '';
		$this->template($mb.'/shopping_order_pay');
	}
	
	//快速支付
	function fastpay(){
		$oid = isset($_GET['oid']) ? $_GET['oid'] : 0;
		if(!($oid > 0)){
			$this->jump(ADMIN_URL,0,'意外错误');exit;
		}
		$uid = $this->Session->read('User.uid');
		$sql = "SELECT * FROM `{$this->App->prefix()}goods_order_info_daigou` WHERE pay_status = '0' AND order_id='$oid' LIMIT 1";
		$rt = $this->App->findrow($sql);
		
		if(empty($rt)){
			$this->jump(ADMIN_URL,0,'非法支付提交！'); exit;
		}
		
		$rts['pay_id'] = $rt['pay_id'];
		$rts['order_sn'] = $rt['order_sn'];
		$rts['order_amount'] = $rt['order_amount'];
		$rts['logistics_fee'] = $rt['shipping_fee'];
		$userredd = $this->App->findrow("SELECT * FROM `{$this->App->prefix()}systemconfig` WHERE type='basic' LIMIT 1");
		$rts['address'] = $userredd['company_url'];
			
		$this->_alipayment($rts);
		unset($rt);
		exit;
	}
	
	//快速支付
	function fastpay2(){
		$oid = isset($_GET['oid']) ? $_GET['oid'] : 0;
		if(!($oid > 0)){
			$this->jump(ADMIN_URL,0,'意外错误');exit;
		}
		$uid = $this->Session->read('User.uid');
		$sql = "SELECT * FROM `{$this->App->prefix()}goods_order_info` WHERE pay_status = '0' AND order_id='$oid' LIMIT 1";
		$rt = $this->App->findrow($sql);
		
		if(empty($rt)){
			$this->jump(ADMIN_URL,0,'非法支付提交！'); exit;
		}

		//判断是否库存足够
		$sql = "SELECT gdorder.`goods_number` as buy_num, goods.`goods_number` pro_num FROM `{$this->App->prefix()}goods_order` gdorder
			INNER JOIN `{$this->App->prefix()}goods` goods ON gdorder.goods_id = goods.goods_id
			WHERE gdorder.order_id = '$oid'";
		$order = $this->App->find($sql);
		if (!empty($order)) {
			foreach ($order as $item) {
				if ($item['pro_num'] < $item['buy_num']) {
					$this->jump(ADMIN_URL,0,'库存已不足，请重新下单购买!'); exit;
				}
			}
		}

		
		$rts['pay_id'] = $rt['pay_id'];
		$rts['order_sn'] = $rt['order_sn'];
		$rts['order_amount'] = $rt['order_amount'];
		$rts['logistics_fee'] = $rt['shipping_fee'];
		$userredd = $this->App->findrow("SELECT * FROM `{$this->App->prefix()}systemconfig` WHERE type='basic' LIMIT 1");
		$rts['address'] = $userredd['company_url'];
			
		$this->_alipayment($rts);
		unset($rt);
		exit;
	}
	
	function ajax_remove_cargoods($data=array()){
		$gid = $data['gid'];
		$uid = $this->Session->read('User.uid');
		if(!empty($gid)){
			$cartlist = $this->Session->read('cart');
			if(isset($cartlist[$gid])){ $this->Session->write("cart.{$gid}",null);}
			
			$useradd = $this->Session->read('useradd'); 
			if(isset($useradd[$gid])){ $this->Session->write("useradd.{$gid}",null);}
		}
		//返回总价
		$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
		$rts = $this->App->findrow($sql);
		$sql = "SELECT is_subscribe FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
		$issubscribe = $this->App->findvar($sql); 
		$guanzhuoff = $rts['guanzhuoff'];
		$address3off = $rts['address3off'];
		$address2off = $rts['address2off'];
		$prices = 0;
		$cartlist = $this->Session->read('cart');
		foreach($cartlist as $k=>$row){
			$counts = $row['number'];
			$off = 1;
			if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
				$off = ($guanzhuoff/100);
			}
			if($counts >= 2 && $address2off < 101 && $address2off > 0){
				$off = ($address2off/100);
			}
			if($counts >= 3 && $address3off < 101 && $address3off > 0){
				$off = ($address3off/100) * $off;
			}
			
			$prices += format_price($row['pifa_price'] * $off)*$row['number'];
		}
		echo format_price($prices);
	}
	
	/////////////////////////////////////////////////////////////////////////
	
	function _get_payinfo($id=0){
		if($id=='4'){ //微信支付
			$rt = $this->App->findrow("SELECT `pay_config` FROM `".$this->App->prefix()."payment` WHERE `pay_id`='$id' LIMIT 1");
			
/*			$appid = $this->Session->read('User.appid');
			if(empty($appid)) $appid = isset($_COOKIE[CFGH.'USER']['APPID']) ? $_COOKIE[CFGH.'USER']['APPID'] : '';
			$appsecret = $this->Session->read('User.appsecret');
			if(empty($appsecret)) $appsecret = isset($_COOKIE[CFGH.'USER']['APPSECRET']) ? $_COOKIE[CFGH.'USER']['APPSECRET'] : '';
			if(empty($appid) || empty($appsecret)){
				$sql = "SELECT appid,appsecret FROM `{$this->App->prefix()}wxuserset` WHERE id='1' LIMIT 1";
				$rts = $this->App->findrow($sql);
				$this->Session->write('User.appid',$rt['appid']);
				setcookie(CFGH.'USER[APPID]', $rt['appid'], mktime() + 3600*24);
				$this->Session->write('User.appsecret',$rt['appsecret']);
				setcookie(CFGH.'USER[APPSECRET]', $rt['appsecret'], mktime() + 3600*24);
			}else{
				$rts['appid'] = $appid;
				$rts['appsecret'] = $appsecret;
			}*/
			
			$sql = "SELECT appid,appsecret FROM `{$this->App->prefix()}wxuserset` WHERE id='1' LIMIT 1";
			$rts = $this->App->findrow($sql);
			$rt['appid'] = $rts['appid'];
			$rt['appsecret'] = $rts['appsecret'];
		}else{
			$rt = $this->App->findvar("SELECT `pay_config` FROM `".$this->App->prefix()."payment` WHERE `pay_id`='$id'");
		}
		return $rt;
	}
	
	//支付成功改变支付状态
	function pay_successs_tatus2($rt=array()){
		set_time_limit(300); //最大运行时间
		
		$order_sn = $rt['order_sn'];
		$status = $rt['status'];
		
		//购买用户返积分
		
		//上三级返佣金
		
		//送佣金，找出推荐用户
/*		$pu = $this->App->findrow("SELECT user_id,daili_uid,parent_uid,parent_uid2,parent_uid3,goods_amount,order_amount,order_sn,pay_status,order_id FROM `{$this->App->prefix()}goods_order_info` WHERE order_sn='$order_sn' LIMIT 1");
		$parent_uid = isset($pu['parent_uid']) ? $pu['parent_uid'] : 0; //分享者
		$parent_uid2 = isset($pu['parent_uid2']) ? $pu['parent_uid2'] : 0; //分享者
		$parent_uid3 = isset($pu['parent_uid3']) ? $pu['parent_uid3'] : 0; //分享者*/
		if(empty($order_sn))exit;
		$order_sn = substr($order_sn,-14,14);
		$pay_status = $this->App->findvar("SELECT pay_status FROM `{$this->App->prefix()}goods_order_info` WHERE order_sn='$order_sn' LIMIT 1");
		$tt = "false";
		if($pay_status!='1'){
			//检查
			$sql = "SELECT cid FROM `{$this->App->prefix()}user_money_change` WHERE order_sn='$order_sn'"; //资金
			$cid = $this->App->findvar($sql);
			if($cid > 0){
				return false;
				exit;
			}else{
				$sql = "SELECT cid FROM `{$this->App->prefix()}user_point_change` WHERE order_sn='$order_sn'"; //积分
				$cid = $this->App->findvar($sql);
				if($cid > 0){
					return false;
					exit;
				}else{
					$tt = "true";
				}
			}
		}
		
		if($tt == 'true' && $status=='1' && !empty($order_sn)){
			$pu = $this->App->findrow("SELECT user_id,daili_uid,parent_uid,parent_uid2,parent_uid3,goods_amount,order_amount,order_sn,pay_status,order_id FROM `{$this->App->prefix()}goods_order_info` WHERE order_sn='$order_sn' LIMIT 1");
			
			$parent_uid = isset($pu['parent_uid']) ? $pu['parent_uid'] : 0; //分享者
			$parent_uid2 = isset($pu['parent_uid2']) ? $pu['parent_uid2'] : 0; //分享者
			$parent_uid3 = isset($pu['parent_uid3']) ? $pu['parent_uid3'] : 0; //分享者
			$user_id = isset($pu['user_id']) ? $pu['user_id'] : 0; //分享者
			if($parent_uid>0){
				$sql = "SELECT p1_uid,p2_uid,p3_uid FROM `{$this->App->prefix()}user_tuijian_fx` WHERE uid = '$parent_uid'";
				$rr = $this->App->findrow($sql);
				if($parent_uid==$user_id){
					$parent_uid = isset($rr['p1_uid']) ? $rr['p1_uid'] : 0; //分享者
					$parent_uid2 = isset($rr['p2_uid']) ? $rr['p2_uid'] : 0; //分享者
					$parent_uid3 = isset($rr['p3_uid']) ? $rr['p3_uid'] : 0; //分享者
				}else{
					$parent_uid2 = isset($rr['p1_uid']) ? $rr['p1_uid'] : 0; //分享者
					$parent_uid3 = isset($rr['p2_uid']) ? $rr['p2_uid'] : 0; //分享者
				}
			}
			
			$daili_uid = isset($pu['daili_uid']) ? $pu['daili_uid'] : 0; //代理
			$moeys = isset($pu['order_amount']) ? $pu['order_amount'] : 0; //实际消费
			$uid = isset($pu['user_id']) ? $pu['user_id'] : 0;
			$pay_status = isset($pu['pay_status']) ? $pu['pay_status'] : 0;
			
			$order_id = isset($pu['order_id']) ? $pu['order_id'] : 0;
		
		
			$nickname = $this->App->findvar("SELECT nickname FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
			$dd = array();
			$dd['order_status'] = '2';
			$dd['pay_status'] = '1';
			$dd['pay_time'] = mktime();
			$this->App->update('goods_order_info',$dd,'order_sn',$order_sn);

			//修改库存
			$sql = "SELECT `goods_id`, `goods_number` FROM `{$this->App->prefix()}goods_order` gdorder
				INNER JOIN `{$this->App->prefix()}goods_order_info` info ON gdorder.order_id = info.order_id
				WHERE info.order_sn = '$order_sn'";
			$orders = $this->App->find($sql);
			if ($orders) {
				foreach ($orders as $order) {
					$sql = "UPDATE `{$this->App->prefix()}goods` SET `sale_count` = `sale_count` + {$order['goods_number']} , `goods_number` = `goods_number`- '{$order['goods_number']}' WHERE goods_id = '{$order['goods_id']}'";
					$this->App->query($sql);
				}
			}
			
			
			$rrL = $this->action('common','get_userconfig');
			$openfx_minmoney = empty($rrL['openfx_minmoney']) ? 0 : intval($rrL['openfx_minmoney']);
			
			if($rrL['openfxbuy']=='1' && $moeys >= $openfx_minmoney){ 
				//付款开通代理
				if($uid > 0){
					$rank = $this->App->findvar("SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id = '$uid' LIMIT 1");
					if($rank=='1'){
						$this->App->update('user',array('user_rank'=>'12'),'user_id',$uid);
						
						$this->App->update('user_tuijian',array('daili_uid'=>$uid),'uid',$uid);
						
						$this->update_user_tree($uid,$uid);
						
						$this->update_daili_tree($uid);//更新代理关系
					}
				}
			}
			
			$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//用户配置信息
			$rts = $this->App->findrow($sql);
			
			$appid = $this->Session->read('User.appid');
			if(empty($appid)) $appid = isset($_COOKIE[CFGH.'USER']['APPID']) ? $_COOKIE[CFGH.'USER']['APPID'] : '';
			$appsecret = $this->Session->read('User.appsecret');
			if(empty($appsecret)) $appsecret = isset($_COOKIE[CFGH.'USER']['APPSECRET']) ? $_COOKIE[CFGH.'USER']['APPSECRET'] : '';

			//计算资金，便于下面返佣
			//计算每个产品的佣金
			$sql = "SELECT takemoney1,takemoney2,takemoney3,goods_number FROM `{$this->App->prefix()}goods_order` WHERE order_id='$order_id'";
			//echo $sql;
			//exit;
			$moneys = $this->App->find($sql);
			//购物者根据消费金额送积分
			$pointnum =  $rts['pointnum'];
			if($pointnum > 0 && !empty($moeys)){
				    
					//检查是否重复返
					$sql = "SELECT cid FROM `{$this->App->prefix()}user_point_change` WHERE order_sn='$order_sn' AND user_id='$uid'";
					$chenkid = $this->App->findvar($sql);
					if($chenkid > 0){
						return;
						exit;
					}
					
					$pointnum_ag =  isset($rts['pointnum_ag'])&&!empty($rts['pointnum_ag']) ? $rts['pointnum_ag'] : 1;
					$points = intval($moeys * $pointnum * $pointnum_ag);
					$thismonth = date('Y-m-d',mktime());
					//购买者送积分
					if ($points) {
						$sql = "UPDATE `{$this->App->prefix()}user` SET `points_ucount` = `points_ucount`+$points,`mypoints` = `mypoints`+$points WHERE user_id = '$uid'";
						$this->App->query($sql);
						$this->App->insert('user_point_change',array('order_sn'=>$order_sn,'thismonth'=>$thismonth,'points'=>$points,'changedesc'=>'消费返积分','time'=>mktime(),'uid'=>$uid));
						//发送推荐用户通知
						$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>''),'payreturnpoints');
					}
			}
			
			$record = array();
			$moeys = 0;
				
			//一级返佣金
			if($parent_uid > 0){
				//推荐者送积分
				$tjpointnum =  isset($rts['tjpointnum']) ? $rts['tjpointnum'] : 0;
				if($tjpointnum > 0 ){
					$pid = $this->App->findvar("SELECT parent_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid='$uid' LIMIT 1");
					if($pid > 0){
						$tjpointnum_ag =  isset($rts['tjpointnum_ag'])&&!empty($rts['tjpointnum_ag']) ? $rts['tjpointnum_ag'] : 1;
						$points2 = intval($moeys * $tjpointnum * $tjpointnum_ag);
						$thismonth = date('Y-m-d',mktime());
						//购买者送积分
						if ($points2) {
							$sql = "UPDATE `{$this->App->prefix()}user` SET `points_ucount` = `points_ucount`+$points2,`mypoints` = `mypoints`+$points2 WHERE user_id = '$pid'";
							$this->App->query($sql);
							$this->App->insert('user_point_change',array('order_sn'=>$order_sn,'thismonth'=>$thismonth,'points'=>$points2,'changedesc'=>'推荐消费返积分','time'=>mktime(),'uid'=>$pid));
						}
					}
				}	
				
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank != '1'){ //不是普通会员
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
/*					if($types=='1'){ //全职
						if($rts['ticheng360_1'] < 101 && $rts['ticheng360_1'] > 0){
							$off = $rts['ticheng360_1']/100;
						}
					}else{*/
						if($rank=='12'){ //普通分销商
							if($rts['ticheng180_1'] < 101 && $rts['ticheng180_1'] > 0){
								$off = $rts['ticheng180_1']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney1'] > 0){
										$moeys +=$row['takemoney1'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='11'){//高级分销商
							if($rts['ticheng180_h1_1'] < 101 && $rts['ticheng180_h1_1'] > 0){
								$off = $rts['ticheng180_h1_1']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney2'] > 0){
										$moeys +=$row['takemoney2'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='10'){//特权分销商
							if($rts['ticheng180_h2_1'] < 101 && $rts['ticheng180_h2_1'] > 0){
								$off = $rts['ticheng180_h2_1']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney3'] > 0){
										$moeys +=$row['takemoney3'] * $row['goods_number'] * $off;
									}
								}
							}
						}
						
					//}

					
					if($moeys > 0) $moeys = format_price($moeys);
					if(!empty($moeys)){
						$record['puid1_money'] = $moeys;
						$record['p_uid1'] = $parent_uid;
						$thismonth = date('Y-m-d',mktime());
						$thism = date('Y-m',mktime());
						$sql = "UPDATE `{$this->App->prefix()}user` SET `money_ucount` = `money_ucount`+$moeys,`mymoney` = `mymoney`+$moeys WHERE user_id = '$parent_uid'";
						$this->App->query($sql);
						$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid));
						
						//发送推荐用户通知
						$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid' LIMIT 1");
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>$nickname),'payreturnmoney');
					}
				}
			}
			
			$moeys = 0;
			//二级返佣金
			if($parent_uid2 > 0){
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid2' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank != '1'){ //不是普通会员
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid2' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
/*					if($types=='1'){ //全职
						if($rts['ticheng360_2'] < 101 && $rts['ticheng360_2'] > 0){
							$off = $rts['ticheng360_2']/100;
						}
					}else{*/
						if($rank=='12'){ //普通分销商
							if($rts['ticheng180_2'] < 101 && $rts['ticheng180_2'] > 0){
								$off = $rts['ticheng180_2']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney1'] > 0){
										$moeys +=$row['takemoney1'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='11'){//高级分销商
							if($rts['ticheng180_h1_2'] < 101 && $rts['ticheng180_h1_2'] > 0){
								$off = $rts['ticheng180_h1_2']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney2'] > 0){
										$moeys +=$row['takemoney2'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='10'){//特权分销商
							if($rts['ticheng180_h2_2'] < 101 && $rts['ticheng180_h2_2'] > 0){
								$off = $rts['ticheng180_h2_2']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney3'] > 0){
										$moeys +=$row['takemoney3'] * $row['goods_number'] * $off;
									}
								}
							}
						}
						
					//}
					if($moeys > 0) $moeys = format_price($moeys);
					if(!empty($moeys)){
						$record['puid2_money'] = $moeys;
						$record['p_uid2'] = $parent_uid2;
						$thismonth = date('Y-m-d',mktime());
						$thism = date('Y-m',mktime());
						$sql = "UPDATE `{$this->App->prefix()}user` SET `money_ucount` = `money_ucount`+$moeys,`mymoney` = `mymoney`+$moeys WHERE user_id = '$parent_uid2'";
						$this->App->query($sql);
						$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid2));
						
						//发送推荐用户通知
						$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid2' LIMIT 1");
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>$nickname),'payreturnmoney');
					}
				}
			}
			
			$moeys = 0;
			//三级返佣金
			if($parent_uid3 > 0){
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid3' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank != '1'){ //不是普通会员
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid3' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
/*					if($types=='1'){ //全职
						if($rts['ticheng360_3'] < 101 && $rts['ticheng360_3'] > 0){
							$off = $rts['ticheng360_3']/100;
						}
					}else{*/
						if($rank=='12'){ //普通分销商
							if($rts['ticheng180_3'] < 101 && $rts['ticheng180_3'] > 0){
								$off = $rts['ticheng180_3']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney1'] > 0){
										$moeys +=$row['takemoney1'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='11'){//高级分销商
							if($rts['ticheng180_h1_3'] < 101 && $rts['ticheng180_h1_3'] > 0){
								$off = $rts['ticheng180_h1_3']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney2'] > 0){
										$moeys +=$row['takemoney2'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='10'){//特权分销商
							if($rts['ticheng180_h2_3'] < 101 && $rts['ticheng180_h2_3'] > 0){
								$off = $rts['ticheng180_h2_3']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney3'] > 0){
										$moeys +=$row['takemoney3'] * $row['goods_number'] * $off;
									}
								}
							}
						}
						
					//}
					if($moeys > 0) $moeys = format_price($moeys);
					if(!empty($moeys)){
						$record['puid3_money'] = $moeys;
						$record['p_uid3'] = $parent_uid3;
						$thismonth = date('Y-m-d',mktime());
						$thism = date('Y-m',mktime());
						$sql = "UPDATE `{$this->App->prefix()}user` SET `money_ucount` = `money_ucount`+$moeys,`mymoney` = `mymoney`+$moeys WHERE user_id = '$parent_uid3'";
						$this->App->query($sql);
						$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid3));
						
						//发送推荐用户通知
						$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid3' LIMIT 1");
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>$nickname),'payreturnmoney');
					}
				}
			}
			
			if(!empty($record)){
				$record['oid'] = $order_id;
				$record['uid'] = $uid;
				$record['date_y'] = date('Y',mktime());
				$record['date_m'] = date('Y-m',mktime());
				$record['date_d'] = date('Y-m-d',mktime());
				$this->App->insert('user_money_record',$record);
			}
			
			if($uid > 0){
				$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$uid' AND is_subscribe='1' LIMIT 1");

				//如果是虚拟卡变更状态
				$sql = "SELECT type,consignee FROM `{$this->App->prefix()}goods_order_info` WHERE order_sn='$order_sn' LIMIT 1";
				$types = $this->App->findrow($sql);
				$type = $types['type'];
				$nickname = $types['consignee'];
				if($type=='3'){
					$this->App->update('goods_order_info',array('shipping_status'=>'5'),'order_sn',$order_sn);
					$gid = $this->App->findvar("SELECT goods_id FROM `{$this->App->prefix()}goods_order` WHERE order_id='$order_id' LIMIT 1");
					if($gid > 0){
						$ids = $this->App->findrow("SELECT id,goods_pass,goods_sn FROM `{$this->App->prefix()}goods_sn` WHERE goods_id='$gid' AND is_use = '0' ORDER BY id ASC LIMIT 1");
						if(!empty($ids)){
							$id = $ids['id'];
							$pass = $ids['goods_pass'];
							$sn = $ids['goods_sn'];
							$this->App->update('goods_sn',array('is_use'=>'1','usetime'=>mktime(),'order_id'=>$order_id),'id',$id);
						}
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>'','appsecret'=>'','nickname'=>$nickname,'goods_pass'=>$pass,'goods_sn'=>$sn),'payconfirm_vg');

					}
				}else{
					//发送通知
					if(!empty($pwecha_id)){
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>'','appsecret'=>'','nickname'=>$nickname),'payconfirm');
					}
				}
			}	
			
		
		}//end if
		
	}//end function
	
	function return_daili_uid($uid=0,$k=0){
		if(!($uid > 0)){
			return 0;
		}
		$puid = 0;
		//for($i=0;$i<20;$i++){
		if($k<20){
				$sql = "SELECT parent_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid = '$uid' LIMIT 1";
				$puid = $this->App->findvar($sql);
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id = '$puid' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank == '1'){
					++$k;
					$this->return_daili_uid($puid,$k);
				}else{
					return $puid;
				}
		}
		//}
		return $puid;
	}
	
	function update_daili_tree($uid=0){
		if($uid>0){
			//for($i=0;$i<100;$i++){
				$dd = array();
				$ss = array();
				$ss[] = $uid;
				$dd['addtime'] = time();
				$dd['uid'] = $uid;
				$dd['p1_uid'] = 0;
				$dd['p2_uid'] = 0;
				$dd['p3_uid'] = 0;
				
				$p1_uid = $this->return_daili_uid($uid);
			
				if($p1_uid > 0 && !in_array($p1_uid,$ss)){
					$dd['p1_uid'] = $p1_uid;
					//$sql = "SELECT daili_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid = '$p1_uid' LIMIT 1";
					//$p2_uid = $this->App->findvar($sql);
					$p2_uid = $this->return_daili_uid($p1_uid);
					$ss[] = $p1_uid;
					$ss[] = $uid;
					if($p2_uid > 0 && !in_array($p2_uid,$ss)){
						$dd['p2_uid'] = $p2_uid;
						//$sql = "SELECT daili_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid = '$p2_uid' LIMIT 1";
						//$p3_uid = $this->App->findvar($sql);
						$p3_uid = $this->return_daili_uid($p2_uid);
						$ss[] = $p2_uid;
						if($p3_uid > 0 && !in_array($p3_uid,$ss)){
							$dd['p3_uid'] = $p3_uid;
							//$sql = "SELECT daili_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid = '$p3_uid' LIMIT 1";
							//$p4_uid = $this->App->findvar($sql);
/*							$p4_uid = $this->return_daili_uid($p3_uid);
							if($p4_uid > 0){
								$dd['p4_uid'] = $p4_uid;
							}*/
						}
					}
				}
				//
				$sql = "SELECT id FROM `{$this->App->prefix()}user_tuijian_fx` WHERE uid='$uid' LIMIT 1";
				$id = $this->App->findvar($sql);
				
				if($id > 0){
					$this->App->update('user_tuijian_fx',$dd,'id',$id);
				}else{
					$this->App->insert('user_tuijian_fx',$dd);
				}
			//}
		}
	}
	
   function update_user_tree($puid = 0,$ppuid=0)
	{
		$three_arr = array();
		$sql = 'SELECT id,uid FROM `'.$this->App->prefix()."user_tuijian` WHERE parent_uid = '$puid'";
		$rt = $this->App->find($sql);
		if(!empty($rt))foreach($rt as $row){
			$id = $row['id'];
			$uid = $row['uid'];//
			//更新
			if($id > 0){
				$this->App->update('user_tuijian',array('daili_uid'=>$ppuid),'id',$id);
			}
			//判断当前是否是代理
			$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
			$rank = $this->App->findvar($sql);
			if($rank=='1'){ //普通会员
				$this->update_user_tree($uid,$ppuid);
			}else{
			}
		}
	}
	
	//支付成功改变支付状态(代购模式)
	function pay_successs_tatus($rt=array()){
		$order_sn = $rt['order_sn'];
		$status = $rt['status'];
		
		//送佣金，找出推荐用户
		$pu = $this->App->findrow("SELECT user_id,daili_uid,parent_uid,goods_amount,order_amount,order_sn FROM `{$this->App->prefix()}goods_order_info_daigou` WHERE order_sn='$order_sn' LIMIT 1");
		$parent_uid = isset($pu['parent_uid']) ? $pu['parent_uid'] : 0; //分享者
		$daili_uid = isset($pu['daili_uid']) ? $pu['daili_uid'] : 0; //代理
		$moeys = isset($pu['order_amount']) ? $pu['order_amount'] : 0;
		$uid = isset($pu['user_id']) ? $pu['user_id'] : 0;
		
		//检查
		$tt = "false";
		$sql = "SELECT cid FROM `{$this->App->prefix()}user_money_change` WHERE order_sn='$order_sn'"; //资金
		$cid = $this->App->findvar($sql);
		if($cid > 0){
			return false;exit;
		}else{
			$sql = "SELECT cid FROM `{$this->App->prefix()}user_point_change` WHERE order_sn='$order_sn'"; //积分
			$cid = $this->App->findvar($sql);
			if($cid > 0){
				return false;exit;
			}else{
				$tt = "true";
			}
		}
		
		if($tt == 'true' && $status=='1' && !empty($order_sn)){
			$nickname = $this->App->findvar("SELECT nickname FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
			$dd = array();
			$dd['order_status'] = 2;
			$dd['pay_status'] = 1;
			$dd['pay_time'] = mktime();

			$this->App->update('goods_order_info_daigou',$dd,'order_sn',$order_sn);
			
			$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
			$rts = $this->App->findrow($sql);
			
			$appid = $this->Session->read('User.appid');
			if(empty($appid)) $appid = isset($_COOKIE[CFGH.'USER']['APPID']) ? $_COOKIE[CFGH.'USER']['APPID'] : '';
			$appsecret = $this->Session->read('User.appsecret');
			if(empty($appsecret)) $appsecret = isset($_COOKIE[CFGH.'USER']['APPSECRET']) ? $_COOKIE[CFGH.'USER']['APPSECRET'] : '';
			
			//购物上级以及购物者送积分
			$pointnum =  $rts['pointnum'];
			if($pointnum > 0 && !empty($moeys)){
					if($parent_uid > 0){ //存在上级，积分对半分
						$points = ceil(intval($moeys * $pointnum)/2);
						$points = intval($points);
					}else{
						$points = intval($moeys * $pointnum);
					}
					$thismonth = date('Y-m-d',mktime());
					//购买者送积分
					$sql = "UPDATE `{$this->App->prefix()}user` SET `points_ucount` = `points_ucount`+$points,`mypoints` = `mypoints`+$points WHERE user_id = '$uid'";
					$this->App->query($sql);
					$this->App->insert('user_point_change',array('order_sn'=>$order_sn,'thismonth'=>$thismonth,'points'=>$points,'changedesc'=>'消费返积分','time'=>mktime(),'uid'=>$uid));
					//发送推荐用户通知
					$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
					$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>''),'payreturnpoints');

					//上级推荐用户的
					if($parent_uid > 0){
						$sql = "UPDATE `{$this->App->prefix()}user` SET `points_ucount` = `points_ucount`+$points,`mypoints` = `mypoints`+$points WHERE user_id = '$parent_uid'";
						$this->App->query($sql);
						$this->App->insert('user_point_change',array('order_sn'=>$order_sn,'thismonth'=>$thismonth,'points'=>$points,'changedesc'=>'推荐消费返积分','time'=>mktime(),'uid'=>$parent_uid));
						//发送推荐用户通知
						$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid' LIMIT 1");
						$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>''),'payreturnpoints_parentuid');

					}
			}
			
			//检查当前用户是否是代理
			$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";//配置信息
			$rank = $this->App->findvar($sql);
			if($rank=='10' && !empty($moeys)){ //如果是代理商，返佣给自己
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
					if($types=='1'){ //全职
						if($rts['ticheng360'] < 101 && $rts['ticheng360'] > 0){
							$off = $rts['ticheng360']/100;
						}
					}else{
						if($rts['ticheng180'] < 101 && $rts['ticheng180'] > 0){
							$off = $rts['ticheng180']/100;
						}
					}
					$moeys = format_price($moeys*$off);
					$thismonth = date('Y-m-d',mktime());
					$thism = date('Y-m',mktime());
					$sql = "UPDATE `{$this->App->prefix()}user` SET `money_ucount` = `money_ucount`+$moeys,`mymoney` = `mymoney`+$moeys WHERE user_id = '$uid'";
					$this->App->query($sql);
					$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$uid));
					
					//发送推荐用户通知
					$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
					$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>$nickname),'payreturnmoney');
					
			}elseif($daili_uid > 0 && !empty($moeys)){ //推荐送佣金给代理
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$daili_uid' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
					if($types=='1'){ //全职
						if($rts['ticheng360'] < 101 && $rts['ticheng360'] > 0){
							$off = $rts['ticheng360']/100;
						}
					}else{
						if($rts['ticheng180'] < 101 && $rts['ticheng180'] > 0){
							$off = $rts['ticheng180']/100;
						}
					}
					$moeys = format_price($moeys*$off);
					$thismonth = date('Y-m-d',mktime());
					$thism = date('Y-m',mktime());
					$sql = "UPDATE `{$this->App->prefix()}user` SET `money_ucount` = `money_ucount`+$moeys,`mymoney` = `mymoney`+$moeys WHERE user_id = '$daili_uid'";
					$this->App->query($sql);
					$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'推荐用户购买返佣金','time'=>mktime(),'uid'=>$daili_uid));
					
					//发送推荐用户通知
					$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$daili_uid' LIMIT 1");
					$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>$nickname),'payreturnmoney');
			}
		}
		
	}
	
	//支付成功或者失败跳转的页面
	function paysuccessjump($t = ''){
		$url = str_replace('paywx/','',ADMIN_URL);
		if($t=='1'){
			$this->jump($url,0,'你已经成功支付，感谢你的支持。');exit;
		}elseif($t=='2'){
			$this->jump($url,0,'支付发生意外错误，请稍后再试。');exit;
		}
		$this->jump($url);exit;
	}
	
	//获取用户的openid
	function get_openid_AND_pay_info(){
		$wecha_id = $this->Session->read('User.wecha_id');
		if(empty($wecha_id)) $wecha_id = isset($_COOKIE[CFGH.'USER']['UKEY']) ? $_COOKIE[CFGH.'USER']['UKEY'] : '';
		
		//
		$order_sn = isset($_GET['order_sn']) ? $_GET['order_sn'] : '';
		$sql = "SELECT order_id,  order_sn,order_amount,pay_status,shipping_fee FROM `{$this->App->prefix()}goods_order_info` WHERE pay_status = '0' AND order_sn='$order_sn' LIMIT 1";
		$rt = $this->App->findrow($sql);
		$rt['order_amount'] = $rt['order_amount']+$rt['shipping_fee'];
		if(empty($rt)){
			$this->jump(str_replace('/WxPay','',ADMIN_URL),0,'非法支付提交！'); exit;
		}
		if($rt['pay_status']=='1'){
			$this->jump(str_replace('/WxPay','',ADMIN_URL).'user.php?act=orderlist');exit;
		}
		$rt['openid'] = $wecha_id;
		
		$sql = "SELECT goods_name FROM `{$this->App->prefix()}goods_order` WHERE order_id='{$rt['order_id']}' LIMIT 1";
		$order = $this->App->findrow($sql);
		$rt['body'] = $order['goods_name']  ? $order['goods_name']  : $GLOBALS['LANG']['site_name'].'购物平台';
		return $rt;
	}
	
	function _alipayment($rt=array()){
		$pay_id = $rt['pay_id'];
		
		$order_sn = $rt['order_sn']; //网站唯一订单编号
		
		if($pay_id=='4'){ //微信支付
			$this->jump(ADMIN_URL.'WxPay/js_api_call.php?order_sn='.$order_sn);exit;	
		}
		if($pay_id=='6'){ //云支付
			$this->jump(ADMIN_URL.'yunpay/yunpay.php?order_sn='.$order_sn);exit;	
		}
		
		$sql = "SELECT `pay_config` FROM `".$this->App->prefix()."payment` WHERE `pay_id`='$pay_id'";
		$pay_config = $this->App->findvar($sql);
		$configr = unserialize($pay_config);
		$paypalmail = isset($configr['pay_no']) ? $configr['pay_no'] : '';
        if(!$paypalmail){
			$this->jump(ADMIN_URL,0,'这是货到付款方式，等待商家发货');exit;	
            return false;
        }
		
		$order_amount = $rt['order_amount']+$rt['logistics_fee'];
		if(!$paypalmail){
            return false;
        }
		if($pay_id=='3'){ //支付宝
			//WAP
			$paypal_form = "<form name='aqua' method='post' action='".ADMIN_URL."paywx/alipayapi.php'>
				<input type='hidden' name='WIDout_trade_no' value='".$order_sn."'>
				<input type='hidden' name='WIDseller_email' value='".$paypalmail."'>
				<input type='hidden' name='WIDsubject' value='商城支付系统'>
				<input type='hidden' name='WIDtotal_fee' value='".$order_amount."'>
			</form>";
			$paypal_form.="<script language='javascript'>
					aqua.submit();
					</script>
					";
		echo $paypal_form;
		}
		
		die();
	}
	
	
	//确认订单
	function confirm_daigou2(){
		$uid = $this->Session->read('User.uid');
		if(empty($uid)){ $this->jump(ADMIN_URL.'user.php?act=login',0,'请先登录！'); exit;}
		$order_sn = date('Y',mktime()).mktime();
		
		if(isset($_POST)&&!empty($_POST)){
			//$totalprice = $_POST['totalprice'];
			//if($totalprice < 0){
				//$this->jump(ADMIN_URL,0,'非法提交');exit;
			//}
			$addresssall = $_POST['address'];
			$pay_id = $_POST['pay_id'];
			$pay_name = $this->App->findvar("SELECT pay_name FROM `{$this->App->prefix()}payment` WHERE pay_id='$pay_id' LIMIT 1");
			$shipping_id = $_POST['shipping_id'];
			$shipping_name = $this->App->findvar("SELECT shipping_name FROM `{$this->App->prefix()}shipping` WHERE shipping_id='$shipping_id' LIMIT 1");
			$postscript = $_POST['postscript'];
			
			$goodslist = $this->Session->read('cart');
			if(empty($goodslist)){
				$this->jump(ADMIN_URL,0,'购物车为空');exit;
			}
			$totalprice = 0;
			$stotalprice = 0;
			foreach($goodslist as $gid=>$row){
				if($row['is_jifen_session']=='1'){
					$this->Session->write("cart.$gid",null);
					$this->Session->write('useradd.$gid',null); 
					continue; 
				}
				if(!($row['number'] > 0)){
					$row['number'] = 1;
					$this->Session->write("cart.{$gid}.number",1);
				}
				$totalprice +=$row['price']*$row['number'];
				$stotalprice +=$row['pifa_price']*$row['number'];
			}
			if(!($totalprice>0)){
				$this->jump(ADMIN_URL,0,'非法 提交');exit;
			}
			//添加订单表
			$orderdata = array();
			$orderdata['pay_id'] = $pay_id;
			$orderdata['shipping_id'] = $shipping_id;
			$orderdata['pay_name'] = $pay_name;
			$orderdata['shipping_name'] = $shipping_name;
			$orderdata['order_sn'] = $order_sn;
			$orderdata['user_id'] = $uid;
			$pr = $this->App->findrow("SELECT parent_uid,daili_uid FROM `{$this->App->prefix()}user_tuijian` WHERE uid='$uid' LIMIT 1");
			$parent_uid = isset($pr['parent_uid']) ? $pr['parent_uid'] : 0;
			$daili_uid = isset($pr['daili_uid']) ? $pr['daili_uid'] : 0;
			$orderdata['parent_uid'] = $parent_uid >0 ? $parent_uid : '0';
			$orderdata['daili_uid'] = $daili_uid >0 ? $daili_uid : '0';
			$orderdata['postscript'] = $postscript;
			$orderdata['goods_amount'] = $stotalprice;
			$orderdata['order_amount'] = $totalprice;
			$orderdata['add_time'] = mktime();
			$this->App->insert('goods_order_info_daigou',$orderdata);
			$orderid = $this->App->iid();
			if($orderid > 0) foreach($goodslist as $row){
				$gid = $row['goods_id'];
				
				//$consignees = $_POST['consignee'][$gid];
				//$numbers = $_POST['goods_number'][$gid];
				//$moblies = $_POST['moblie'][$gid];
				//$provinces = $_POST['province'][$gid];
				//$citys = $_POST['city'][$gid];
				//$districts = $_POST['district'][$gid];
				//$addresss = $_POST['address'][$gid];
				//if(empty($consignees)) continue;
				
				
				//添加订单商品表
				$ds = array();
				$ds['order_id'] = $orderid;
				$ds['goods_id'] = $gid;
				$ds['brand_id'] = $row['brand_id'];
				$ds['goods_name'] = $row['goods_name'];
				$ds['goods_thumb'] = $row['goods_thumb'];
				$ds['goods_bianhao'] = $row['goods_bianhao'];
				$ds['goods_unit'] = $row['goods_unit'];
				$ds['goods_sn'] = $row['goods_sn'];
				$ds['market_price'] = $row['pifa_price'];
				$ds['goods_price'] = $row['price'];
				$ds['goods_number'] = $row['number']; //单个商品的总数量
				if(!empty($row['spec'])) $ds['goods_attr'] = implode("、",$row['spec']);
				$this->App->insert('goods_order_daigou',$ds);
				$rec_id = $this->App->iid();
			
				//添加订单地址表
				if($rec_id > 0){
					$useradd = $this->Session->read("useradd.{$gid}"); 
					$l = 0;
					if(!empty($useradd)) foreach($useradd as $k=>$addresss){
						$dd = array();
						$dd['consignee'] = $addresss['consignee'];
						$dd['goods_number'] = !($addresss['number']>0) ? 1 : $addresss['number'];
						$dd['moblie'] = $addresss['moblie'];
						//$dd['province'] = $provinces[$k];
						//$dd['city'] = $citys[$k];
						//$dd['district'] = $districts[$k];
						$dd['address'] = !empty($addresssall[$gid][$l]) ? $addresssall[$gid][$l] : $addresss['address'];
						$dd['rec_id'] = $rec_id;
						$this->App->insert('goods_order_address',$dd);
						++$l;
					}
				}
				
			}
		}
		$this->Session->write('cart',null);
		$this->Session->write('useradd',null);
		$this->jump(ADMIN_URL.'mycart.php?type=pay&oid='.$orderid);exit;
		
		exit;
	}
	//第三版(代购模式)
	function checkout2(){
		//$this->js('mycart.js');
		$this->title('确认订单 - '.$GLOBALS['LANG']['site_name']);
		$uid = $this->Session->read('User.uid');
		if(empty($uid)){ $this->jump(ADMIN_URL); exit;}
		$goodslist = $this->Session->read('cart');
		if(empty($goodslist)){
			$this->jump(ADMIN_URL,0,'购物车为空！'); exit;
		}
		$useradd = $this->Session->read('useradd');
		
		//查找收货地址 
		$sql = "SELECT tb1.*,tb2.region_name AS provinces,tb3.region_name AS citys,tb4.region_name AS districts FROM `{$this->App->prefix()}user_address` AS tb1";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb2 ON tb2.region_id = tb1.province";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb3 ON tb3.region_id = tb1.city";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb4 ON tb4.region_id = tb1.district";
		$sql .=" WHERE tb1.user_id='$uid' AND tb1.is_own='0' ORDER BY tb1.is_default DESC, tb1.address_id ASC LIMIT 1";
		$rt['userress'] = $this->App->findrow($sql);
				
		$rt['goodslist'] = array();
		$counts = 0;
		if(!empty($goodslist)){
			foreach($goodslist as $k=>$row){
				if($row['is_jifen_session']=='1'){
					$this->Session->write("cart.$k",null);
					$this->Session->write('useradd.$k',null); 
					continue; 
				}
				if(empty($useradd[$k]) || !isset($useradd[$k])){ //当前地址为空的时候写入session
					if(empty($rt['userress'])){
						$useradd[$k][1234567] = array('address'=>'','number'=>1,'consignee'=>'','moblie'=>'');
					}else{
						$us = $rt['userress']['provinces'].$rt['userress']['citys'].$rt['userress']['districts'].$rt['userress']['address'];
						$useradd[$k][1234567] = array('address'=>$us,'number'=>1,'consignee'=>$rt['userress']['consignee'],'moblie'=>$rt['userress']['mobile']);
					}
				}
				$counts +=$row['number'];
				$this->Session->write("cart.{$k}.spec.number",null);
			}
			
			//写入地址
			$this->Session->write('useradd',$useradd); 
			
			//计算地址数量
			/*foreach($useradd as $gid=>$item){
					if(!empty($item))foreach($item as $count){
						if(!isset($goodslist[$gid])){
						 $this->Session->write("useradd.$gid",null); 
						 continue;
						}
						++$counts;
					}
			}*/
			
			//计算折扣
			$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
			$rts = $this->App->findrow($sql);
			$off = 1;
			$sql = "SELECT is_subscribe FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
			$issubscribe = $this->App->findvar($sql); 
			$guanzhuoff = $rts['guanzhuoff'];
			$address3off = $rts['address3off'];
			$address2off = $rts['address2off'];
			if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
				$off = ($guanzhuoff/100);
			}
			if($counts >= 2 && $address2off < 101 && $address2off > 0){
				$off = ($address2off/100);
			}
			if($counts >= 3 && $address3off < 101 && $address3off > 0){
				$off = ($address3off/100) * $off;
			}
			
			//设置价格
			$useradd = $this->Session->read('useradd'); 
			foreach($goodslist as $k=>$row){
				//$this->Session->write("cart.{$k}.number",count($useradd[$k])); //当前商品的总数量
				
				$price = format_price($row['pifa_price'] * $off);
				$this->Session->write("cart.{$k}.price",$price);
				$this->Session->write("cart.{$k}.zprice",$price*$row['number']);
			}
		 }
		
		//支付方式
		$sql = "SELECT * FROM `{$this->App->prefix()}payment` WHERE enabled='1'";
		$rt['paymentlist'] = $this->App->find($sql);
		
				//配送方式
		$sql = "SELECT * FROM `{$this->App->prefix()}shipping`";
		$rt['shippinglist'] = $this->App->find($sql);
		
		
		$this->set('rt',$rt);
		if(!defined(NAVNAME)) define('NAVNAME', "确认订单");	
		$this->template('mycart_checkout');		
	}
	
	//
	function ajax_address_writesess($data=array()){
		$kk = $data['kk'];
		$gid = $data['gid'];
		$consignee = $data['consignee'];
		$moblie = $data['moblie'];
		$address = $data['address'];
		$number = $data['number'];
		$ud = array('address'=>$address,'number'=>$number,'consignee'=>$consignee,'moblie'=>$moblie);
		$this->Session->write("useradd.{$gid}.{$kk}",$ud);
		$n = $this->Session->read("cart.{$gid}.number");
		$this->Session->write("cart.{$gid}.number",(intval($n)+intval($number)));
	}
	//移除单个商品地址
	function ajax_remove_goods_address($data=array()){
		$kk = trim($data['kk']);
		$gid = intval($data['gid']);
		$number = intval($data['number']);
		$d = $this->Session->read("useradd.{$gid}.{$kk}");
		$this->Session->write("useradd.{$gid}.{$kk}",null);
		$n = $this->Session->read("cart.{$gid}.number");
		$this->Session->write("cart.{$gid}.number",(intval($n)-intval($number)));
	}
	//改变地址商品数量
	function ajax_change_goods_number($data=array()){
		$kk = $data['kk'];
		$gid = intval($data['gid']);
		$n = intval($data['n']); //当前地址的数量
		$ty = $data['ty'];
		$nums = $this->Session->read("cart.{$gid}.number");
		//echo 'gid:'.$gid.'kk:'.$kk.'nums:'.$nums.'ty:'.$ty.'n:'.$n;
		//exit;
		if($ty=='jian'){
			$this->Session->write("cart.{$gid}.number",(intval($nums)-1));
			$this->Session->write("useradd.{$gid}.{$kk}.number",$n);
		}else{
			$this->Session->write("cart.{$gid}.number",(intval($nums)+1));
			$this->Session->write("useradd.{$gid}.{$kk}.number",$n);
		}
	}
	
	//计算价格
	function ajax_jisuan_price(){
		//返回数据
		/*
		1、error:记录错误参数
		2、totalprice：总价格
		3、单个产品的数据：1、price:惊喜价,2、zprice:小计3、gid:产品ID
		*/
		$err = 0;
		$result = array('error' => $err, 'totalprice'=>'0.00','goods'=>'','message' => '');
		$json = Import::json();
		//die($json->encode($result));
		
		$goodslist = $this->Session->read('cart');
		$useradd = $this->Session->read('useradd');
		
		//计算地址数量
		/*$counts = 0;
		if(!empty($useradd)) foreach($useradd as $gid=>$item){
			if(!empty($item))foreach($item as $count){
				if(!isset($goodslist[$gid])){
				 $this->Session->write("useradd.$gid",null); 
				 continue;
				}
				++$counts;
			}
		}*/
		
		$counts = 0;
		if(!empty($goodslist))foreach($goodslist as $k=>$row){
			$counts +=$row['number'];
		}
			
			
		//计算折扣
		$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
		$rts = $this->App->findrow($sql);
		$off = 1;
		$sql = "SELECT is_subscribe FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
		$issubscribe = $this->App->findvar($sql); 
		$guanzhuoff = $rts['guanzhuoff'];
		$address3off = $rts['address3off'];
		$address2off = $rts['address2off'];
		if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
			$off = ($guanzhuoff/100);
		}
		if($issubscribe == '1' && $counts >= 2 && $address2off < 101 && $address2off > 0){
			$off = ($address2off/100);
		}
		if($issubscribe == '1' && $counts >= 3 && $address3off < 101 && $address3off > 0){
			$off = ($address3off/100) * $off;
		}
		
		//设置价格
		$useradd = $this->Session->read('useradd'); 
		$totalprice = 0;
		$grt = array();
		if(!empty($goodslist)) foreach($goodslist as $k=>$row){
			$price = format_price($row['pifa_price'] * $off);
			$this->Session->write("cart.{$k}.price",$price);
			$zprice = $price*$row['number'];
			$this->Session->write("cart.{$k}.zprice",$zprice); //单个产品的总价
			$totalprice +=$zprice;
			$grt[] = $price.','.$zprice.','.$row['goods_id'];
		}
		if(empty($grt)){
			$result['error'] = 1;
			$result['message'] = "非法错误";
			die($json->encode($result));
		}
		
		$result = array('error' => 0, 'totalprice'=>$totalprice,'goods'=>implode('|',$grt),'message' => '');
		die($json->encode($result));
	}
	
	function ajax_change_carval($data=array()){
		$kk = $data['kk'];
		$gid = $data['gid'];
		$ty = explode('[',$data['type']);
		$type = $ty[0];
		$val = $data['val'];
		switch($type){
			case 'consignee':
			$this->Session->write("useradd.{$gid}.{$kk}.consignee",$val);
			break;
			case 'moblie':
			$this->Session->write("useradd.{$gid}.{$kk}.moblie",$val);
			break;
			case 'address':
			$this->Session->write("useradd.{$gid}.{$kk}.address",$val);
			break;
		}
	}
	
	/******************************************/
   	function index(){
		$this->js('mycart.js');
		$this->title('我的购物车 - '.$GLOBALS['LANG']['site_name']);
		$uid = $this->Session->read('User.uid');
		if(empty($uid)){ $this->jump(ADMIN_URL); exit;}
		
		$hear[] = '<a href="'.ADMIN_URL.'">首页</a>';
		$hear[] = '<a href="'.ADMIN_URL.'mycart.php">我的购物车</a>';
		$rt['hear'] = implode('&nbsp;&gt;&nbsp;',$hear);
		
		//用户等级折扣
		$rt['discount'] = 100;
		$rank = $this->Session->read('User.rank');
		if($rank>0){
			$sql = "SELECT discount FROM `{$this->App->prefix()}user_level` WHERE lid='$rank' LIMIT 1";
			$rt['discount'] = $this->App->findvar($sql);
		}
		
		$active = $this->Session->read('User.active');
		//购物车商品
		$goodslist = $this->Session->read('cart'); 
		$rt['goodslist'] = array();
		if(!empty($goodslist)){
			foreach($goodslist as $k=>$row){
				$rt['goodslist'][$k] = $row;
				//$rt['goodslist'][$k]['url'] = get_url($row['goods_name'],$row['goods_id'],'product.php?id='.$row['goods_id'],'goods',array('product','index',$row['goods_id']));
				$rt['goodslist'][$k]['goods_thumb'] = SITE_URL.$row['goods_thumb'];
				$rt['goodslist'][$k]['goods_img'] = SITE_URL.$row['goods_img'];
				$rt['goodslist'][$k]['original_img'] = SITE_URL.$row['original_img'];
				
				//求出实际价格
				 $comd = array();
				 if(!empty($uid)&&$active=='1'){
				 	  $comd[] =  $row['qianggou_price'];
					  //同一折扣价格
					  if($rt['discount']>0){
					      	$comd[] = ($rt['discount']/100)*$row['market_price'];
					  }
					  if($row['shop_price']>0){ //普通会员价格
							$comd[] =  $row['shop_price']; //普通会员价格
					  }
	
				 }else{
						$comd[] = $row['market_price'];
				 }
				 
			     if($row['is_promote']=='1' && $row['promote_start_date'] < mktime() && $row['promote_end_date'] > mktime()){ //促销价格
					    $comd[] =  $row['promote_price'];
			     }
			     if($row['is_qianggou']=='1' && $row['qianggou_start_date'] < mktime() && $row['qianggou_end_date'] > mktime()){ //抢购价格
					    $comd[] =  $row['qianggou_price'];
			     }
					   
				 $onetotal = min($comd);
				 if(intval($onetotal)<=0) $onetotal = $row['market_price'];
				 $total +=($row['number']*$onetotal); //总价格
				 
			}
			unset($goodslist);
		}
		
		//赠品类型
/*		$fn = SYS_PATH.'data/goods_spend_gift.php';
		$spendgift = array();
		if(file_exists($fn) && is_file($fn)){
				include_once($fn);
		}
		$rt['gift_typesd'] = $spendgift;
		unset($spendgift);
		
		//商品赠品模块
		$minspend = array();
		if(!empty($rt['gift_typesd'])){
			foreach($rt['gift_typesd'] as $k=>$row){
				++$k;
				$minspend[$k] = $row['minspend'];
			}
			arsort($minspend);
		}
		$rt['gift_goods'] = array();
		$type = 0; 
		if(count($minspend)>0){
			$count = count($minspend);
			foreach($minspend as $t=>$val){  //已最高消费赠品为准
				if($total>=$val){
					$type = $t; //赠品等级
					break;
				}
			}
			unset($minspend);
			//赠品
			$rt['gift_goods_ids'] = array();
			if($type>0){
				$sql = "SELECT tb2.goods_id,tb1.type,tb2.goods_name,tb2.market_price,tb2.goods_sn ,tb2.goods_bianhao,tb2.goods_thumb  FROM `{$this->App->prefix()}goods_gift` AS tb1";
				$sql .=" LEFT JOIN `{$this->App->prefix()}goods` AS tb2 ON tb1.goods_id=tb2.goods_id";
				$sql .=" WHERE tb2.is_alone_sale='0' AND tb2.is_on_sale='1' AND tb2.is_check='1' AND tb2.is_delete='0' AND tb1.type='$type'";
				$gift_goods = $this->App->find($sql);
				if(!empty($gift_goods)){
					foreach($gift_goods as $k=>$row){
						$rt['gift_goods'][$k] = $row;
						//$rt['gift_goods'][$k]['url'] = get_url($row['goods_name'],$row['goods_id'],'product.php?id='.$row['goods_id'],'goods',array('product','index',$row['goods_id']));
						$rt['gift_goods_ids'][] = $row['goods_id']; //记录赠品的id
					}
					unset($gift_goods);
				}
			}

		}*/	
		
		//换购商品
		/*$sql = "SELECT goods_id,goods_name,market_price,shop_price,promote_price,goods_thumb,goods_img,is_jifen,need_jifen FROM `{$this->App->prefix()}goods` WHERE is_on_sale='1' AND is_check='1' AND is_alone_sale='1' AND is_jifen='1' ORDER BY sort_order ASC, goods_id DESC LIMIT 5";
		$rt['jifengoods'] = $this->App->find($sql);
		if(!empty($jifengoods)){
			foreach($jifengoods as $k=>$row){
				$rt['jifengoods'][$k] = $row;
				$rt['jifengoods'][$k]['url'] = get_url($row['goods_name'],$row['goods_id'],'product.php?id='.$row['goods_id'],'goods',array('product','index',$row['goods_id']));
			}
			unset($jifengoods);
		}*/
				
		if(!defined(NAVNAME)) define('NAVNAME', "购物车");		 
		$this->set('rt',$rt);
		$mb = $GLOBALS['LANG']['mubanid'] > 0 ? $GLOBALS['LANG']['mubanid'] : '';
		$this->template($mb.'/mycart_list');
	}
	//订单确认
	function checkout(){
		$this->action('common','checkjump');
		$this->title('确认订单 - '.$GLOBALS['LANG']['site_name']);
		$uid = $this->Session->read('User.uid');
		
		$goodslist = $this->Session->read('cart');
		if(empty($goodslist)){
			//$this->jump(ADMIN_URL,0,'购物车为空，请先加入购物车！');exit;
			if(!defined(NAVNAME)) define('NAVNAME', "去购物吧");		 
			$mb = $GLOBALS['LANG']['mubanid'] > 0 ? $GLOBALS['LANG']['mubanid'] : '';
			$this->template($mb.'/mycart_checkout_empty');
			exit;
		}
		/*$rt['user_ress'] = array();
		if(!empty($uid)){
			$sql = "SELECT tb1.*,tb2.region_name AS province,tb3.region_name AS city,tb4.region_name AS district FROM `{$this->App->prefix()}user_address` AS tb1";
			$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb2 ON tb2.region_id = tb1.province";
			$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb3 ON tb3.region_id = tb1.city";
			$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS tb4 ON tb4.region_id = tb1.district";
			$sql .=" WHERE tb1.user_id='$uid' ORDER BY tb1.type DESC, tb1.address_id ASC LIMIT 1";
			$rt['user_ress'] = $this->App->findrow($sql);
		}*/
		
		$rt['province'] = $this->action('user','get_regions',1);  //获取省列表
		
		$sql = "SELECT ua.*,rg.region_name AS provincename,rg1.region_name AS cityname,rg2.region_name AS districtname FROM `{$this->App->prefix()}user_address` AS ua";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg ON rg.region_id = ua.province";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg1 ON rg1.region_id = ua.city";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg2 ON rg2.region_id = ua.district WHERE ua.user_id='$uid' AND ua.is_own='0' GROUP BY ua.address_id";
		$rt['userress'] = $this->App->find($sql);
		
		//print_r($rt);
		//支付方式
		$sql = "SELECT * FROM `{$this->App->prefix()}payment` WHERE enabled='1'";
		$rt['paymentlist'] = $this->App->find($sql);
		
		//配送方式
		$sql = "SELECT * FROM `{$this->App->prefix()}shipping`";
		$rt['shippinglist'] = $this->App->find($sql);
		
		//用户等级折扣
		$rt['discount'] = 100;
		$rank = $this->App->findvar("SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
		if($rank>0){
			$sql = "SELECT discount FROM `{$this->App->prefix()}user_level` WHERE lid='$rank' LIMIT 1";
			$rt['discount'] = $this->App->findvar($sql);
		}
		
		//计算折扣
		$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
		$rts = $this->App->findrow($sql);
		$sql = "SELECT is_subscribe FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
		$issubscribe = $this->App->findvar($sql); 
		$guanzhuoff = $rts['guanzhuoff'];
		$address3off = $rts['address3off'];
		$address2off = $rts['address2off'];
		foreach($goodslist as $k=>$row){
			$counts = $row['number'];
			$off = 1;
			if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
				$off = ($guanzhuoff/100);
			}
			if($issubscribe == '1' && $counts >= 2 && $address2off < 101 && $address2off > 0){
				$off = ($address2off/100);
			}
			if($issubscribe == '1' && $counts >= 3 && $address3off < 101 && $address3off > 0){
				$off = ($address3off/100) * $off;
			}
			
			$price = format_price($row['pifa_price'] * $off);
			$this->Session->write("cart.{$k}.price",$price);
		}	
		
		/*//我的积分
		$sql = "SELECT SUM(points) FROM `{$this->App->prefix()}user_point_change` WHERE uid='$uid'";
		$rt['mypoints'] = $this->App->findvar($sql);
		
		$active = $this->Session->read('User.active');
		//购物车商品
		if(!empty($rt['goodslist'])){
			foreach($rt['goodslist'] as $k=>$row){
				//求出实际价格
				 $comd = array();
				 $comd[] =  $row['pifa_price'];
				 $comd[] =  $row['shop_price'];
			     if($row['is_promote']=='1' && $row['promote_start_date'] < mktime() && $row['promote_end_date'] > mktime()){ //促销价格
					    $comd[] =  $row['promote_price'];
			     }
			     if($row['is_qianggou']=='1' && $row['qianggou_start_date'] < mktime() && $row['qianggou_end_date'] > mktime()){ //抢购价格
					    $comd[] =  $row['qianggou_price'];
			     }
					   
				 $onetotal = min($comd);
				 $total +=($row['number']*$onetotal); //总价格
				 
			}
		}
		
		//赠品类型
		$fn = SYS_PATH.'data/goods_spend_gift.php';
		$spendgift = array();
		if(file_exists($fn) && is_file($fn)){
			include_once($fn);
		}
		$rt['gift_typesd'] = $spendgift;
		unset($spendgift);
		
		//商品赠品模块
		$minspend = array();
		if(!empty($rt['gift_typesd'])){
			foreach($rt['gift_typesd'] as $k=>$row){
				++$k;
				$minspend[$k] = $row['minspend'];
			}
			arsort($minspend);
		}
		$rt['gift_goods'] = array();
		$type = 0; 
		if(count($minspend)>0){
			$count = count($minspend);
			foreach($minspend as $t=>$val){  //已最高消费赠品为准
				if($total>=$val){
					$type = $t; //赠品等级
					break;
				}
			}
			unset($minspend);
			//赠品
			$rt['gift_goods_ids'] = array();
			if($type>0){
				$sql = "SELECT tb2.goods_id,tb1.type,tb2.goods_name,tb2.market_price,tb2.goods_sn ,tb2.goods_bianhao,tb2.goods_thumb  FROM `{$this->App->prefix()}goods_gift` AS tb1";
				$sql .=" LEFT JOIN `{$this->App->prefix()}goods` AS tb2 ON tb1.goods_id=tb2.goods_id";
				$sql .=" WHERE tb2.is_alone_sale='0' AND tb2.is_check='1' AND tb2.is_on_sale='1' AND tb2.is_delete='0' AND tb1.type='$type'";
				$gift_goods = $this->App->find($sql);
				if(!empty($gift_goods)){
					foreach($gift_goods as $k=>$row){
						$rt['gift_goods_ids'][] = $row['goods_id']; //记录赠品的id
					}
					unset($gift_goods);
				}
			}

		}	*/
		if(!defined(NAVNAME)) define('NAVNAME', "确认订单");		 
		$this->set('rt',$rt);
		$mb = $GLOBALS['LANG']['mubanid'] > 0 ? $GLOBALS['LANG']['mubanid'] : '';
		$this->template($mb.'/mycart_checkout');
	}
	
	/*
	确认订单提交页面
	*/
	function confirm(){
		$this->title('我的购物车 - 订单号 - '.$GLOBALS['LANG']['site_name']);
		$uid = $this->Session->read('User.uid');
		if(empty($uid)){ $this->jump(ADMIN_URL.'user.php?act=login',0,'请先登录！'); exit;}
		
		if(isset($_POST)&&!empty($_POST)){
			//购物车商品
			$cartlist = $this->Session->read('cart');
			if(empty($cartlist)){
				$this->jump(ADMIN_URL.'mycart.php',0,'购物车商品为空!'); exit;
			}
			
			$shipping_id = isset($_POST['shipping_id']) ? $_POST['shipping_id'] : 0;
			$userress_id = isset($_POST['userress_id']) ? $_POST['userress_id'] : 0;
			$dd = array();
			if(!($userress_id > 0)){  //如果是提交添加地址的，需要添加到user_address表
				//添加收货地址
				$dd['user_id'] = $uid;
				$dd['consignee'] = $_POST['consignee'];
				if(empty($dd['consignee'])){
					$this->jump(ADMIN_URL.'mycart.php?type=checkout',0,'收货人不能为空！'); exit ;
				}
				$dd['country'] = 1;
				$dd['province'] = $_POST['province'];
				$dd['city'] = $_POST['city'];
				$dd['district'] = $_POST['district'];
				$dd['address'] = $_POST['address'];
				if(empty($dd['province']) || empty($dd['city']) || empty($dd['district']) ||empty($dd['address'])){
					$this->jump(ADMIN_URL.'mycart.php?type=checkout',0,'收货地址不能为空！'); exit ;
				}
			
				$dd['mobile'] = $_POST['mobile'];
				$dd['is_default'] = '1';
				$dd['shoppingname'] = $shipping_id;
				$this->App->update('user_address',array('is_default'=>'0'),'user_id',$uid);
				$this->App->insert('user_address',$dd); //添加到地址表
				$userress_id  = $this->App->iid();
				
				if(!($userress_id>0)){
					$this->jump(ADMIN_URL.'mycart.php?type=checkout',0,'非法的收货地址！'); exit ;
				}
			}
			
			$pay_id = isset($_POST['pay_id']) ? $_POST['pay_id'] : 0;
			$pay_name = $this->App->findvar("SELECT pay_name FROM `{$this->App->prefix()}payment` WHERE pay_id='$pay_id' LIMIT 1");

			$postscript = isset($_POST['postscript']) ? $_POST['postscript'] : "";
			if(empty($dd)){
				//收货信息
				$sql = "SELECT * FROM `{$this->App->prefix()}user_address` WHERE address_id='$userress_id' LIMIT 1";
				$user_ress = $this->App->findrow($sql);
				if(empty($user_ress)){ $this->jump(ADMIN_URL.'mycart.php?type=checkout',0,'非法收货地址！'); exit ;}
			}else{
				$user_ress = $dd;
				unset($dd);
			}
			$shipping_name = $this->App->findvar("SELECT shipping_name FROM `{$this->App->prefix()}shipping` WHERE shipping_id='$shipping_id' LIMIT 1");
			
			//添加信息到数据表
			$orderdata['order_sn']= date('Y',mktime()).mktime();
			$orderdata['user_id']= $uid ? $uid : 0;
			
			$daili_uid = $this->return_daili_uid($uid);
			$orderdata['parent_uid'] = $daili_uid ?  $daili_uid : 0;
			
			//查找二级、三级代理
			if($daili_uid > 0){
				$sql = "SELECT p1_uid,p2_uid FROM `{$this->App->prefix()}user_tuijian_fx` WHERE uid ='$daili_uid' LIMIT 1";
				$pr = $this->App->findrow($sql);
				$parent_uid = isset($pr['p1_uid']) ? $pr['p1_uid'] : 0;
				$orderdata['parent_uid2'] = $parent_uid >0&&$parent_uid!=$daili_uid ? $parent_uid : '0'; //上二级
				
				$parent_uid = isset($pr['p2_uid']) ? $pr['p2_uid'] : 0;
				$orderdata['parent_uid3'] = $parent_uid >0&&$parent_uid!=$daili_uid ? $parent_uid : '0'; //上三级
			}
			$orderdata['consignee'] = $user_ress['consignee'] ? $user_ress['consignee'] : "";
			$orderdata['province'] = $user_ress['province'] ? $user_ress['province'] : 0;
			$orderdata['city'] = $user_ress['city'] ? $user_ress['city'] : 0;
			$orderdata['district'] = $user_ress['district'] ? $user_ress['district'] : 0;
			$orderdata['address'] = $user_ress['address'] ? $user_ress['address'] : "";
			$orderdata['mobile']  = $user_ress['mobile'] ? $user_ress['mobile'] : "";
			$orderdata['shipping_id']  = $shipping_id;
			$orderdata['shipping_name']  = $shipping_name;
			if(isset($_POST['best_time']) && !empty($_POST['best_time'])){
				$orderdata['best_time']  = trim($_POST['best_time']);
			}
			$orderdata['pay_id']  = $pay_id ? $pay_id : 0;
			$orderdata['pay_name']  = $pay_name ? $pay_name : "";
			$orderdata['postscript']  = $postscript;
						
			//用户等级折扣
			$discount = 100;
			$rank = $this->App->findvar("SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
			if($rank>0){
				$sql = "SELECT discount FROM `{$this->App->prefix()}user_level` WHERE lid='$rank' LIMIT 1";
				$discount = $this->App->findvar($sql);
			}
		
			$k=0;
			$total = 0;
			$jifen_onetotal = 0;
			
			//返回总价
			$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
			$rts = $this->App->findrow($sql);
			$sql = "SELECT is_subscribe FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
			$issubscribe = $this->App->findvar($sql); 
			$guanzhuoff = $rts['guanzhuoff'];
			$address3off = $rts['address3off'];
			$address2off = $rts['address2off'];
				
			foreach($cartlist as $row){
				 $data[$k]['goods_id'] = $row['goods_id'];
				 $data[$k]['brand_id'] = $row['brand_id'];
				 $data[$k]['goods_name'] = $row['goods_name'];
				 $data[$k]['goods_bianhao'] = $row['goods_bianhao'];
				 $data[$k]['goods_thumb'] = $row['goods_thumb'];
				 $data[$k]['goods_sn'] = $row['goods_sn'];
				 $data[$k]['goods_number'] = $row['number'];
				 if(!empty($row['buy_more_best'])){
				 	$data[$k]['buy_more_best'] = $row['buy_more_best']; //买多送多，如：10送1
				 }
				 
				//折扣
				$counts = $row['number'];
				$off = 1;
				if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
					$off = ($guanzhuoff/100);
				}
				if($issubscribe == '1' && $counts >= 2 && $address2off < 101 && $address2off > 0){
					$off = ($address2off/100);
				}
				if($issubscribe == '1' && $counts >= 3 && $address3off < 101 && $address3off > 0){
					$off = ($address3off/100) * $off;
				}
				
				 // $mprice = $row['pifa_price'] > 0 ? $row['pifa_price'] : $row['shop_price'];
				 $mprice = $row['shop_price'];
				 $onetotal = format_price($row['pifa_price'] * $off);
				//$prices += format_price($onetotal*$row['number']);
		 		 $mprices += $mprice * $row['number'];
				 $total += $row['number']*$onetotal;
				 if($row['takemoney1'] > 0) $data[$k]['takemoney1'] = $row['takemoney1']; //佣金
				  if($row['takemoney2'] > 0) $data[$k]['takemoney2'] = $row['takemoney2']; //佣金
				   if($row['takemoney3'] > 0) $data[$k]['takemoney3'] = $row['takemoney3']; //佣金
				 $data[$k]['market_price'] = $mprice;
				 $data[$k]['goods_price'] = $onetotal; //实际价格
				 $data[$k]['goods_attr'] = !empty($row['spec']) ? $row['goods_brief'].implode("<br />",$row['spec']) : $row['goods_brief'];
				 $data[$k]['goods_unit'] = $row['goods_unit'];
				 
				 if(isset($_POST['confirm_jifen']) && intval($_POST['confirm_jifen'])>0){
				 	if($row['is_jifen_session']=='1'){
				 		$data[$k]['from_jifen'] = $row['need_jifen']*$row['number'];
						$jifen_onetotal += $s;
					}
				 }
				 $k++;
				 
				 if(!empty($row['gifts'])){
				 		 $data[$k]['goods_id'] = $row['gifts']['goods_id'];
						 $data[$k]['brand_id'] = $row['gifts']['brand_id'];
						 $data[$k]['goods_name'] = '<span style="color:#FE0000">[赠品]</span>'.$row['gifts']['goods_name'];
						 $data[$k]['goods_bianhao'] = $row['gifts']['goods_bianhao'];
						 $data[$k]['goods_thumb'] = $row['goods_thumb'];
						 $data[$k]['goods_sn'] = $row['gifts']['goods_sn'].'-gift';
						 $data[$k]['goods_number'] = $row['gifts']['number'];
						 $data[$k]['market_price'] = $row['gifts']['shop_price']; //原始价格
						 $data[$k]['goods_price'] = $row['gifts']['shop_price'];  //实际价格
				 		 $data[$k]['goods_attr'] = !empty($row['gifts']['spec']) ? implode("<br />",$row['gifts']['spec']) : "";
						 $data[$k]['goods_unit'] = $row['gifts']['goods_unit'];
						 $data[$k]['is_gift'] = 1;
						 $k++;
				 }
			}
			
			
			//价格为0 不允许购物
			if(!($total>0)){
				$this->jump(ADMIN_URL.'mycart.php?type=checkout',0,'意外错误！'); exit ;
				exit;
			}
			//邮费
			$d = array('userress_id'=>$userress_id,'shopping_id'=>$shipping_id);
			$fr = $this->ajax_jisuan_shopping($d,'cart'); //邮费
			
			$n = ($fr>0) ? format_price($fr) : '0';
			$orderdata['goods_amount']  = format_price($mprices);
			$orderdata['order_amount']  = format_price($total*($discount/100)); //优惠后的价格,也就是最终支付价格
			//$orderdata['offprice']  = $moneyinfo['offmoney']; 
			$orderdata['add_time'] = mktime();
			$orderdata['shipping_fee'] = $n; //邮费
			
			//是否用积分兑换商品
			if(isset($_POST['confirm_jifen']) && $_POST['confirm_jifen']>0 && intval($jifen_onetotal) > 0){
				$orderdata['goods_amount'] = $orderdata['goods_amount'] - $jifen_onetotal;
				$orderdata['order_amount'] = $orderdata['order_amount'] - $jifen_onetotal;
				$this->App->insert('user_point_change',array('time'=>mktime(),'changedesc'=>"用积分兑换商品",'uid'=>$uid,'points'=>-intval($_POST['confirm_jifen'])));
			}
			
			$orderdata['bonus_count'] = 0;
			$orderdata['bonus_time'] = '';
			if($this->App->insert('goods_order_info',$orderdata)){ //订单成功后
				$iid = $this->App->iid();
				
				foreach($data as $kk=>$rows){
					$rows['order_id'] = $iid;
					
					$this->App->insert('goods_order',$rows);  //添加订单商品表
					
					//更新销售数量
/*					$gid = $rows['goods_id'];
					$num = $rows['goods_number']; //look 添加 库存量在购买成功后减少
					if($gid>0 && $rows['is_gift']!='1'){
						$sql = "UPDATE `{$this->App->prefix()}goods` SET `sale_count` = `sale_count`+1 , `goods_number` = `goods_number`- '$num' WHERE goods_id = '$gid'";
						$this->App->query($sql);
					}*/
				}
				
				//$this->_return_money($orderdata['order_sn']);
				
				//派发红包
				$sql = "SELECT bonus_id FROM `{$this->App->prefix()}bonus_list` WHERE bonus_type_id='6' AND user_id='$uid' LIMIT 1";
				$bid = $this->App->findvar($sql);
				if(!($bid > 0)){
					$sql = "SELECT bonus_id FROM `{$this->App->prefix()}bonus_list` WHERE bonus_type_id='6' AND user_id='0' ORDER BY bonus_id ASC LIMIT 1";
					$bid = $this->App->findvar($sql);
					if($bid > 0){
						if($this->App->update('bonus_list',array('user_id'=>$uid,'order_id'=>$iid),'bonus_id',$bid)){
							$appid = $this->Session->read('User.appid');
							if(empty($appid)) $appid = isset($_COOKIE[CFGH.'USER']['APPID']) ? $_COOKIE[CFGH.'USER']['APPID'] : '';
							$appsecret = $this->Session->read('User.appsecret');
							if(empty($appsecret)) $appsecret = isset($_COOKIE[CFGH.'USER']['APPSECRET']) ? $_COOKIE[CFGH.'USER']['APPSECRET'] : '';
				
							//发送用户通知
							$pr = $this->App->findrow("SELECT wecha_id,nickname FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1");
							$pwecha_id = isset($pr['wecha_id']) ? $pr['wecha_id'] : '';
							$nickname = isset($pr['nickname']) ? $pr['nickname'] : '';
							if(!empty($pwecha_id)){
								$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>$appid,'appsecret'=>$appsecret,'nickname'=>$nickname),'sendgift');
							}
						}
					}
				}
				
				$this->Session->write('cart',"");
				//发送通知
				$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$uid' AND is_subscribe='1' LIMIT 1");
				if(!empty($pwecha_id)){
					$this->action('api','send',array('openid'=>$pwecha_id,'appid'=>'','appsecret'=>'','nickname'=>''),'orderconfirm');
				}
				
				//通知商家
				$wid = $this->App->findvar("SELECT wid FROM `{$this->App->prefix()}userconfig` WHERE type='basic' LIMIT 1");
				if($wid > 0){
					$pwecha_id = $this->App->findvar("SELECT wecha_id FROM `{$this->App->prefix()}user` WHERE user_id='$wid' AND is_subscribe='1' LIMIT 1");
					if(!empty($pwecha_id)) $this->action('api','send',array('openid'=>$pwecha_id,'appid'=>'','appsecret'=>'','nickname'=>''),'orderconfirm_toshop');
				}
				
				$this->jump(ADMIN_URL.'mycart.php?type=pay2&oid='.$iid);exit;
				
				
				$rt['order_sn'] = $orderdata['order_sn'];
				$rt['shipping_name'] = $shipping_name;
				$rt['pay_name'] = $pay_name;
				$rt['total'] = format_price($orderdata['order_amount']);
				$rt['shipping_fee'] = $n; //邮费
				
				$rts['pay_id'] = $pay_id;
				$rts['order_sn'] = $rt['order_sn'];
				$rts['order_amount'] = $rt['total'];
				$rts['username'] = $orderdata['consignee'];
				$rts['logistics_fee'] = $rt['shipping_fee'];
				
				$sql = "SELECT ua.address,ua.zipcode,ua.tel,ua.mobile,rg.region_name AS provincename,rg1.region_name AS cityname,rg2.region_name AS districtname FROM `{$this->App->prefix()}user_address` AS ua";
				$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg ON rg.region_id = ua.province";
				$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg1 ON rg1.region_id = ua.city";
				$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg2 ON rg2.region_id = ua.district WHERE ua.address_id='$userress_id' LIMIT 1";
				$userress = $this->App->findrow($sql);
		
				$rts['address'] = $userress['provincename'].'&nbsp;'.$userress['cityname'].'&nbsp;'.$userress['districtname'].'&nbsp;'.$userress['address'];
				$rts['zip'] = !empty($userress['zipcode']) ? $userress['zipcode'] : $orderdata['zipcode'];
				$rts['phone'] = !empty($userress['tel']) ? $userress['tel'] : $orderdata['tel'];
				$rts['mobile'] = !empty($userress['mobile']) ? $userress['mobile'] : $orderdata['mobile'];
				$this->Session->write('cart',"");
				$this->_alipayment($rts);
				
				exit;

			
				$this->set('rt',$rt);
				$this->Session->write('cart',"");
				$this->template('mycart_submit_order');
				exit;
			}else{
				$this->jump(ADMIN_URL.'mycart.php',0,'你的订单没有提交成功，我们是尽快处理出现问题！'); exit;
			}
			
		}else{
			$this->App->write('cart',"");
			$this->jump(ADMIN_URL.'mycart.php');
		}
		$this->App->write('cart',"");
		$this->jump(ADMIN_URL.'mycart.php',0,'意外错误，我们是尽快处理出现问题！'); exit;
	}
	
	//返佣缓存
	function _return_money($order_sn=''){
		@set_time_limit(300); //最大运行时间

		//购买用户返积分
		
		//上三级返佣金
		
		//送佣金，找出推荐用户
		$pu = $this->App->findrow("SELECT user_id,daili_uid,parent_uid,parent_uid2,parent_uid3,goods_amount,order_amount,order_sn,pay_status,order_id FROM `{$this->App->prefix()}goods_order_info` WHERE order_sn='$order_sn' LIMIT 1");
		$parent_uid = isset($pu['parent_uid']) ? $pu['parent_uid'] : 0; //分享者
		$parent_uid2 = isset($pu['parent_uid2']) ? $pu['parent_uid2'] : 0; //分享者
		$parent_uid3 = isset($pu['parent_uid3']) ? $pu['parent_uid3'] : 0; //分享者
		
		$daili_uid = isset($pu['daili_uid']) ? $pu['daili_uid'] : 0; //代理
		$moeys = isset($pu['order_amount']) ? $pu['order_amount'] : 0; //实际消费
		$uid = isset($pu['user_id']) ? $pu['user_id'] : 0;
		$pay_status = isset($pu['pay_status']) ? $pu['pay_status'] : 0;
		
		$order_id = isset($pu['order_id']) ? $pu['order_id'] : 0;
		
		$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//用户配置信息
		$rts = $this->App->findrow($sql);
		
			
		if(!empty($order_sn)){
			//计算每个产品的佣金
			$sql = "SELECT takemoney1,takemoney2,takemoney3,goods_number FROM `{$this->App->prefix()}goods_order` WHERE order_id='$order_id'";
			$moneys = $this->App->find($sql);
		
			$record = array();
			$moeys = 0;
			//一级返佣金
			if($parent_uid > 0){
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank != '1'){ //不是普通会员
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
						if($rank=='12'){ //普通分销商
							if($rts['ticheng180_1'] < 101 && $rts['ticheng180_1'] > 0){
								$off = $rts['ticheng180_1']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney1'] > 0){
										$moeys +=$row['takemoney1'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='11'){//高级分销商
							if($rts['ticheng180_h1_1'] < 101 && $rts['ticheng180_h1_1'] > 0){
								$off = $rts['ticheng180_h1_1']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney2'] > 0){
										$moeys +=$row['takemoney2'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='10'){//特权分销商
							if($rts['ticheng180_h2_1'] < 101 && $rts['ticheng180_h2_1'] > 0){
								$off = $rts['ticheng180_h2_1']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney3'] > 0){
										$moeys +=$row['takemoney3'] * $row['goods_number'] * $off;
									}
								}
							}
						}
						
					//}

					
					if($moeys > 0) $moeys = format_price($moeys);
					if(!empty($moeys)){
						$thismonth = date('Y-m-d',mktime());
						$thism = date('Y-m',mktime());
						//$this->App->insert('user_money_change_cache',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid));
						$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid));
					}
				}
			}
			
			$moeys = 0;
			//二级返佣金
			if($parent_uid2 > 0){
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid2' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank != '1'){ //不是普通会员
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid2' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;
						if($rank=='12'){ //普通分销商
							if($rts['ticheng180_2'] < 101 && $rts['ticheng180_2'] > 0){
								$off = $rts['ticheng180_2']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney1'] > 0){
										$moeys +=$row['takemoney1'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='11'){//高级分销商
							if($rts['ticheng180_h1_2'] < 101 && $rts['ticheng180_h1_2'] > 0){
								$off = $rts['ticheng180_h1_2']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney2'] > 0){
										$moeys +=$row['takemoney2'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='10'){//特权分销商
							if($rts['ticheng180_h2_2'] < 101 && $rts['ticheng180_h2_2'] > 0){
								$off = $rts['ticheng180_h2_2']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney3'] > 0){
										$moeys +=$row['takemoney3'] * $row['goods_number'] * $off;
									}
								}
							}
						}
						
					//}
					if($moeys > 0) $moeys = format_price($moeys);
					if(!empty($moeys)){
						$thismonth = date('Y-m-d',mktime());
						$thism = date('Y-m',mktime());
						//$this->App->insert('user_money_change_cache',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid2));
						$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid2));
					}
				}
			}
			
			$moeys = 0;
			//三级返佣金
			if($parent_uid3 > 0){
				$sql = "SELECT user_rank FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid3' LIMIT 1";
				$rank = $this->App->findvar($sql);
				if($rank != '1'){ //不是普通会员
					$sql = "SELECT types FROM `{$this->App->prefix()}user` WHERE user_id='$parent_uid3' LIMIT 1";
					$types = $this->App->findvar($sql);
					
					$off = 0;

						if($rank=='12'){ //普通分销商
							if($rts['ticheng180_3'] < 101 && $rts['ticheng180_3'] > 0){
								$off = $rts['ticheng180_3']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney1'] > 0){
										$moeys +=$row['takemoney1'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='11'){//高级分销商
							if($rts['ticheng180_h1_3'] < 101 && $rts['ticheng180_h1_3'] > 0){
								$off = $rts['ticheng180_h1_3']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney2'] > 0){
										$moeys +=$row['takemoney2'] * $row['goods_number'] * $off;
									}
								}
							}
						}elseif($rank=='10'){//特权分销商
							if($rts['ticheng180_h2_3'] < 101 && $rts['ticheng180_h2_3'] > 0){
								$off = $rts['ticheng180_h2_3']/100;
								if(!empty($moneys))foreach($moneys as $row){
									if($row['takemoney3'] > 0){
										$moeys +=$row['takemoney3'] * $row['goods_number'] * $off;
									}
								}
							}
						}
						
					if($moeys > 0) $moeys = format_price($moeys);
					if(!empty($moeys)){
						$thismonth = date('Y-m-d',mktime());
						$thism = date('Y-m',mktime());
						//$this->App->insert('user_money_change_cache',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid3));
						$this->App->insert('user_money_change',array('buyuid'=>$uid,'order_sn'=>$order_sn,'thismonth'=>$thismonth,'thism'=>$thism,'money'=>$moeys,'changedesc'=>'购买商品返佣金','time'=>mktime(),'uid'=>$parent_uid3));
					}
				}
			}//end if
			
		}
		
	}
	
	//快速支付
	function fastcheckout(){
		$oid = $_POST['order_id'];
		$uid = $this->Session->read('User.uid');
		$sql = "SELECT * FROM `{$this->App->prefix()}goods_order_info` WHERE pay_status = '0' AND order_id='$oid'";	
		$rt = $this->App->findrow($sql);
		
		if(empty($rt)){
			$this->jump(ADMIN_URL,0,'非法支付提交！'); exit;
		}
		
		$rts['pay_id'] = $rt['pay_id'];
		$rts['order_sn'] = $rt['order_sn'];
		$rts['order_amount'] = $rt['order_amount'];
		$rts['username'] = $orderdata['consignee'];
		$rts['logistics_fee'] = $rt['shipping_fee'];
		
		
		$sql = "SELECT ua.address,ua.zipcode,ua.tel,ua.mobile,rg.region_name AS provincename,rg1.region_name AS cityname,rg2.region_name AS districtname FROM `{$this->App->prefix()}goods_order_info` AS ua";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg ON rg.region_id = ua.province";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg1 ON rg1.region_id = ua.city";
		$sql .=" LEFT JOIN `{$this->App->prefix()}region` AS rg2 ON rg2.region_id = ua.district WHERE ua.order_id='$oid' LIMIT 1";
		$userress = $this->App->findrow($sql);

		$rts['address'] = $userress['provincename'].'&nbsp;'.$userress['cityname'].'&nbsp;'.$userress['districtname'].'&nbsp;'.$userress['address'];
		$rts['zip'] = !empty($userress['zipcode']) ? $userress['zipcode'] : $orderdata['zipcode'];
		$rts['phone'] = !empty($userress['tel']) ? $userress['tel'] : $orderdata['tel'];
		$rts['mobile'] = !empty($userress['mobile']) ? $userress['mobile'] : $orderdata['mobile'];
				
		$this->_alipayment($rts);
		unset($rt);
		exit;
	}
		
	//ajax更新购物的价格
	function ajax_change_price($data=array()){
		$json = Import::json();
		$id = $data['id'];
		$number = $data['number'];
		$shipping_id = $data['shipping_id'];
		$userress_id = $data['userress_id'];
		
		$maxnumber = $this->Session->read("cart.{$id}.goods_number");
		if($number>$maxnumber){
			$result = array('error' => 2, 'message' => "购买数量已经超过了库存，你最大只能购买:".$maxnumber);
			die($json->encode($result));
		}
		
		//是否是赠品，如果是赠品，那么只能添加一件，不能重复添加
		$is_alone_sale = $this->Session->read("cart.{$id}.is_alone_sale");
		if(!empty($is_alone_sale)){
			$this->Session->write("cart.{$id}.number",$number);
		}
		//end 赠品
		
		$uid = $this->Session->read('User.uid');
		
		$cartlist = $this->Session->read('cart');
		
		//返回总价
		$sql = "SELECT * FROM `{$this->App->prefix()}userconfig` LIMIT 1";//配置信息
		$rts = $this->App->findrow($sql);
		$sql = "SELECT is_subscribe FROM `{$this->App->prefix()}user` WHERE user_id='$uid' LIMIT 1";
		$issubscribe = $this->App->findvar($sql); 
		$guanzhuoff = $rts['guanzhuoff'];
		$address3off = $rts['address3off'];
		$address2off = $rts['address2off'];
		$prices = 0;
		$thisprice = 0;
		foreach($cartlist as $k=>$row){
			$counts = $row['number'];
			$off = 1;
			if($issubscribe == '1' && $guanzhuoff < 101 && $guanzhuoff > 0){
				$off = ($guanzhuoff/100);
			}
			if($issubscribe == '1' && $counts >= 2 && $address2off < 101 && $address2off > 0){
				$off = ($address2off/100);
			}
			if($issubscribe == '1' && $counts >= 3 && $address3off < 101 && $address3off > 0){
				$off = ($address3off/100) * $off;
			}
			$price = format_price($row['pifa_price'] * $off);
			if($id==$k){
				$thisprice = $price;
			}
			$prices += $price * $row['number'];
		}
		$prices = format_price($prices);
		
		unset($cartlist);
		//邮费
		$f = $this->ajax_jisuan_shopping(array('shopping_id'=>$shipping_id,'userress_id'=>$userress_id),'cart');
		$f = empty($f) ? '0' : $f;
		unset($cartlist);
		$result = array('error' => 0, 'message' => '1','prices'=>$prices,'thisprice'=>$thisprice,'freemoney'=>$f);
		die($json->encode($result));
	}
	
	//改变使用积分换取商品
	function ajax_change_jifen($is_confirm='true'){
		$uid = $this->Session->read('User.uid');
		$active = $this->Session->read('User.active');
		
		//用户等级折扣
		$discount = 100;
		$rank = $this->Session->read('User.rank');
		if($rank>0){
			$sql = "SELECT discount FROM `{$this->App->prefix()}user_level` WHERE lid='$rank' LIMIT 1";
			$discount = $this->App->findvar($sql);
		}
		
		$cartlist = $this->Session->read('cart');
		$total = 0;
		if(!empty($cartlist)){
			foreach($cartlist as $row){
				 $comd = array();
				  if(!empty($uid)&&$active=='1'){
						if($discount>0){
							$comd[] = ($discount/100)*$row['market_price'];
						}
					   if($row['shop_price']>0){ //普通会员价格
							$comd[] =  $row['shop_price']; //普通会员价格
					   }
	
				  }else{
						$comd[] = $row['market_price'];
				  }
	
				 if($row['is_promote']=='1' && $row['promote_start_date'] < mktime() && $row['promote_end_date'] > mktime()){ //促销价格
					    $comd[] =  $row['promote_price'];
			     }
			   
			     if($row['is_qianggou']=='1' && $row['qianggou_start_date'] < mktime() && $row['qianggou_end_date'] > mktime()){ //抢购价格
					    $comd[] =  $row['qianggou_price'];
			     }
				 
				//$onetotal = min($comd);
				$onetotal = $row['pifa_price'];
				$total +=($row['number']*$onetotal);
				
				//if($row['is_jifen_session']=='1'){
					$jifen_onetotal += $row['number']*$onetotal;
				//}
			}
		}
		unset($cartlist);
		//我的积分
		$sql = "SELECT SUM(points) FROM `{$this->App->prefix()}user_point_change` WHERE uid='$uid'";
		$mypoints = $this->App->findvar($sql);
		
		if($is_confirm=='true'){
			if($mypoints >= $jifen_onetotal ){
			echo $total-$jifen_onetotal;
			}else{
			echo $total-$mypoints;
			}
		}else{
			echo $total;
		}
		exit;
	}
	
	//ajax计算邮费
	function ajax_jisuan_shopping($data=array(),$tt='ajax'){
		$shopping_id = isset($data['shopping_id']) ? $data['shopping_id']: 0;
		$userress_id = isset($data['userress_id']) ? $data['userress_id']: 0;
		
		if(!($userress_id>0)){
			if($tt=='ajax'){
				die("请选择一个收货地址！");
			}else{
				return "0";
			}
		}
		if(!($shopping_id>0)){
			if($tt=='ajax'){
				die("请选择一个配送方式！");
			}else{
				return "0";
			}
		}
		
		$sql = "SELECT country,province,city,district FROM `{$this->App->prefix()}user_address` WHERE address_id='$userress_id'";
		$ids = $this->App->findrow($sql);
		if(empty($ids)){
			if($tt=='ajax'){
				die("请先设置一个收货地址！");
			}else{
				return "请先设置一个收货地址！";
			}
		}
		
		$cartlist = $this->Session->read('cart');
		$items = 0;
		$weights = 0;
		if(!empty($cartlist)){
			foreach($cartlist as $row){
				if($row['is_shipping']=='1' || $row['is_alone_sale']=='0') continue;
				$items +=$row['number'];
				$weights +=$row['goods_weight'];
			}
		}
		$weights = $weights*$items;
		$sql = "SELECT * FROM `{$this->App->prefix()}shipping_area` WHERE shipping_id='$shopping_id'";
		$area_rt = $this->App->find($sql);
		if(!empty($area_rt)){
			foreach($area_rt as $row){
				if(!empty($row['configure'])){
					$configure = json_decode($row['configure']);
					if(is_array($configure)){
						$type = $row['type'];
						$item_fee = $row['item_fee'];
						$weight_fee = $row['weight_fee'];
						$step_weight_fee = $row['step_weight_fee'];
						$step_item_fee = $row['step_item_fee'];
						$max_money = $row['max_money'];
						   
						if(in_array($ids['district'],$configure)){ //区
							if($type=='item'){  //件计算
								$zyoufei = $item_fee + (($items-1)*$step_item_fee);
								if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
								if($tt=='ajax'){
									die($row['shipping_area_name'].'+'.$zyoufei);
								}else{
									return $zyoufei;
								}
							}elseif($type=='weight'){ //重量计算
								if($weights>500){
								 	$zyoufei = $weight_fee + ((ceil(($weights-500)/500))*$step_weight_fee);
								 	if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
									if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$zyoufei);
									}else{
										return $zyoufei;
									}
								 }else{
								 	if(!($weights>0)) $weight_fee='0.00';
								 	if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$weight_fee);
									}else{
										return $weight_fee;
									}
								 }
							}
							break;
						}elseif(in_array($ids['city'],$configure)){ //城市
							if($type=='item'){  //件计算
								$zyoufei = $item_fee + (($items-1)*$step_item_fee);
								if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
								if($tt=='ajax'){
									die($row['shipping_area_name'].'+'.$zyoufei);
								}else{
									return $zyoufei;
								}
							}elseif($type=='weight'){ //重量计算
								if($weights>500){
								 	$zyoufei = $weight_fee + ((ceil(($weights-500)/500))*$step_weight_fee);
								 	if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
									if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$zyoufei);
									}else{
										return $zyoufei;
									}
								 }else{
								 	if(!($weights>0)) $weight_fee='0';
								 	if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$weight_fee);
									}else{
										return $weight_fee;
									}
								 }
							}
							break;
						}elseif(in_array($ids['province'],$configure)){ //省
							if($type=='item'){  //件计算
								$zyoufei = $item_fee + (($items-1)*$step_item_fee);
								if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
								if($tt=='ajax'){
									die($row['shipping_area_name'].'+'.$zyoufei);
								}else{
									return $zyoufei;
								}
							}elseif($type=='weight'){ //重量计算
								if($weights>500){
								 	$zyoufei = $weight_fee + ((ceil(($weights-500)/500))*$step_weight_fee);
								 	if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
									if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$zyoufei);
									}else{
										return $zyoufei;
									}
								 }else{
								 	if(!($weights>0)) $weight_fee='0';
								 	if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$weight_fee);
									}else{
										return $weight_fee;
									}
								 }
							}
							break;
						}elseif(in_array($ids['country'],$configure)){ //国家
							if($type=='item'){  //件计算
								$zyoufei = $item_fee + (($items-1)*$step_item_fee);
								if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
								if($tt=='ajax'){
									die($row['shipping_area_name'].'+'.$zyoufei);
								}else{
									return $zyoufei;
								}
							}elseif($type=='weight'){ //重量计算
								if($weights>500){
								 	$zyoufei = $weight_fee + ((ceil(($weights-500)/500))*$step_weight_fee);
								 	if($zyoufei>$max_money&&intval($max_money)>0) $zyoufei = $max_money;
									if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$zyoufei);
									}else{
										return $zyoufei;
									}
								 }else{
								 	if(!($weights>0)) $weight_fee='0';
								 	if($tt=='ajax'){
										die($row['shipping_area_name'].'+'.$weight_fee);
									}else{
										return $weight_fee;
									}
								 }
							}
							break;
						}
					} //end if
				} // end if
			} // end foreach
		}else{
			if($tt=='ajax'){
				die("");
			}else{
				return $zyoufei;
			}
		}
			if($tt=='ajax'){
				die("");
			}else{
				return $zyoufei;
			}
	}
	
	
	//删除购物车商品
	function ajax_delcart_goods($id=0){
		//if(empty($id)) return "";
		if(!empty($id)){
			$cartlist = $this->Session->read('cart');
			if(isset($cartlist[$id])){ $this->Session->write("cart.{$id}","");}
			unset($cartlist);
		}
		$uid = $this->Session->read('User.uid');
		//用户等级折扣
		$rt['discount'] = 100;
		$rank = $this->Session->read('User.rank');
		if($rank>0){
			$sql = "SELECT discount FROM `{$this->App->prefix()}user_level` WHERE lid='$rank' LIMIT 1";
			$rt['discount'] = $this->App->findvar($sql);
		}
		
		$active = $this->Session->read('User.active');
		$goodslist = $this->Session->read('cart');
		$rt['goodslist'] = array();
		if(!empty($goodslist)){
			foreach($goodslist as $k=>$row){
				$rt['goodslist'][$k] = $row;
				$rt['goodslist'][$k]['url'] = get_url($row['goods_name'],$row['goods_id'],'product.php?id='.$row['goods_id'],'goods',array('product','index',$row['goods_id']));
				$rt['goodslist'][$k]['goods_thumb'] = SITE_URL.$row['goods_thumb'];
				$rt['goodslist'][$k]['goods_img'] = SITE_URL.$row['goods_img'];
				$rt['goodslist'][$k]['original_img'] = SITE_URL.$row['original_img'];
				
				//求出实际价格
				 $comd = array();
				 if(!empty($uid)&&$active=='1'){
				 	 $comd[] = $row['market_price'];
						if($rt['discount']>0){
							$comd[] = ($rt['discount']/100)*$row['market_price'];
						}
					   if($row['shop_price']>0){ //普通会员价格
							$comd[] =  $row['shop_price']; //普通会员价格
					   }
	
				 }else{
						$comd[] = $row['market_price'];
				 }
				 
			     if($row['is_promote']=='1' && $row['promote_start_date'] < mktime() && $row['promote_end_date'] > mktime()){ //促销价格
					    $comd[] =  $row['promote_price'];
			     }
			     if($row['is_qianggou']=='1' && $row['qianggou_start_date'] < mktime() && $row['qianggou_end_date'] > mktime()){ //抢购价格
					    $comd[] =  $row['qianggou_price'];
			     }
					   
				 $onetotal = min($comd);
				 if(intval($onetotal)<=0) $onetotal = $row['market_price'];
				 $total +=($row['number']*$onetotal); //总价格
			}
			unset($goodslist);
		}
		
		//赠品类型
		$fn = SYS_PATH.'data/goods_spend_gift.php';
		$spendgift = array();
		if(file_exists($fn) && is_file($fn)){
				include_once($fn);
		}
		$rt['gift_typesd'] = $spendgift;
		unset($spendgift);
		
		//商品赠品模块
		$minspend = array();
		if(!empty($rt['gift_typesd'])){
			foreach($rt['gift_typesd'] as $k=>$row){
				++$k;
				$minspend[$k] = $row['minspend'];
			}
			arsort($minspend);
		}
		
		$rt['gift_goods'] = array();
		$type = 0; 
		if(count($minspend)>0){
			$count = count($minspend);
			foreach($minspend as $t=>$val){  //已最高消费赠品为准
				if($total>=$val){
					$type = $t; //赠品等级
					break;
				}
			}
			unset($minspend);
			//赠品
			$rt['gift_goods_ids'] = array();
			if($type>0){
				$sql = "SELECT tb2.goods_id,tb1.type,tb2.goods_name,tb2.market_price,tb2.goods_sn ,tb2.goods_bianhao,tb2.goods_thumb  FROM `{$this->App->prefix()}goods_gift` AS tb1";
				$sql .=" LEFT JOIN `{$this->App->prefix()}goods` AS tb2 ON tb1.goods_id=tb2.goods_id";
				$sql .=" WHERE (tb2.is_alone_sale='0' OR tb2.is_alone_sale IS NOT NULL) AND tb2.is_on_sale='1' tb2.is_check='1' AND AND tb2.is_delete='0' AND tb1.type='$type'";
				$gift_goods = $this->App->find($sql);
				if(!empty($gift_goods)){
					foreach($gift_goods as $k=>$row){
						$rt['gift_goods_ids'][] = $row['goods_id']; //记录赠品的id
					}
					unset($gift_goods);
				}
			}

		}	
		
		$this->set('rt',$rt);
		$con = $this->fetch('ajax_mycart',true);
		die($con);
	}

        //清空购物车
        function mycart_clear(){
            $this->Session->write("cart",null);
			$this->Session->write('useradd',null);
            $this->jump(ADMIN_URL);
            exit;
        }
}

