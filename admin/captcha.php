<?php
/*
*该文件是一个验证码文件
*/
define('LOGIN',1); //让它在不登录情况下也不跳转
require_once("load.php");
$app->action('common','vCode',4,18);

?>