<?
$db = db_connect('guest');
$sql_submissions = 'SELECT * FROM submissions';
$res_submissions = $db->query($sql_submissions);
$submissions = array();
while($obj = $res_submissions->fetch_assoc()){
	$submissions[] = $obj;
}
$sql_products = 'SELECT * FROM products';
$res_products = $db->query($sql_products);
$products = array();
while($obj = $res_products->fetch_assoc()){
	$products[$obj['id']] = $obj;
}
function printListItem($submission, $products_arr){
	$output = '<div class="row"><div class="name">'.$submission['name'].'</div><div class="items">';
	$items = explode(',', $submission['items'] );
	$created = $submission['created'] ? $submission['created'] : '';
	$item_names = array();
	if($items)
	{
		foreach($items as $id)
		{
			if( !isset($products_arr[$id]) ) return;
			$p = $products_arr[$id];
			$item_names[] = $p['title'];
		}
	}
	$output .=  implode(', ', $item_names);
	$output .= '</div><div class="subtotal">'.$submission['subtotal'].'</div><div class="created">'. $created .'</div></div>';

	return $output;
}
?>

<main>
	<div class="row"><div class="name">姓名</div><div class="items">購買商品</div><div class="subtotal">總金額</div><div class="created">購買時間</div></div>
	<? 
	if($submissions) {
		foreach($submissions as $s){
			echo printListItem($s, $products);
		} 
	}
	else
		echo 'Currently no submissions';
	?>
</main>
<style>
	main {
		margin: 100px 50px ;
		border-top: 1px solid;
		border-left: 1px solid;
	}
	.row
	{
		display: flex;
		border-bottom: 1px solid;
	}
	.row:hover
	{
		background-color: yellow;
	}
	.row > div
	{
		padding: 10px;
		border-right: 1px solid;
	}
	.name
	{
		flex: 0 0 80px;
	}
	.items
	{
		flex: 0 0 500px;
	}
	.subtotal
	{
		flex: 0 0 80px;
	}
	.created
	{
		flex: 1;
	}

</style>