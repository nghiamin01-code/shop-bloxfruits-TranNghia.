<?php
// Thay thông tin từ ảnh bạn gửi vào đây
$partner_id = '1438083159'; 
$partner_key = '7bff2d8f501273b89a1714eefeebb761'; 

if (isset($_POST['napthe'])) {
    $type = $_POST['type']; // Viettel, Mobifone...
    $amount = $_POST['amount']; // 10000, 20000...
    $serial = $_POST['serial'];
    $code = $_POST['code'];
    
    // Request ID: Phải gửi kèm Username để lúc sau biết cộng tiền cho ai
    // Giả sử bạn lấy username từ session sau khi khách đăng nhập shop
    $username = $_POST['username']; 
    $request_id = $username . '_' . time();

    $url = "https://thegiatot.vn/chargingws/v2?sign=" . md5($partner_key . $code . $serial) . "&telco=" . $type . "&code=" . $code . "&serial=" . $serial . "&amount=" . $amount . "&request_id=" . $request_id . "&partner_id=" . $partner_id . "&command=charging";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($res, true);

    if (isset($data['status']) && $data['status'] == '99') {
        echo "<script>alert('Gửi thẻ thành công! Đang chờ duyệt.');</script>";
    } else {
        echo "<script>alert('Lỗi: " . ($data['message'] ?? 'Không rõ nguyên nhân') . "');</script>";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Nhập lại tên tài khoản shop" required>
    <select name="type">
        <option value="VIETTEL">Viettel</option>
        <option value="VINAPHONE">Vinaphone</option>
        <option value="MOBIFONE">Mobifone</option>
        <option value="ZING">Zing</option>
    </select>
    <input type="number" name="amount" placeholder="Mệnh giá" required>
    <input type="text" name="serial" placeholder="Số Seri" required>
    <input type="text" name="code" placeholder="Mã thẻ" required>
    <button type="submit" name="napthe">NẠP THẺ NGAY</button>
</form>
