<?php
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/";
$partner_key = '80df3668af04f2a85e1befc277896513'; // Phải khớp với key trên thegiatot.vn

if (isset($_GET['status'])) {
    $status = $_GET['status']; // 1: Thẻ đúng, 2: Thẻ sai
    $amount = $_GET['value'];  // Mệnh giá thẻ
    $user   = $_GET['content']; // Tên tài khoản khách đã gửi lúc nạp

    if ($status == 1) {
        // Tỷ lệ thực nhận (Sau khi trừ thuế web gạch thẻ)
        // Nếu web thu 20%, khách nhận 80% thì nhân 0.8
        $real_receive = $amount * 0.8; 

        // 1. Lấy số dư cũ của khách từ Firebase
        $user_data = file_get_contents($firebase_url . "users/" . $user . ".json");
        $user_json = json_decode($user_data, true);
        $old_balance = $user_json['balance'] ?? 0;

        // 2. Cộng tiền mới
        $new_balance = $old_balance + $real_receive;

        // 3. Cập nhật lại lên Firebase
        $ch = curl_init($firebase_url . "users/" . $user . ".json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['balance' => $new_balance]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);
        curl_close($ch);
        
        // Ghi log để Nghĩa kiểm tra
        file_put_contents("lich_su_nap.txt", "User: $user | + $real_receive | ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
    }
}
?>
