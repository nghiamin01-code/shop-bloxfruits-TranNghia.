<?php
// --- CẤU HÌNH FIREBASE ---
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/"; // Link Firebase của Shop

// Nhận dữ liệu từ thegiatot.vn trả về qua phương thức GET (theo ảnh bạn gửi)
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $request_id = $_GET['request_id'];
    $amount_real = $_GET['amount']; // Mệnh giá thực nhận

    // Tách lấy username từ request_id (username_time)
    $parts = explode('_', $request_id);
    $username = $parts[0];

    // Status = 1 thường là thẻ đúng (Bạn nên check lại tài liệu bên thegiatot để chắc chắn)
    if ($status == '1') {
        
        // 1. Lấy tiền hiện tại của user từ Firebase
        $fb_user_path = $firebase_url . "/users/" . $username . "/balance.json";
        $current_money = json_decode(file_get_contents($fb_user_path));
        if (!$current_money) $current_money = 0;

        // 2. Cộng tiền mới
        $new_money = $current_money + intval($amount_real);

        // 3. Cập nhật lên Firebase
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fb_user_path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($new_money));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        
        // Ghi log đơn nạp thành công
        file_put_contents('log_nap_the.txt', "User: $username - Nap: $amount_real - Thanh cong\n", FILE_APPEND);
    }
}
?>
