<?php
		require_once('../load.php');
		include_once SYS_PATH_WAP.'/unionpay/lib/SDKConfig.php';
		include_once SYS_PATH_WAP.'/unionpay/lib/common.php';
		include_once SYS_PATH_WAP.'/unionpay/lib/secureUtil.php';
		include_once SYS_PATH_WAP.'/unionpay/lib/httpClient.php';
		include_once SYS_PATH_WAP.'/unionpay/lib/log.class.php';
		
		$rt = $app->action('shopping','get_order_pay_info');
		
		$total_fee = intval($rt['order_amount']*100);
		
		// 初始化日志
		$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
		
		// 初始化日志
		$params = array(
				'version' => '5.0.0',						//版本号
				'encoding' => 'utf-8',						//编码方式
				'certId' => getSignCertId (),				//证书ID  
				'txnType' => '01',							//交易类型	
				'txnSubType' => '01',						//交易子类
				'bizType' => '000201',						//业务类型
				'frontUrl' =>  SDK_FRONT_NOTIFY_URL,  		//前台通知地址
				'backUrl' => SDK_BACK_NOTIFY_URL,			//后台通知地址	
				'signMethod' => '01',						//签名方法
				'channelType' => '08',						//渠道类型
				'accessType' => '0',						//接入类型
				'merId' => '826340173990002',				//商户代码
				'orderId' => $rt['order_sn'],						//商户订单号
				'txnTime' => date('YmdHis'),					//订单发送时间
				'txnAmt' => $total_fee,						//交易金额 单位分
				'currencyCode' => '156'				//交易币种	
		);
		
		// 签名
		sign ( $params );
		/*手机WAP支付方式*/
		// 构造 自动提交的表单
		$html_form = create_html ( $params, SDK_FRONT_TRANS_URL );
		$log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
		$log->LogInfo ( $html_form );
		$log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
		echo $html_form;
		
		