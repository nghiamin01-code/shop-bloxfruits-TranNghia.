<?php
// napthe.php
$partner_id = '9565963734'; // ID đối tác của bạn
$partner_key = '80df3668af04f2a85e1befc277896513'; // Dán key từ ảnh bạn gửi vào đây

if(isset($_POST['pin']) && isset($_POST['serial'])) {
    $pin = $_POST['pin'];
    $seri = $_POST['serial'];
    $amount = $_POST['amount'];
    $telco = $_POST['telco'];
    $request_id = rand(100000, 999999);

    $sign = md5($partner_key . $pin . $seri);
    
    // Logic gửi dữ liệu API lên web gạch thẻ...
    echo json_encode(["status" => "success", "msg" => "Thẻ đã gửi, vui lòng đợi duyệt!"]);
}
?>
