<?php
// Nhận dữ liệu từ bên gạch thẻ trả về
$content = file_get_contents("php://input");
$data = json_decode($content, true);

if (isset($data['status'])) {
    $status = $data['status']; // 1 là thành công
    $request_id = $data['request_id'];
    $amount = $data['declared_value']; // Mệnh giá thẻ
    $real_amount = $amount * 0.8; // Trừ 20% thuế cho Nghĩa
    
    // Gửi lệnh cộng tiền lên Firebase (Dùng cURL để gọi Firebase API)
    if ($status == 1) {
        // Đoạn này Nghĩa cần dùng Firebase Admin SDK hoặc cURL đẩy thẳng vào nhánh /users/
        // Để đơn giản, Nghĩa có thể check mã request_id rồi cộng tiền cho khách tương ứng
    }
}
?>
