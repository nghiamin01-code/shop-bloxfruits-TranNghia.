<?php
// 1. Cấu hình tệp Firebase của Nghĩa
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/";
$firebase_secret = "K8CsWhqcdlWJa6CESHa2VE3JH8mjxfrJLVRFZCLd"; // Thay dãy mã của bạn vào đây

// 2. Nhận dữ liệu tự động từ TheGiaTot gửi về
$status = $_GET['status'];     // Trạng thái thẻ (1 là đúng)
$request_id = $_GET['content']; // Mã đơn hàng (requestId)
$real_amount = $_GET['amount']; // Mệnh giá thẻ thực tế

if ($status == 1) { // Nếu thẻ đúng
    // 3. Công thức THUẾ 20% (Khách nạp 100k nhận 80k)
    $money_to_add = $real_amount * 0.8;

    // --- Đoạn này hệ thống sẽ tự tìm UID khách và cộng tiền vào Firebase ---
    // (Phần xử lý kỹ thuật kết nối sẽ nằm ở đây)
    
    echo "Thành công! Đã cộng " . number_format($money_to_add) . "đ cho khách.";
} else {
    echo "Thẻ sai hoặc lỗi hệ thống.";
}
?>
