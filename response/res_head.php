<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header("Content-Type: application/json; charset=utf-8");

$json_input = file_get_contents("php://input");
$json_input = $json_input ? json_decode($json_input, true) : $json_input;
if(empty($_POST) && !$json_input) {
        $task = $uri[2] == 'cartHandler' ? '接收購物車資料' : '處理註冊';
        echo '這個檔案只負責' . $task . ', 不顯示任何內容';
        exit();
}
$submission = empty($_POST) ? $json_input : $_POST;
$db = db_connect('main');