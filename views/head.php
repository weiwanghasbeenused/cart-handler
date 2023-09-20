<?
require_once('config/config.php');

$db = db_connect("guest");
$announcementIsRead = isset($_COOKIE["announcementIsRead"]);
$bodyClass = array();
if(!$announcementIsRead) $bodyClass[] = 'viewing-announcement';
if( $uri[1] == 'sandbox' ) $bodyClass[] = 'sandbox';

$bodyClass = implode(" ", $bodyClass);

$stylesheets = array('main');
if($uri[1] == 'login' || $uri[1] == 'register') $stylesheets[] = 'form';

?><!DOCTYPE html>
<html lang="zh-tw">
<head>
	<title>購買請求列表</title>
	<?php 
	foreach($stylesheets as $s) echo '<link href="static/css/'.$s.'.css" rel="stylesheet" />';
	?>
	
	<script src="assets/js/cookie.js"></script>
</head>
<body class="<?= $bodyClass; ?>">
<div id="announcement">
	<p id="msg">此網站的 cookie 僅用於記錄你是否閱讀過此訊息</p>
	<div id="control-bar"><button onclick="confirmAnnouncement();">確認並接受cookie</button><button onclick="confirmAnnouncement(false)">確認但不接受cookie</button> <span class="tip-trigger">cookie&#127850;? <span class="tip">這個網站的cookie只會儲存你是否確認過此訊息。若確認過，此訊息便不再顯示</span></span></div>
</div>
<script>
	function confirmAnnouncement(acceptCookie=true){
		document.body.classList.remove('viewing-announcement');
		if(!acceptCookie) return;
		setCookie("announcementIsRead", "true", 30);
	}
</script>
