<?php
// Cấu hình Firebase
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com";
$firebase_secret = "AIzaSyA5wBS88oS54yLs0OfwDYDfDQeTjc6ccdM";

// Nhận dữ liệu từ web nạp thẻ
$status = $_GET['status'] ?? '';
$amount = $_GET['amount'] ?? 0; // Số tiền nạp
$uid = $_GET['content'] ?? ''; // UID khách bạn gửi đi lúc nạp

if ($status == 'success' && !empty($uid)) {
    // 1. Lấy số dư hiện tại
    $user_json = file_get_contents($firebase_url . "/users/" . $uid . ".json");
    $user_data = json_decode($user_json, true);
    $old_balance = $user_data['balance'] ?? 0;

    // 2. Tính tiền thực nhận (Ví dụ nhận 80% mệnh giá)
    $real_amount = $amount * 0.8; 
    $new_balance = $old_balance + $real_amount;

    // 3. Cập nhật lên Firebase
    $ch = curl_init($firebase_url . "/users/" . $uid . ".json");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['balance' => $new_balance]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}
?>
