<?php

function callAPI($method, $url, $userpwd, $header = array(), $data = false)
{
    $curl = curl_init();        
    if(!empty($header)) curl_setopt ($curl, CURLOPT_HTTPHEADER, $header);
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            /* 
                expected data:
                array(
                    'file' => file
                    'size => filesize
                )
            */
            curl_setopt($curl, CURLOPT_PUT, 1);
            curl_setopt($curl, CURLOPT_INFILE, $data['file']);
            curl_setopt($curl, CURLOPT_INFILESIZE, $data['size']);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    if($userpwd) curl_setopt($curl, CURLOPT_USERPWD, $userpwd);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}
function array_values_equal($a, $b) {
    $x = array_values($a);
    $y = array_values($b);

    sort($x);
    sort($y);

    return $x == $y;
}
?>