<?
$db = db_connect('guest');
$sql_submissions = 'SELECT * FROM submissions';
$res_submissions = $db->query($sql_submissions);
$submission = array();
while($obj = $res_submissions->fetch_assoc()){
	$submission[] = $obj;
}
$sql_products = 'SELECT * FROM products';
$res_products = $db->query($sql_products);
$products = array();
while($obj = $res_products->fetch_assoc()){
	$products[$obj['id']] = $obj;
}

function printListItem($id, $submission, $products_arr){
	$p = $products_arr[$id];
	$output = '<div class="row"><div class="name">'.$submission['name'].'</div><div class="items">';
	$items = json_decode($submission['items']);
	$item_names = array();
	foreach($items as $id)
	{
		$item_names[] = $p['title'];
	}
	$output .=  implode(', ', $item_names);
	$output .= '</div><div class="subtotal">'.$submission['subtotal'].'</div></div>';
}
?>

<main>
	<?  ?>
</main>
<script>
</script>