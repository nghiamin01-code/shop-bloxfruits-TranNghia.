<?php
// Thay API Key của Nghĩa vào đây (Lấy ở web gạch thẻ)
$api_key = '80df3668af04f2a85e1befc277896513'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $serial = $_POST['serial'];
    $pin = $_POST['pin'];
    $request_id = rand(100000, 999999); // Mã đơn hàng ngẫu nhiên

    // Gửi dữ liệu sang web gạch thẻ (Ví dụ: doithe1s, thesieure...)
    $url = "https://doithe1s.vn/api/card-auto?type=$type&amount=$amount&pin=$pin&serial=$serial&request_id=$request_id&partner_id=$api_key";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response; // Trả kết quả về cho web
}
?>
