<?php
header('Content-Type: application/json');

// --- CẤU HÌNH ---
$partner_id = '9565963734'; // Lấy trên thesieure
$partner_key = '80df3668af04f2a85e1befc277896513'; // Lấy trên thesieure

if ($_POST) {
    $telco = $_POST['telco'];
    $amount = $_POST['val'];
    $pin = $_POST['pin'];
    $seri = $_POST['seri'];
    $user = $_POST['user'];
    $request_id = rand(100000, 999999); // Mã đơn hàng ngẫu nhiên

    $data = array(
        'telco' => $telco,
        'code' => $pin,
        'serial' => $seri,
        'amount' => $amount,
        'request_id' => $request_id,
        'partner_id' => $partner_id,
        'sign' => md5($partner_key . $pin . $seri)
    );

    $ch = curl_init('https://thesieure.com/chargingws/v2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    // Lưu tạm đơn chờ duyệt vào file hoặc log (ở đây mình trả về cho JS xử lý tiếp)
    echo $response;
}
?>
