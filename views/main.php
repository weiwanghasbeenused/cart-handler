<?
$sql = 'SELECT * FROM submissions';
$db = db_connect('guest');
$res = $db->query($sql);
$submission = array();
while($obj = $res->fetch_assoc()){
	$submission[] = $obj;
}
?>

<main>
	<? var_dump($submission); ?>
</main>
<script>
</script>