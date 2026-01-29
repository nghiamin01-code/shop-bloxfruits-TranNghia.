<?php
require_once 'config.php';

if (isset($_POST['status'])) {
    $status = $_POST['status']; 
    $request_id = $_POST['request_id'];
    $amount = $_POST['amount']; // Mệnh giá thực

    if ($status == 1) { // Thẻ đúng
        // Tìm xem đơn hàng này của ai
        $result = mysqli_query($conn, "SELECT username FROM lich_su_nap WHERE request_id = '$request_id' AND status = 'cho_duyet'");
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $user = $row['username'];
            // Cộng tiền cho khách
            mysqli_query($conn, "UPDATE users SET money = money + $amount WHERE username = '$user'");
            // Cập nhật trạng thái đơn thành công
            mysqli_query($conn, "UPDATE lich_su_nap SET status = 'thanh_cong' WHERE request_id = '$request_id'");
        }
    } else {
        // Thẻ sai
        mysqli_query($conn, "UPDATE lich_su_nap SET status = 'that_bai' WHERE request_id = '$request_id'");
    }
}
?>
