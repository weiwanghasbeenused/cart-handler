<?php
require_once(__DIR__ . '/../static/php/auth.php');
$nav_items = array();
$nav_items[] = array('display' => '首頁', 'url' => '/');
$nav_items[] = array('display' => 'Sandbox', 'url' => '/sandbox');
if($auth_status['status'] === 'success') {
	$nav_items[] = array('display' => '我的檔案', 'url' => '/student');
	$nav_items[] = array('display' => '登出', 'url' => '/logout');
}
else {
	$nav_items[] = array('display' => '登入', 'url' => '/login');
}
?>
<nav>
	<ul><?php
		foreach($nav_items as $item) 
			echo '<li class="nav-item"><a class="nav-item-link" href="' . $item['url'] . '">' . $item['display'] . '</a></li>';
	?></ul>
</nav>