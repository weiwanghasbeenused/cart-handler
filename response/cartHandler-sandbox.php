<?
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
if(empty($_POST)) {
        echo '這個檔案只負責處理購物車的提交, 不顯示任何內容';
        exit();
}

if(isset($_POST['error']))
{
	echo '{ "status": "error", "reason": "test error response" }';
	exit();
}

$missing_data = array();
if( !isset($_POST['name']) ) $missing_data[] = 'name';
if( !isset($_POST['email']) ) $missing_data[] = 'email';
if( !isset($_POST['productIds']) ) $missing_data[] = 'productIds';
if( !isset($_POST['subtotal']) ) $missing_data[] = 'subtotal';

if(!empty($missing_data))
{
	echo '{ "status": "error", "reason": "missingData: ' . implode(',', $missing_data) . '" }';
	exit();
}

require_once('../config/config.php');
$db = db_connect('admin');
$name = $_POST['name'];
$email = $_POST['email'];
$items = $_POST["productIds"];
$subtotal = $_POST['subtotal'];
$created = date("Y-m-d H:i:s", time());
$sql_submissions = "INSERT INTO submissions_sandbox (`name`, `email`, `items`, `subtotal`, `created`) VALUES ('".$name."', '".$email."', '".$items."', '".$subtotal."', '".$created."')";
$res_submissions = $db->query($sql_submissions);
if($res_submissions){
	echo '{"status": "success"}';
}
else{
	echo '{"status": "error", "reason": "database"}';
}
?>
