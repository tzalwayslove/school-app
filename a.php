<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://www.mxingo.com/dispatchorder/findByPage.shtml",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "dtGridPager=%7B%22isExport%22%3Afalse%2C%22pageSize%22%3A500%2C%22startRecord%22%3A0%2C%22nowPage%22%3A1%2C%22recordCount%22%3A-1%2C%22pageCount%22%3A-1%2C%22parameters%22%3A%7B%7D%2C%22fastQueryParameters%22%3A%7B%7D%2C%22advanceQueryConditions%22%3A%5B%5D%2C%22advanceQuerySorts%22%3A%5B%5D%7D",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        "cookie: JSESSIONID=18B6DF55CAB512F4ACC3A5CDA6B3F9FD",
        "postman-token: 383188b2-6306-48d2-c0bf-e0be6b477a3c"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}