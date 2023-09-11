<?
require_once("../config/config.php");
require_once("config.php");
$db = db_connect('guest');
$sql = 'SELECT * FROM products';
$res = $db->query($sql);
$product_names = array();
while($obj = $res->fetch_assoc()){
	$product_names[] = $obj['title'];
}

$content = "";

foreach($student as $s)
{
	$content .= $s . "\n\n商品:\n";
	$product_amount = rand(3, 7);
	for($i = 0; $i < $product_amount; $i++)
	{
		$product_idx = rand(0, count($product_names) - 1);
		$content .= $product_names[$product_idx] . "\n";
	}
	$content .= "\n---\n\n";
}


echo $content;

?>