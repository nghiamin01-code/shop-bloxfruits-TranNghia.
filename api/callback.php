<?php
$partner_key = '3b8e050ac8e3cd86c5d5fdf67c80bbd4'; // Phải trùng với key ở file napthe.php

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $request_id = $_GET['request_id'];
    $declared_value = $_GET['declared_value']; // Mệnh giá gửi lên
    $value = $_GET['value']; // Mệnh giá thực của thẻ
    $amount = $_GET['amount']; // Tiền nhận được sau chiết khấu
    $sign = $_GET['sign'];

    // Kiểm tra chữ ký bảo mật từ Thegiatot gửi về
    $check_sign = md5($partner_key . $_GET['code'] . $_GET['serial']);

    if ($sign == $check_sign) {
        if ($status == 1) {
            // THÀNH CÔNG -> Tại đây bạn viết lệnh cộng tiền vào database shop
            // Ví dụ: file_put_contents('history.txt', "User: $request_id | +$amount \n", FILE_APPEND);
        } else {
            // THẤT BẠI (Thẻ sai/đã dùng)
        }
    }
}
?>
