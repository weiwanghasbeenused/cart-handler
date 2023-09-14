<?
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
if(!empty($_POST))
{
	echo '這裡只負責處理 GET, 不處理 POST . . . ';
	exit();
}
require_once(__DIR__ . '/../config/config.php');
$db = db_connect('guest');
$sql = 'SELECT * FROM products';
$res = $db->query($sql);
$products = array();
while($obj = $res->fetch_assoc()){
	$products[] = $obj;
}

foreach($products as &$p)
{
	$p['imageSrc'] = 'https://' . $_SERVER["HTTP_HOST"] . '/assets/images/' . $p['imageSrc'];
	$p['price'] = intval($p['price']);
}
unset($p);
echo json_encode($products, JSON_UNESCAPED_UNICODE);
exit();
?>