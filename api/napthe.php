<?php
// Cấu hình từ thegiatot.vn
$partner_id = '4005762189'; 
$partner_key = '3b8e050ac8e3cd86c5d5fdf67c80bbd4'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $loaithe = $_POST['type'];
    $menhgia = $_POST['amount'];
    $seri = $_POST['serial'];
    $pin = $_POST['pin'];
    
    $request_id = rand(100000, 999999);
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

    $ch = curl_init('https://thegiatot.vn/chargingws/v2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($result['status'] == 99) {
        echo "<p style='color:green;'>Thẻ đang được duyệt cho tài khoản: $username. Vui lòng đợi!</p>";
    } else {
        echo "<p style='color:red;'>Lỗi: " . $result['message'] . "</p>";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Nhập lại tên tài khoản shop" required>
    <select name="type">
        <option value="VIETTEL">Viettel</option>
        <option value="VINAPHONE">Vinaphone</option>
        <option value="MOBIFONE">Mobifone</option>
    </select>
    <input type="number" name="amount" placeholder="Mệnh giá" required>
    <input type="text" name="serial" placeholder="Số Seri" required>
    <input type="text" name="pin" placeholder="Mã thẻ" required>
    <button type="submit">NẠP THẺ NGAY</button>
</form>
