<?php
// 1. Cấu hình Firebase của bạn (Lấy từ file index của bạn)
$firebase_url = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com/"; // Link Database Firebase

if (isset($_POST['status']) && isset($_POST['request_id'])) {
    $status = $_POST['status']; 
    $request_id = $_POST['request_id'];
    $amount = $_POST['amount'];

    // Xác định trạng thái mới để cập nhật lên Admin
    $new_status = ($status == 1) ? "done" : "error"; 

    // 2. Tìm và cập nhật đơn hàng trên Firebase dựa vào request_id
    // Lưu ý: Bạn cần dùng mã hóa Secret Key của Firebase hoặc để Database ở chế độ Public để PHP ghi được dữ liệu.
    
    $update_data = json_encode([
        'status' => $new_status,
        'update_at' => time()
    ]);

    // Gửi lệnh cập nhật đến Firebase (Giả sử bạn lưu thẻ trong thư mục 'napthe')
    $ch = curl_init($firebase_url . "napthe/" . $request_id . ".json");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $update_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // 3. Thông báo về Discord để bạn biết
    $webhook_url = "https://discord.com/api/webhooks/1466332057817841782/Xf0GRTpyu0VDRgd1b8JI4w5sGsdgU1MW2qmRA3W2AXoVQhlTG80lDVqCLsaxuGRnK6El";
    $msg = ($status == 1) ? "✅ Thẻ $request_id ĐÚNG. Đã tự duyệt trên Admin!" : "❌ Thẻ $request_id SAI.";
    
    $discord_data = json_encode(['content' => $msg]);
    $ch_dis = curl_init($webhook_url);
    curl_setopt($ch_dis, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch_dis, CURLOPT_POST, 1);
    curl_setopt($ch_dis, CURLOPT_POSTFIELDS, $discord_data);
    curl_exec($ch_dis);
    curl_close($ch_dis);
}
?>
