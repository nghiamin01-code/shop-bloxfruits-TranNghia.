<?php
$partner_id = '9565963734'; // Lấy ở web gạch thẻ
$partner_key = '80df3668af04f2a85e1befc277896513'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $serial = $_POST['serial'];
    $pin = $_POST['pin'];
    $request_id = rand(100000, 999999);

    $url = "https://doithe1s.vn/api/card-auto?type=$type&amount=$amount&pin=$pin&serial=$serial&request_id=$request_id&partner_id=$partner_id&partner_key=$partner_key";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
}
?>
