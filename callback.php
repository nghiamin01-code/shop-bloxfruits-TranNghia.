<?php
// callback.php
$partner_key = '80df3668af04f2a85e1befc277896513';

$status = $_POST['status']; 
$amount = $_POST['amount'];
$real_value = $_POST['value']; // Tiền sau khi web gạch thẻ trừ phí
$request_id = $_POST['request_id'];
$callback_sign = $_POST['callback_sign'];

$check_sign = md5($partner_key . $status . $amount . $real_value . $request_id);

if ($callback_sign == $check_sign && $status == 1) {
    // THUẾ 20% CỦA SHOP NGHĨA
    $money_for_user = $amount * 0.8; 
    // SQL: UPDATE users SET money = money + $money_for_user WHERE username = ...
    file_put_contents('log.txt', "Thanh cong ID $request_id | Thuc nhan: $money_for_user\n", FILE_APPEND);
}
?>
