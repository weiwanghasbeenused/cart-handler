<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

if(empty($_POST)) {
        $task = $uri[2] == 'cartHandler' ? '接收購物車資料' : '處理註冊';
        echo '這個檔案只負責' . $task . ', 不顯示任何內容';
        exit();
}
$db = db_connect('main');