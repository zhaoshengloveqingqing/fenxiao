<?php // This file is protected by copyright law & provided under license. Copyright(C) 20015-2020 www.02yc.com, All rights reserved.
define ( 'LOGIN', 0 );
require_once ('load.php');
if ($app->action ( 'manager', 'is_login' )) {
	Import::basic ()->redirect ( ADMIN_URL );
	exit ();
}
if (isset ( $_POST ['action'] ) && $_POST ['action'] == "login") {
	$data ['adminname'] = $_POST ['adminname'];
	$data ['password'] = $_POST ['password'];
	$data ['vifcode'] = $_POST ['vifcode'];
	$app->action ( 'manager', 'login', $data );
	exit ();
}
$app->action ( 'manager', 'index' ); 