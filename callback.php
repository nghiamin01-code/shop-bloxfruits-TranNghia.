<?php
$partner_key = '80df3668af04f2a85e1befc277896513'; // Phải khớp với key ở file napthe.php

if (isset($_GET['status'])) {
    $status = $_GET['status']; // 1 là thành công
    $request_id = $_GET['request_id'];
    $amount = $_GET['value']; // Mệnh giá thẻ thực tế
    $sign = $_GET['sign'];

    // Kiểm tra chữ ký bảo mật để tránh người khác hack tiền
    $my_sign = md5($partner_key . $_GET['code'] . $_GET['serial']);
    
    if ($status == 1) {
        // CODE CỘNG TIỀN TẠI ĐÂY
        // Bạn sẽ viết lệnh SQL để cộng $amount vào username tương ứng trong database
        // Ví dụ: UPDATE users SET balance = balance + $amount WHERE username = ...
        
        file_put_contents('log_nap_the.txt', "Thành công: Đơn $request_id nhận $amount \n", FILE_APPEND);
    } else {
        file_put_contents('log_nap_the.txt', "Thất bại: Đơn $request_id \n", FILE_APPEND);
    }
}
?>
