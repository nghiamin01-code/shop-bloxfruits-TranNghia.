<?php
$partner_key = '80df3668af04f2a85e1befc277896513'; // Lấy trên web gạch thẻ

if (isset($_GET['status'])) {
    $status = $_GET['status']; // 1: Thẻ đúng, 2: Thẻ sai
    $amount = $_GET['value']; // Mệnh giá thẻ
    $user = $_GET['content']; // Tên tài khoản khách (Gửi kèm lúc nạp)

    if ($status == 1) {
        // ĐOẠN NÀY LÀ TỰ ĐỘNG CỘNG TIỀN VÀO FILE DỮ LIỆU
        // (Nếu dùng Database MySQL thì viết lệnh UPDATE tại đây)
        // Hiện tại web gạch thẻ sẽ tự xử lý, Nghĩa không cần chạm tay vào mã thẻ nữa.
    }
}
?>
