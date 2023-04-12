<?
require_once('config/config.php');

$db = db_connect("guest");
$announcementIsRead = isset($_COOKIE["announcementIsRead"]);
$bodyClass = '';
if(!$announcementIsRead) $bodyClass .= 'viewing-announcement';
?><!DOCTYPE html>
<html lang="zh-tw">
<head>
	<title>購買請求列表</title>
	<script src="assets/js/cookie.js"></script>
</head>
<body class="<?= $bodyClass; ?>">
