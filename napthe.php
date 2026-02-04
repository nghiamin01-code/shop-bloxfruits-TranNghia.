<?php
// Cấu hình Firebase & API thegiatot.vn
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/";
$partner_id = '9565963734'; // Lấy Partner ID trên thegiatot.vn
$partner_key = '80df3668af04f2a85e1befc277896513'; // Lấy Partner Key trên thegiatot.vn

$pin   = $_POST['pin'] ?? '';
$seri  = $_POST['seri'] ?? '';
$telco = $_POST['telco'] ?? '';
$val   = $_POST['val'] ?? '';
$user  = $_POST['user'] ?? '';

if (empty($pin) || empty($seri) || empty($user)) {
    die(json_encode(['status' => 'error', 'msg' => 'Nhập thiếu thông tin!']));
}

$request_id = rand(100000, 999999);
$sign = md5($partner_key . $pin . $seri);

$data_post = [
    'telco' => $telco,
    'code' => $pin,
    'serial' => $seri,
    'amount' => $val,
    'request_id' => $request_id,
    'partner_id' => $partner_id,
    'sign' => $sign,
    'command' => 'charging'
];

// Gửi lên thegiatot.vn
$ch = curl_init('https://thegiatot.vn/chargingws/v2');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
$response = curl_exec($ch);
curl_close($ch);

// Lưu vào Firebase để bạn quản lý đơn
$order_data = json_encode([
    'id' => $request_id,
    'user' => $user,
    'info' => "Thẻ $telco - Mệnh giá $val",
    'status' => 'Đang chờ gạch',
    'time' => date("H:i d/m/Y")
]);
file_get_contents($firebase_url . "requests/" . $request_id . ".json", false, stream_context_create(['http' => ['method' => 'PUT', 'content' => $order_data]]));

echo $response; // Trả về thông báo của hệ thống gạch thẻ
?>
