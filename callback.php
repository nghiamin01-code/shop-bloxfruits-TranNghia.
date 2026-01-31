<?php
// --- CẤU HÌNH FIREBASE CỦA NGHĨA ---
$FIREBASE_URL = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com";

// Nhận dữ liệu từ phía đối tác gạch thẻ gửi về
$status = $_GET['status'] ?? null;      // Trạng thái thẻ (1 là thành công)
$amount = $_GET['amount'] ?? 0;         // Mệnh giá thực nhận
$uid = $_GET['content'] ?? null;        // UID của khách (được truyền vào lúc nạp)
$request_id = $_GET['request_id'] ?? null; // Mã đơn hàng

// Kiểm tra nếu thẻ đúng (status = 1) và có UID khách
if ($status == 1 && $uid) {
    
    // 1. Kết nối lấy số dư hiện tại của khách
    $user_url = $FIREBASE_URL . "/users/" . $uid . ".json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $user_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $user_data = json_decode($response, true);

    if ($user_data) {
        // 2. Tính toán số dư mới
        $old_balance = isset($user_data['balance']) ? $user_data['balance'] : 0;
        $new_balance = $old_balance + $amount;

        // 3. Cập nhật số dư mới lên Firebase
        curl_setopt($ch, CURLOPT_URL, $user_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['balance' => $new_balance]));
        curl_exec($ch);

        // 4. Cập nhật trạng thái đơn hàng trong Lịch sử thành "Thành công"
        // Nghĩa cần tìm đúng key của đơn hàng trong history để update (nếu cần chi tiết hơn)
        
        // Ghi log để Nghĩa kiểm tra khi cần
        file_put_contents("log_napthe.txt", "Thanh cong: UID $uid nap $amount vao " . date("H:i:s d/m/Y") . "\n", FILE_APPEND);
    }
    curl_close($ch);
}
?>
