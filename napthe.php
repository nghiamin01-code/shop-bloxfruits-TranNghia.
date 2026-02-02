<?php
// Thay thông tin đối tác của bạn vào đây
$partner_id = '9565963734'; 
$partner_key = '80df3668af04f2a85e1befc277896513';

if ($_POST) {
    $telco = $_POST['telco']; // Viettel, Mobifone...
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];
    $seri = $_POST['seri'];
    $request_id = rand(100000, 999999); // Mã đơn hàng ngẫu nhiên

    $data = array();
    $data['partner_id'] = $partner_id;
    $data['telco'] = $telco;
    $data['amount'] = $amount;
    $data['code'] = $pin;
    $data['serial'] = $seri;
    $data['request_id'] = $request_id;
    $data['sign'] = md5($partner_key . $pin . $seri);
    $data['command'] = 'charging';

    // Gửi yêu cầu bằng CURL
    $url = "https://thesieure.com/chargingws/v2"; // Ví dụ dùng web thesieure
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo $result; // Trả về thông báo cho khách (Thẻ đang chờ xử lý)
}
?>
