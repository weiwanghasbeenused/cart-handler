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
		echo '<div id="zero-submissions">Currently no submissions</div>';
	?>
</main>
<div id="announcement">
	<p id="msg">各位同學:<br>現在這裡開放讓大家交作業，請參照我寄給你們的txt檔，送出指派給你們的商品資料。同時請大家共同維護此版面整潔 (也就是不要再買20萬的書，或讓「那個人」下訂單了)，謝謝！</p>
	<div id="control-bar"><button onclick="confirmAnnouncement();">確認並接受cookie</button><button onclick="confirmAnnouncement(false)">確認但不接受cookie</button> <span class="tip-trigger">cookie&#127850;? <span class="tip">這個網站的cookie只會儲存你是否確認過此訊息。若確認過，此訊息便不再顯示</span></span></div>
</div>
<style>
	*
	{
		margin: 0;
	}
	body
	{
		font-size: 16px;
	}
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
	.tip-trigger {
		display: inline-block;
		position: relative;
		cursor: help;

	}
	.tip
	{
		position: absolute;
		min-width: 180px;
		padding: 20px;
		background-color: #ddd;
		bottom: 0;
		left: 0;
		transform: translate(0, 100%);
		opacity: 0;
		pointer-events: none;
		font-size: 15px;

	}
	.tip-trigger:hover .tip
	{
		transition: opacity .25s;
		opacity: 1;
		pointer-events: initial;
	}
	#announcement
	{
		display: none;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		background-color: yellow;
		border: 1px solid;
		padding: 20px;
		width: 60vw;
		max-width: 600px;
		font-size: 1.2em;
	}

	body.viewing-announcement #announcement
	{
		display: block;
		opacity: 1;
	}
	body.viewing-announcement main
	{
		pointer-events: none;
		opacity: 0.5;
	}
	button
	{
		padding: 15px;
		border: 1px solid;
		border-radius: 15px;
		cursor: pointer;
		background-color: #fff;
	}
	button + button
	{
		margin-left: 10px;
	}
	button:hover
	{
		background-color: #ddd;
	}
	#control-bar
	{
		margin-top: 20px;
	}
	#zero-submissions
	{
		padding: 10px;
		border-bottom: 1px solid;
		border-right: 1px solid;
	}
</style>
<script>
	function confirmAnnouncement(acceptCookie=true){
		document.body.classList.remove('viewing-announcement');
		if(!acceptCookie) return;
		setCookie("announcementIsRead", "true", 30);
	}
</script>