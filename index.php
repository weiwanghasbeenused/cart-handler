<?
$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);
date_default_timezone_set('Asia/Taipei');
if($uri[1] && $uri[1] == 'api') {
	require_once('config/config.php');
	require_once('response/'.$uri[2].'.php');
}
else {
	require_once('views/head.php');
	require_once('views/nav.php');
	if(!$uri[1] || $uri[1] == 'sandbox') require_once('views/main.php');
	else require_once('views/'.$uri[1].'.php');
	require_once('views/foot.php');
}
