<?
$sql = 'SELECT * FROM submissions';

?>

<main>
	
</main>
<script>
	let httpRequest = new XMLHttpRequest();
    function handler() { 
        if ( httpRequest.readyState == 4) {
            if ( httpRequest.status === 200 ) {
                // request 成功, 開始處理 response
                let txt = httpRequest.responseText;
                let json = JSON.parse(txt);
            } else {
                // request 失敗
                // 可能是 404 (Not Found) 或 
                // 500 (Internal Server Error) 等原因
                console.log(httpRequest.responseText);
            }
        }
        else {
            // readyState 可能是 1 到 3
            // request 還沒完成 . . .
            console.log('request 還沒完成 . . .');
        }
    }
    httpRequest.onreadystatechange = handler;
    let request_url = "https://seat.tpml.edu.tw/sm/service/getAllArea";
    // let request_url = "https://cart-handler.weiwanghasbeenused.com/response/products.php";
    httpRequest.open("GET", request_url, true);
    httpRequest.send();
</script>