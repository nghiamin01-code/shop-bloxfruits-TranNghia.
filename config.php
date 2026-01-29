<?php
$host = 'localhost';
$user = 'root'; // Tên người dùng database
$pass = '';     // Mật khẩu database
$db_name = 'shop_blox_fruit'; // Tên database của bạn

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

// Thông tin API TheGiaiTot
$partner_id = '9584512314'; 
$partner_key = 'ed7bd71a513252bbd4d5432aa26c7a25'; 
?>
