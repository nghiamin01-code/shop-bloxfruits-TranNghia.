<?php
// Nghĩa mở file callback.php trên GitHub và dán toàn bộ đoạn này vào
header('Content-Type: application/json');

// 1. THAY THÔNG TIN FIREBASE CỦA NGHĨA
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/";
$firebase_secret = "K8CsWhqcdlWJa6CESHa2VE3JH8mjxfrJLVRFZCLd";

// 2. Nhận dữ liệu từ TheGiaTot gửi về qua GET
$status = $_GET['status'];     // 1 là thẻ đúng
$request_id = $_GET['content']; // ID đơn hàng
$real_amount = $_GET['amount']; // Mệnh giá thực

if ($status == 1) { 
    // 3. TÍNH TOÁN THUẾ 20% (Cộng 80% giá trị thẻ)
    $money_to_add = $real_amount * 0.8;

    // Lấy thông tin đơn hàng từ Firebase
    $path = $firebase_url . "history_cards/" . $request_id . ".json?auth=" . $firebase_secret;
    $card_data = json_decode(file_get_contents($path), true);

    if ($card_data && $card_data['status'] == 'pending') {
        $uid = $card_data['uid'];

        // Lấy số dư cũ của khách
        $user_path = $firebase_url . "users/" . $uid . "/balance.json?auth=" . $firebase_secret;
        $current_balance = json_decode(file_get_contents($user_path), true) ?: 0;

        // Cộng tiền mới
        $new_balance = $current_balance + $money_to_add;

        // Cập nhật ví tiền khách
        $ch = curl_init($user_path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($new_balance));
        curl_exec($ch);

        // Đổi trạng thái đơn thẻ thành thành công
        $status_path = $firebase_url . "history_cards/" . $request_id . "/status.json?auth=" . $firebase_secret;
        $ch2 = curl_init($status_path);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode("success"));
        curl_exec($ch2);
        
        echo json_encode(["status" => "success", "message" => "Da cong tien"]);
    }
}
?>
