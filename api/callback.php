<?php
// Nhận dữ liệu từ phía đối tác gửi về
$status = $_GET['status']; // Trạng thái thẻ
$message = $_GET['message']; 
$request_id = $_GET['request_id']; // Mã GD bạn đã gửi đi
$declared_value = $_GET['declared_value']; // Mệnh giá bạn gửi lên
$value = $_GET['value']; // Mệnh giá thực của thẻ
$amount = $_GET['amount']; // Số tiền bạn nhận được sau chiết khấu
$code = $_GET['code'];
$serial = $_GET['serial'];

// Kiểm tra nếu thẻ đúng (Status = 1 là thành công ở đa số API)
if ($status == 1) {
    /* TẠI ĐÂY BẠN VIẾT CODE ĐỂ CỘNG TIỀN CHO USER
       Ví dụ: UPDATE users SET money = money + $amount WHERE username = '...'
    */
    
    // Ghi log để kiểm tra
    file_put_contents('log_napthe.txt', "Thẻ $serial thành công: + $amount \n", FILE_APPEND);
} else {
    // Thẻ sai, thẻ ảo hoặc sai mệnh giá
    file_put_contents('log_napthe.txt', "Thẻ $serial thất bại: $message \n", FILE_APPEND);
}

// Trả về kết quả cho phía API biết là bạn đã nhận được dữ liệu
echo json_encode(['status' => 200]); 
?>
