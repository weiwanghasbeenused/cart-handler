<?
if(!file_get_contents('php://input')) {
	echo '這個檔案只負責處理購物車的提交, 不顯示任何內容';
	exit();
}
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
require_once('../config/config.php');
$db = db_connect('admin');
$json = file_get_contents('php://input');
$data = json_decode($json);

if( $data->error )
{
	echo '{ "response": "error", "reason": "test" }';
	exit();
}

$name = $data['name'];
$email = $data['email'];
$items = $data["productIds"];
$subtotal = $data['subtotal'];
$created = date("Y-m-d H:i:s", time());
$sql_submissions = "INSERT INTO submissions (`name`, `email`, `items`, `subtotal`, `created`) VALUES ('".$name."', '".$email."', '".$items."', '".$subtotal."', '".$created."')";
$res_submissions = $db->query($sql_submissions);
if($res_submissions){
	echo '{"response": "success"}';
}
else{
	echo '{"response": "error", "reason": "database" }';
}
?>