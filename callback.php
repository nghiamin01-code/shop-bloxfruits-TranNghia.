<?php
// FIREBASE CỦA NGHĨA
$FIREBASE_URL = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com";

$trạng_thái = $_GET['status'] ?? null; // Trạng thái thẻ
$số_lượng = $_GET['amount'] ?? 0;      // Mệnh giá thẻ thực nhận
$uid = $_GET['content'] ?? null;      // UID người nạp (truyền qua content)

if ($trạng_thái == 1 && $uid) {
    // 1. Lấy thông tin khách hàng từ Firebase
    $url = $FIREBASE_URL . "/users/" . $uid . ".json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $user = json_decode($response, true);

    if ($user) {
        // Tính toán số dư mới (cộng thêm số tiền thực nhận sau chiết khấu)
        $new_balance = ($user['balance'] ?? 0) + $số_lượng;

        // 2. Cập nhật số dư lên Firebase
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['balance' => $new_balance]));
        curl_exec($ch);
        
        // Ghi nhật ký nạp thành công
        file_put_contents("nap_the_log.txt", "Thành công: UID $uid nạp $số_lượng vào lúc " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);
    }
    curl_close($ch);
}
?>
