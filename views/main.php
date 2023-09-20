<?
$mode = $uri[1] ? ($uri[1] == 'sandbox' ? 'sandbox' : 'undefined') : 'live';
$db = db_connect('guest');
$table_name = 'submissions';
$sql_submissions = 'SELECT submissions.*, students.firstName, students.lastName FROM `submissions`, `students` WHERE `mode` = "'.$mode.'" AND submissions.submitterId = students.id';
$res_submissions = $db->query($sql_submissions);
$submissions = array();
while($obj = $res_submissions->fetch_assoc()){
	$submissions[] = $obj;
}
$sql_products = 'SELECT * FROM `products`';
$res_products = $db->query($sql_products);
$products = array();
while($obj = $res_products->fetch_assoc()){
	$products[$obj['id']] = $obj;
}
function printListItem($submission, $products_arr){
	$output = '<div class="row"><div class="name">'.$submission['lastName']. ' ' . $submission['firstName'].'</div><div class="items">';
	$items = json_decode($submission['items'] );
	$created = $submission['created'] ? $submission['created'] : '';
	$item_names = array();
	if($items)
	{
		foreach($items as $id)
		{
			if( !isset($products_arr[$id]) ) {
				return;
			}
			$p = $products_arr[$id];
			$item_names[] = $p['title'];
		}
	}
	$output .=  implode(', ', $item_names);
	$output .= '</div><div class="subtotal">'.$submission['subtotal'].'</div><div class="created">'. $created .'</div></div>';

	return $output;
}

$page_name = $uri[1] == 'sandbox' ? "購買請求列表 (Sandbox)" : "購買請求列表";

?>
<main>

	<h1 id="page-name"><?= $page_name; ?></h1>
	<div id="list-container">
		<div class="row"><div class="name">姓名</div><div class="items">購買商品</div><div class="subtotal">總金額</div><div class="created">購買時間</div></div>
		<? 
		if($submissions) {
			foreach($submissions as $s){
				echo printListItem($s, $products);
			} 
		}
		else
			echo '<div id="zero-submissions">Currently no submissions</div>';
		?>
	</div>
</main>
<style>
	/* *
	{
		margin: 0;
	}
	body
	{
		font-size: 16px;
	} */
	
</style>
