<?
if(empty($_POST)) {
	echo 'Nothing here.';
	exit();
}
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
require_once('../config/config.php');
$db = db_connect('admin');
$sql_products = 'SELECT * FROM products';
$res = $db->query($sql_products);
$products = array();
while($obj = $res->fetch_assoc()){
	$products[] = $obj;
}
$sql_submissions = 'INSERT INTO submissions ';
// $productIds = json_decode( $_POST["productIds"] );
$name = $_POST['name'];
$email = $_POST['email'];
$items = $_POST["productIds"];
$subtotal = $_POST['subtotal'];
$created = time();
$sql_submissions = "SELECT * FROM products (`name`, `email`, `items`, `subtotal`) VALUES ('".$name."', '".$email."', '".$items."', '".$subtotal."')";

$res = $db->query($sql_submissions);
if($res){
	echo 'success';
}
else{
	echo 'error';
}
?>