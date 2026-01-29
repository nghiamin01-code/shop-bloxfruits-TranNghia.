<?php
session_start();
require_once 'config.php';

if (isset($_POST['naptien'])) {
    // Giả sử bạn đã lưu tên người dùng vào session khi họ đăng nhập
    $username = $_SESSION['username'] ?? 'Khách'; 
    $type = $_POST['loaithe'];
    $amount = $_POST['menhgia'];
    $seri = $_POST['seri'];
    $pin = $_POST['pin'];
    $request_id = rand(100000, 999999);

    // 1. Lưu đơn nạp vào lịch sử trước (Trạng thái: cho_duyet)
    $stmt = $conn->prepare("INSERT INTO lich_su_nap (username, type, amount, seri, pin, request_id, status) VALUES (?, ?, ?, ?, ?, ?, 'cho_duyet')");
    $stmt->bind_param("ssisss", $username, $type, $amount, $seri, $pin, $request_id);
    
    if ($stmt->execute()) {
        // 2. Gửi dữ liệu sang API TheGiaiTot
        $sign = md5($partner_key . $pin . $seri);
        $data = array(
            'telco' => $type, 'code' => $pin, 'serial' => $seri,
            'amount' => $amount, 'request_id' => $request_id,
            'partner_id' => $partner_id, 'sign' => $sign, 'command' => 'charging'
        );

        $ch = curl_init('https://thegiaitot.vn/chargingws/v2');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if ($result['status'] == 99) {
            echo "<script>alert('Gửi thẻ thành công! Vui lòng chờ duyệt tự động.'); window.location='index.html';</script>";
        } else {
            echo "Lỗi từ nhà mạng: " . $result['message'];
        }
    }
}
?>
