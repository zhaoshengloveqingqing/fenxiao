<?php
require_once('../load.php');
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
*/

	//存储微信的回调
	$xmls = $GLOBALS['HTTP_RAW_POST_DATA'];	
	if(empty($xmls)) {
		$xmls = file_get_contents("php://input"); 
	}
	//使用simplexml_load_string() 函数将接收到的XML消息数据载入对象$postObj中。
	if(!empty($xmls)){
		$postObj = simplexml_load_string($xmls, 'SimpleXMLElement', LIBXML_NOCDATA);
		file_put_contents('/var/www/pinet-fenxiao/cache/warn', print_r($postObj, 1)."\r\n",FILE_APPEND);
	}