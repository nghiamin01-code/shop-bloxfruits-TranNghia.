<?php
// Cấu hình kết nối với API trùm thẻ/gạch thẻ
$partner_id = '4005762189'; // Lấy từ trang web đổi thẻ
$partner_key = '3b8e050ac8e3cd86c5d5fdf67c80bbd4'; // Lấy từ trang web đổi thẻ

if (isset($_POST['submit'])) {
    $username = $_POST['username']; // Tên tài khoản shop
    $loaithe = $_POST['type'];      // Viettel, Vinaphone...
    $menhgia = $_POST['amount'];    // 10000, 20000...
    $seri = $_POST['serial'];
    $pin = $_POST['pin'];
    
    $request_id = rand(100000, 999999); // Mã giao dịch ngẫu nhiên

    // Tạo chữ ký bảo mật (Tùy theo yêu cầu của từng API, dưới đây là dạng phổ biến)
    $sign = md5($partner_key . $pin . $seri);

    $data = array(
        'telco' => $loaithe,
        'code' => $pin,
        'serial' => $seri,
        'amount' => $menhgia,
        'request_id' => $request_id,
        'partner_id' => $partner_id,
        'sign' => $sign,
        'command' => 'charging'
    );

    // Gửi dữ liệu bằng CURL
    $ch = curl_init('https://api_ben_doi_the.com/chargingws/v2'); // Thay bằng URL API thực tế
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($result['status'] == 1) {
        echo "Gửi thẻ thành công! Vui lòng chờ duyệt.";
    } else {
        echo "Lỗi: " . $result['message'];
    }
}
?>
