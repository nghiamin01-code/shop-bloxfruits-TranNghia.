<?php
/**
 * Tệp xử lý kết quả trả về (Callback) từ nhà mạng
 * Hệ thống gạch thẻ sẽ gọi tệp này sau khi thẻ được duyệt thành công hoặc thất bại.
 */

// Cấu hình (Phải trùng với napthe.php)
$partner_key = '9f26460000efd5a619e809a852225b98';

// Nhận dữ liệu từ nhà mạng gửi về (GET hoặc POST tùy nhà mạng)
$content = $_REQUEST;

if (isset($content['status']) && isset($content['request_id'])) {
    
    $status = $content['status'];         // 1: Thành công, 2: Sai mệnh giá, 3: Thẻ lỗi, 4: Bảo trì
    $request_id = $content['request_id']; // Mã giao dịch đã gửi đi
    $declared_value = $content['declared_value']; // Mệnh giá gửi lên
    $real_value = $content['value'];      // Mệnh giá thực tế của thẻ
    $amount = $content['amount'];         // Số tiền thực nhận sau khi trừ chiết khấu
    $callback_sign = $content['sign'];    // Chữ ký để xác thực bảo mật

    // Kiểm tra chữ ký để đảm bảo dữ liệu gửi từ nhà mạng thật, tránh bị hack nạp ảo
    $check_sign = md5($partner_key . $content['code'] . $content['serial']);

    if ($callback_sign == $check_sign) {
        // Kết nối Database của bạn tại đây
        // $conn = mysqli_connect("localhost", "user", "pass", "db_name");

        if ($status == 1) {
            // THÀNH CÔNG: Cộng tiền cho người dùng trong Database
            // Cập nhật trạng thái đơn hàng thành 'completed'
            // file_put_contents('log_naptietsuccess.txt', "Thanh cong: $request_id | $amount");
        } else {
            // THẤT BẠI: Cập nhật trạng thái đơn hàng thành 'failed'
            // file_put_contents('log_naptieterror.txt', "Loi: $request_id | Status: $status");
        }
        
        // Trả về thông báo cho server gạch thẻ biết đã nhận được dữ liệu
        echo "OK"; 
    } else {
        echo "Invalid Signature";
    }
} else {
    echo "No Data Received";
}
?>
