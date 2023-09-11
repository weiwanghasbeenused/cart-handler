<?php
$url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
$url .= isset($_GET['back']) ? urldecode($_GET['back']) : '/';
?>
<script src="/static/js/cookie.js"></script>
<script>
    eraseCookie("auth_token");
</script>
<main page="<?php echo $uri[1]; ?>">
    <section class="">
        <p>你已順利登出</p>
    </section>
</main>