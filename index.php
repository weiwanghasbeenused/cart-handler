<?
$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);


if($uri[1] == 'api'){
	require_once('config/config.php');
	require_once('response/'.$uri[2].'.php');
} 
else if(!$uri[1]){
	require_once('views/head.php');
	require_once('views/main.php');
	// else require_once('views/404.php');
	require_once('views/foot.php');
}
else if ($uri[1] == 'generate-list')
{
	require_once('views/head.php');
	require_once('views/generate-list.php');
	// else require_once('views/404.php');
	require_once('views/foot.php');
}
	
