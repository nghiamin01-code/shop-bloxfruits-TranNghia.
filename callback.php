<?php
// FIREBASE URL CỦA NGHĨA
$FIREBASE_URL = "https://shop-blox-fruit-trannghia-default-rtdb.firebaseio.com";

$status = $_GET['status'] ?? null;
$amount = $_GET['amount'] ?? 0;
$uid = $_GET['content'] ?? null;

if ($status == 1 && $uid) {
    // 1. Lấy ví khách
    $url = $FIREBASE_URL . "/users/" . $uid . ".json";
    $user = json_decode(file_get_contents($url), true);
    
    if ($user) {
        $new_balance = ($user['balance'] ?? 0) + $amount;
        
        // 2. Cập nhật số dư qua PATCH
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['balance' => $new_balance]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        
        file_put_contents("nap_the_log.txt", "SUCCESS: Khach $uid nap $amount luc " . date("H:i:s") . "\n", FILE_APPEND);
    }
}
?>
