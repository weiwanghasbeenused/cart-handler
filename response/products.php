<?
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
require_once('../config/config.php');
$db = db_connect('guest');
$sql = 'SELECT * FROM products';
$res = $db->query($sql);
$products = array();
while($obj = $res->fetch_assoc()){
	$products[] = $obj;
}
echo json_encode($products, JSON_UNESCAPED_UNICODE);
exit();
?>