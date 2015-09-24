<?php
require_once('../load.php');
$res = $_POST;
file_put_contents('/var/www/pinet-fenxiao/cache/unionpay/notify', print_r($res, 1).PHP_EOL, FILE_APPEND);
if ($res['respCode'] == '00' && $res['respMsg'] = 'success') {
	$app->action('shopping','pay_successs_tatus2',array('order_sn'=>$res['orderId'], 'status'=>'1'));//修改支付状态
}
header("Location:".str_replace('/unionpay','',ADMIN_URL).'user.php?act=orderlist');