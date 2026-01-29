<?php
require_once 'config.php';

// Kiểm tra xem có dữ liệu POST từ TheGiaiTot gửi về không
if (isset($_POST['status']) && isset($_POST['request_id'])) {
    $status = $_POST['status']; 
    $request_id = $_POST['request_id'];
    $amount = $_POST['amount']; // Số tiền thực tế của thẻ

    if ($status == 1) {
        // 1. Tìm đơn hàng trong bảng 'napthe' dựa trên request_id
        $result = mysqli_query($conn, "SELECT username FROM lich_su_nap WHERE request_id = '$request_id' AND status = 'cho_duyet'");
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $username = $row['username'];

            // 2. Cộng tiền vào tài khoản người dùng
            mysqli_query($conn, "UPDATE users SET money = money + $amount WHERE username = '$username'");

            // 3. Cập nhật trạng thái đơn nạp thành 'thành công'
            mysqli_query($conn, "UPDATE lich_su_nap SET status = 'thanh_cong' WHERE request_id = '$request_id'");
        }
    } else {
        // Thẻ sai: Cập nhật trạng thái thất bại
        mysqli_query($conn, "UPDATE lich_su_nap SET status = 'that_bai' WHERE request_id = '$request_id'");
    }
}
?>
