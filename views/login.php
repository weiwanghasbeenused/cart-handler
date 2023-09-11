<?php
$url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
$url .= isset($_GET['back']) ? urldecode($_GET['back']) : '/';
?>
<main page="<?php echo $uri[1]; ?>">
    <section class="form-container main-container">
        <form method="post" action="/api/register" enctype="multipart/form-data">
            <!-- <input type="hidden" name="action" value="requestToken"> -->
            <input type="hidden" name="redirect" value="<?php echo $url; ?>">
            <div class="form-spacing-wrapper">
                <p class="form-element form-description">歡迎來到 Javascript 課程, 請輸入你 Email 及密碼以登入<br>若你還沒有帳號, 請<a href="/register">按此註冊</a></p>
            </div>
            <div class="form-spacing-wrapper">
                <label class="inline-label">Email</label><input class="form-element form-input" type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-spacing-wrapper">
                <label class="inline-label">密碼 (8-16字元)</label><input class="form-element form-input" type="password" id="password" name="password" placeholder="密碼" required>
            </div>
            <!-- <div class="form-divider form-spacing-wrapper"></div> -->
            <div class="form-spacing-wrapper ">
                <button id="next-btn" class="form-element form-btn btn">送出</button>
            </div>
            <div class="response-container">
                <p class="response-message error-message"></p>
                <p class="response-message success-message">登入成功! 網頁轉向中...<br>若此訊息停留過久, 請聯絡 weiwanghasbeenused@gmail.com 以尋求協助</p>
            </div>
        </form>
    </section>
</main>
<script>
    let form = document.querySelector('form');
    let error_message = document.querySelector('.error-message');
    // let passwords = document.querySelectorAll('input[name="password"], input[name="password-confirm"]');
    let req_url = '/api/login';
    form.addEventListener('submit', function(event){
        event.preventDefault();
        if( document.querySelector('input[name="password"]').value.length < 8 ||
            document.querySelector('input[name="password"]').value.length > 16 )
        {
            form.setAttribute('data-form-status', 'error');
            error_message.innerText = '密碼長度過長/短';
            return;
        }
        let request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200) {
                console.log('got res');
                let res = JSON.parse(request.responseText);
                if(res['status'] === 'error') {
                    form.setAttribute('data-form-status', 'error');
                    error_message.innerText = res['body'];
                }
                else if(res['status'] === 'success') {
                    form.setAttribute('data-form-status', 'success');
                    location.href=res['body'];
                }
                
            }
        }
        request.open('POST', req_url, true);
        request.send(new FormData(event.target));
    });
</script>