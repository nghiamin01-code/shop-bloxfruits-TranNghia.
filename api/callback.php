<?php
/**
 * FILE: api/napthe.php
 * Chức năng: Nhận dữ liệu từ nap_the.html và đẩy lên hệ thống Gạch Thẻ
 */

// Cho phép các request từ bên ngoài (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 1. Cấu hình API của trùm nạp thẻ (Thay thông tin của bạn vào đây)
$api_url = "https://thesieure.com/chargingws/v2"; // Ví dụ URL API của TheSieuRe
$partner_id = "9565963734"; // Partner ID của bạn
$partner_key = "80df3668af04f2a85e1befc277896513"; // Partner Key của bạn

// 2. Nhận dữ liệu JSON từ trang HTML gửi sang
$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(["status" => 99, "message" => "Không nhận được dữ liệu thẻ"]);
    exit;
}

// 3. Chuẩn bị các thông số cần thiết
$type = $data->provider;    // Nhà mạng (VIETTEL, VINAPHONE...)
$amount = $data->amount;    // Mệnh giá
$pin = $data->pin;          // Mã thẻ
$serial = $data->serial;    // Số seri
$request_id = rand(100000, 999999) . time(); // Mã giao dịch duy nhất

// Tạo chữ ký (Signature) theo chuẩn TheSieuRe: md5(partner_key + pin + serial)
$sign = md5($partner_key . $pin . $serial);

// 4. Cấu hình mảng dữ liệu gửi lên Web Nạp Thẻ
$content = [
    'sign'       => $sign,
    'telco'      => $type,
    'code'       => $pin,
    'serial'     => $serial,
    'amount'     => $amount,
    'request_id' => $request_id,
    'partner_id' => $partner_id,
    'command'    => 'charging'
];

// 5. Sử dụng CURL để đẩy dữ liệu lên Web Nạp Thẻ
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 6. Xử lý phản hồi và trả về cho người dùng
if ($httpCode == 200) {
    $result = json_decode($response, true);
    
    if (isset($result['status'])) {
        // Status 99 thường là "Thẻ đang chờ duyệt"
        if ($result['status'] == 1 || $result['status'] == 99) {
            echo json_encode([
                "status" => 1, 
                "message" => "Gửi thẻ thành công! Kết quả sẽ được cập nhật sau ít phút.",
                "request_id" => $request_id
            ]);
        } else {
            echo json_encode([
                "status" => 0, 
                "message" => "Lỗi: " . ($result['message'] ?? "Thông tin thẻ không hợp lệ")
            ]);
        }
    } else {
        echo json_encode(["status" => 0, "message" => "Phản hồi từ server không đúng định dạng"]);
    }
} else {
    echo json_encode(["status" => 0, "message" => "Không thể kết nối tới server nạp thẻ (Mã lỗi: $httpCode)"]);
}
?>
