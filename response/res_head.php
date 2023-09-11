<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

if(empty($_POST)) {
        echo '這個檔案只負責處理註冊, 不顯示任何內容';
        exit();
}
$db = db_connect('main');