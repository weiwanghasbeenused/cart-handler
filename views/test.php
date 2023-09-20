<?php

?>
<main page="<?php echo $uri[1]; ?>">
    <section>
        
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
<script>
    let request = new XMLHttpRequest();
    request.addEventListener('readystatechange', function(){
        if ( request.readyState == 4) {
            if ( request.status === 200 ) {
                // request 成功, 開始處理 response
                console.log("request 成功, 開始處理 response");
                let json = JSON.parse(request.responseText); // request.responseText 也有可能不是 JSON 的形式, 這取決於撰寫 API 的人怎麼想
                console.log(json);
            } else {
                // request 失敗
                // 可能是 404 (Not Found) 或 
                // 500 (Internal Server Error) 等原因
                console.log(request.responseText);
            }
        }
        else {
            // readyState 可能是 1 到 3
            // request 還沒完成 . . .
        }
    });
    let request_url = "https://data.taipei/api/v1/dataset/2979c431-7a32-4067-9af2-e716cd825c4b?scope=resourceAquire";
    request.open("GET", request_url, false); // open() 還能接受第三個參數, 是用以表示這個 request 是否為 asynchronous (非同步) 的布林值, 預設為 true
    let data = { "resource_id": "2979c431-7a32-4067-9af2-e716cd825c4b" };
    data = JSON.stringify(data);
    console.log("request.send() 前一行");
    request.send(data);
    console.log("request.send() 後一行");
</script>