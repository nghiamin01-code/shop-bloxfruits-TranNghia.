<?php
// callback.php - Xử lý kết quả từ hệ thống gạch thẻ
$partner_key = 'KEY_CUA_NGHIA_TAI_DAY'; // Dán key của Nghĩa vào đây

$status = $_POST['status']; 
$amount = $_POST['amount']; // Mệnh giá thẻ nạp
$request_id = $_POST['request_id'];
$callback_sign = $_POST['callback_sign'];

$check_sign = md5($partner_key . $status . $amount . $request_id);

if ($callback_sign == $check_sign && $status == 1) {
    // TÍNH TOÁN THUẾ 20%: Khách nạp 10,000đ nhận 8,000đ
    $real_receive = $amount * 0.8; 
    
    // Lưu lịch sử nạp tiền thực nhận vào hệ thống
    $log_data = "ID: $request_id | Mệnh giá: $amount | Thực nhận: $real_receive\n";
    file_put_contents('naptien_success.txt', $log_data, FILE_APPEND);
    
    echo "SUCCESS";
}
?>
