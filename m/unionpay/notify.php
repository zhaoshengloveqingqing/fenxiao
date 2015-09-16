<?php
require_once('../load.php');
file_put_contents('/var/www/pinet-fenxiao/cache/wxpay', print_r($_POST, 1)."\r\n",FILE_APPEND);
//if ($order) {
//	if ($_POST['respCode'] == '00') {
//		$app->action('shopping','pay_successs_tatus2',array('order_sn'=>$out_trade_no,'status'=>'1'));//修改支付状态
//		M('b2c_wingtrade')->where(array('order_sn'=> $orderId))->save(array('is_pay'=>'1', 'return_params'=>serialize($_POST)));
//	}else{
//		$this->jump(str_replace('/unionpay','',ADMIN_URL).'user.php?act=orderlist');exit;
//	}
//}
