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
?>
<main page="<?php echo $uri[1]; ?>">
    <section>
        <p>嗨, <?php echo $student['firstName']; ?>!<br><br></p>
        <p>以下是你繳交課程作業會需要的資料<br>
        Live token: <?php echo $student['live_key']; ?><br>
        Sandbox token: <?php echo $student['sandbox_key']; ?><br>
        </p>
    </section>
</main>