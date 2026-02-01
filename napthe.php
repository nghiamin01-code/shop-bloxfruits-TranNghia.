<?php
// napthe.php
$partner_id = '9565963734';
$partner_key = '80df3668af04f2a85e1befc277896513';

if(isset($_POST['napthe'])) {
    $pin = $_POST['pin'];
    $seri = $_POST['seri'];
    $amount = $_POST['amount'];
    $telco = $_POST['telco'];
    $request_id = rand(10000, 99999);

    $sign = md5($partner_key . $pin . $seri);
    
    $data = array(
        'partner_id' => $partner_id,
        'telco' => $telco,
        'code' => $pin,
        'serial' => $seri,
        'amount' => $amount,
        'request_id' => $request_id,
        'sign' => $sign,
        'command' => 'charging'
    );

    // Gửi lên API đối tác
    $url = "https://partner.com/chargingws/v2"; // Link API của bên gạch thẻ
    // Thực hiện CURL gửi dữ liệu...
    echo "Trạng thái: Đang nạp thẻ - Vui lòng đợi 30s!";
}
?>
