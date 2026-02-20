<?php
/**
 * Tệp xử lý gửi thẻ nạp lên API gạch thẻ
 * Bạn cần thay đổi PARTNER_ID và PARTNER_KEY theo nhà cung cấp của bạn.
 */

// Cấu hình kết nối API (Thay đổi thông tin này)
$partner_id = '3953165673'; 
$partner_key = '9f26460000efd5a619e809a852225b98';
$api_url = 'https://thesieure.com/chargingws/v2'; // Ví dụ URL API của TheSieuRe

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telco = $_POST['telco'];     // Nhà mạng (VIETTEL, VINAPHONE, MOBIFONE...)
    $amount = $_POST['amount'];   // Mệnh giá (10000, 20000...)
    $serial = $_POST['serial'];   // Số seri thẻ
    $pin = $_POST['pin'];         // Mã thẻ
    $request_id = rand(100000, 999999) . time(); // Mã giao dịch duy nhất

    // Tạo chữ ký (Signature) - Cách tạo tùy thuộc vào từng web gạch thẻ
    $sign = md5($partner_key . $pin . $serial);

    $data = array(
        'telco' => $telco,
        'code' => $pin,
        'serial' => $serial,
        'amount' => $amount,
        'request_id' => $request_id,
        'partner_id' => $partner_id,
        'sign' => $sign,
        'command' => 'charging'
    );

    // Sử dụng CURL để gửi dữ liệu
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['status'])) {
        if ($result['status'] == 99) {
            echo json_encode(['status' => 'success', 'message' => 'Gửi thẻ thành công, vui lòng đợi duyệt.']);
            // Lưu giao dịch vào Database với trạng thái 'pending' tại đây
        } else {
            echo json_encode(['status' => 'error', 'message' => $result['message']]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không thể kết nối tới máy chủ gạch thẻ.']);
    }
}
?>
