<?php
// Cấu hình thông tin từ THEGIATOT.VN
$partner_id = '4005762189'; // Lấy tại mục Tích hợp API trên web thegiatot
$partner_key = '3b8e050ac8e3cd86c5d5fdf67c80bbd4'; // Lấy tại mục Tích hợp API trên web thegiatot

if (isset($_POST['napthe'])) {
    $username = $_POST['username'];
    $loaithe = $_POST['type'];
    $menhgia = $_POST['amount'];
    $seri = $_POST['serial'];
    $pin = $_POST['pin'];
    $request_id = rand(100000, 999999); // Mã đơn hàng ngẫu nhiên

    // Tạo chữ ký bảo mật theo yêu cầu của Thegiatot
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

    // Gửi dữ liệu qua CURL
    $ch = curl_init('https://thegiatot.vn/chargingws/v2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($result['status'] == 99) {
        echo "<script>alert('Gửi thẻ thành công, vui lòng đợi duyệt!');</script>";
    } else {
        echo "<script>alert('Lỗi: " . $result['message'] . "');</script>";
    }
}
?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Nhập lại tên tài khoản shop" required>
    <select name="type">
        <option value="VIETTEL">Viettel</option>
        <option value="VINAPHONE">Vinaphone</option>
        <option value="MOBIFONE">Mobifone</option>
        <option value="ZING">Zing</option>
    </select>
    <input type="number" name="amount" placeholder="Mệnh giá" required>
    <input type="text" name="serial" placeholder="Số Seri" required>
    <input type="text" name="pin" placeholder="Mã thẻ" required>
    <button type="submit" name="napthe">NẠP THẺ NGAY</button>
</form>
