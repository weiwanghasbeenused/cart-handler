<?php
require_once(__DIR__ . '/../static/php/functions_form_inspection.php');
// require_once('static/php/validate_jwt.php');
// $token = isset($_GET['token']) ? $_GET['token'] : (isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : false);
// $auth_status = validate_jwt($token);
if($auth_status['status'] == 'error') {
    $redirect = "/login?back=" . urlencode(implode('/', $uri));
    ?><script>
        window.location.href="<?= $redirect; ?>";
    </script><?
    exit();
}
$payload = json_decode($auth_status['payload']);
$email = $payload->user_email;
$student = getStudent($email, $db)->fetch_assoc();
$items = json_decode($student['assignment']);
$assignment = array();
$products = array();
$sql_getProducts = "SELECT * FROM `products`";
$result = $db->query($sql_getProducts);
if($result){
  while($obj = $result->fetch_assoc()){
    $products[$obj['id']] = $obj;
  }
}
foreach($items as $p_id) {
    $assignment[] = $products[$p_id]['title'];
}
$assignment = implode('<br>', $assignment);
?>
<main page="<?php echo $uri[1]; ?>">
    <section>
        <p>嗨, <?php echo $student['firstName']; ?>!<br>
        以下是你繳交課程作業會需要的資料</p><br>
        <ul id="assignment-info-container">
            <li class="assignment-info-row row"><span class="col col-1">Live token</span><span class="col col-2"><?php echo $student['live_key']; ?></span></li>
            <li class="assignment-info-row row"><span class="col col-1">Sandbox token</span><span class="col col-2"><?php echo $student['sandbox_key']; ?></span></li>
            <li class="assignment-info-row row"><span class="col col-1">書單</span><span class="col col-2"><?php echo $assignment; ?></li> 
        </ul>
    </section>
</main>
<style>
    #assignment-info-container {
        border-top: 1px solid #000;
        /* border-bottom: 1px solid #000; */
    }
    .col {
        display: inline-block;
    }
    .assignment-info-row{
        display: flex;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .assignment-info-row + .assignment-info-row {
        /* margin-top: 5px; */
        /* border-top: 1px solid #000; */
    }
    .assignment-info-row .col-1 {
        flex: 0 0 150px;
    }
</style>