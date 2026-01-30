<?php
header('Content-Type: application/json');

// 1. CẤU HÌNH FIREBASE
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/";
// Lấy Secret Key trong Firebase -> Project Settings -> Service Accounts -> Database Secrets
$firebase_secret = "K8CsWhqcdlWJa6CESHa2VE3JH8mjxfrJLVRFZCLd";

// 2. NHẬN DỮ LIỆU TRẢ VỀ TỪ THEGIATOT
$status = $_GET['status'];       // 1 là thẻ đúng
$request_id = $_GET['content'];   // Mã đơn hàng mình đã tạo ở index.html
$real_amount = $_GET['amount'];   // Mệnh giá thẻ thực tế

if ($status == 1) { 
    // TÍNH TOÁN CỘNG TIỀN (Thuế 20% -> Khách nhận 80%)
    $money_to_add = $real_amount * 0.8;

    // Tìm thông tin người nạp trong Firebase
    $path = $firebase_url . "history_cards/" . $request_id . ".json?auth=" . $firebase_secret;
    $card_json = file_get_contents($path);
    $card_data = json_decode($card_json, true);

    if ($card_data && $card_data['status'] == 'pending') {
        $uid = $card_data['uid'];

        // 3. LẤY SỐ DƯ CŨ VÀ CỘNG TIỀN MỚI
        $user_path = $firebase_url . "users/" . $uid . "/balance.json?auth=" . $firebase_secret;
        $current_balance = json_decode(file_get_contents($user_path), true) ?: 0;
        $new_balance = $current_balance + $money_to_add;

        // Cập nhật số dư mới vào ví của khách
        $ch = curl_init($user_path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($new_balance));
        curl_exec($ch);

        // 4. ĐỔI TRẠNG THÁI THẺ THÀNH THÀNH CÔNG (SUCCESS)
        $status_path = $firebase_url . "history_cards/" . $request_id . "/status.json?auth=" . $firebase_secret;
        $ch2 = curl_init($status_path);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode("success"));
        curl_exec($ch2);
        
        echo json_encode(["status" => "success", "msg" => "Da cong $money_to_add vao tai khoan"]);
    }
} else {
    // Nếu thẻ sai, Nghĩa có thể đổi trạng thái thành 'error'
    $status_path = $firebase_url . "history_cards/" . $request_id . "/status.json?auth=" . $firebase_secret;
    $ch2 = curl_init($status_path);
    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode("error"));
    curl_exec($ch2);
}
?>
