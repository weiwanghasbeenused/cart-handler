<?
$mode = $uri[1] ? ($uri[1] == 'sandbox' ? 'sandbox' : 'undefined') : 'live';
$db = db_connect('guest');
$table_name = 'submissions';
$sql_submissions = 'SELECT * FROM ' . $table_name . ' WHERE `mode` = "'.$mode.'"';
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
<div id="announcement">
	<p id="msg">各位同學:<br>現在這裡開放讓大家交作業，請參照我寄給你們的txt檔，送出指派給你們的商品資料。同時請大家共同維護此版面整潔 (也就是不要再買20萬的書，或讓「那個人」下訂單了)，謝謝！</p>
	<div id="control-bar"><button onclick="confirmAnnouncement();">確認並接受cookie</button><button onclick="confirmAnnouncement(false)">確認但不接受cookie</button> <span class="tip-trigger">cookie&#127850;? <span class="tip">這個網站的cookie只會儲存你是否確認過此訊息。若確認過，此訊息便不再顯示</span></span></div>
</div>
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
<script>
	function confirmAnnouncement(acceptCookie=true){
		document.body.classList.remove('viewing-announcement');
		if(!acceptCookie) return;
		setCookie("announcementIsRead", "true", 30);
	}
</script>