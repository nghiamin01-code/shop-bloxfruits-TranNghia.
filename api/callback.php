<?php
// File này nhận dữ liệu từ https://thegiatot.vn gửi sang
$partner_key = '3b8e050ac8e3cd86c5d5fdf67c80bbd4'; // Phải giống key ở file napthe.php

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $request_id = $_GET['request_id'];
    $amount = $_GET['amount']; // Mệnh giá thực
    $value = $_GET['value']; // Số tiền bạn nhận được (sau chiết khấu)
    $sign = $_GET['sign'];

    // Kiểm tra chữ ký để bảo mật, tránh bị người khác hack nạp ảo
    $check_sign = md5($partner_key . $_GET['code'] . $_GET['serial']);

    if ($sign == $check_sign) {
        if ($status == 1) {
            // THÀNH CÔNG: Viết code cộng tiền vào Database của bạn ở đây
            // Ví dụ: mysqli_query($conn, "UPDATE users SET money = money + $value WHERE...");
            file_put_contents('log.txt', "Don hang $request_id THANH CONG: $value \n", FILE_APPEND);
        } else {
            // THẤT BẠI (Thẻ sai/đã dùng)
            file_put_contents('log.txt', "Don hang $request_id THAT BAI \n", FILE_APPEND);
        }
    }
}
?>
