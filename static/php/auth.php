<?php
require_once(__DIR__ . '/validate_jwt.php');
$token = isset($_GET['token']) ? $_GET['token'] : (isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : false);
$auth_status = validate_jwt($token);
if($auth_status['status'] == 'success' && !isset($_COOKIE['auth_token'])):
?><script src="/static/js/cookie.js"></script>
<script>
    createCookie("auth_token", "<?= $token; ?>", 90);
</script><?
endif;