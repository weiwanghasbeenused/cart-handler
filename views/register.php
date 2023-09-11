<?php 
?>
<main page="<?php echo $uri[1]; ?>">
    <section class="form-container main-container">
        <form method="post" action="/api/register" enctype="multipart/form-data">
            <!-- <input type="hidden" name="action" value="requestToken"> -->
            <div class="form-spacing-wrapper">
                <p class="form-element form-description">歡迎來到 Javascript 課程, 請輸入你的姓名, email 及密碼以便完成本課程最終作業, 你所輸入的資料只會在本課程中使用</p>
            </div>
            <div class="form-spacing-wrapper">
                <div class="flex-container" cols="2">
                    <input class="form-element form-input flex-item" name="lastName" placeholder="姓" required>
                    <input class="form-element form-input flex-item" name="firstName" placeholder="名" required>
                </div>
            </div>
            <div class="form-spacing-wrapper">
                <label class="inline-label">Email</label><input class="form-element form-input" type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-spacing-wrapper">
                <label class="inline-label">密碼 (8-16字元)</label><input class="form-element form-input" type="password" id="password" name="password" placeholder="密碼" required>
            </div>
            <div class="form-spacing-wrapper">
                <label class="inline-label">確認密碼</label><input class="form-element form-input" type="password" id="password-confirm" name="password-confirm" placeholder="確認密碼" required>
            </div>
            <!-- <div class="form-divider form-spacing-wrapper"></div> -->
            <div class="form-spacing-wrapper ">
                <button id="next-btn" class="form-element form-btn btn">送出</button>
            </div>
            <div class="response-container">
                <p class="response-message error-message"></p>
                <p class="response-message success-message">註冊成功! 網頁轉向中...<br>若此訊息停留過久, 請聯絡 weiwanghasbeenused@gmail.com 以尋求協助</p>
            </div>
        </form>
    </section>
</main>
<style>
    
</style>
<script>
    let form = document.querySelector('form');
    let error_message = document.querySelector('.error-message');
    // let passwords = document.querySelectorAll('input[name="password"], input[name="password-confirm"]');
    let req_url = '/api/register';
    form.addEventListener('submit', function(event){
        event.preventDefault();
        if(document.querySelector('input[name="password"]').value !== document.querySelector('input[name="password-confirm"]').value) {
            form.setAttribute('data-form-status', 'error');
            error_message.innerText = '密碼與確認密碼不符';
            return;
        }
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
                    location.href="/student";
                }
                
            }
        }
        request.open('POST', req_url, true);
        request.send(new FormData(event.target));
    });
</script>