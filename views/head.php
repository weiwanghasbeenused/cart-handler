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
