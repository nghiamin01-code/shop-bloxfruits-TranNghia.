<?php
// Cấu hình file dữ liệu
$file = 'database.json';
if (!file_exists($file)) file_put_contents($file, json_encode([]));
$db = json_decode(file_get_contents($file), true);

// Xử lý logic Duyệt/Xóa đơn
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $u = $_POST['user'];
    $i = $_POST['idx'];
    
    if ($_POST['action'] == 'bank') {
        $db[$u]['b'] += (int)$db[$u]['h'][$i]['p']; // Cộng 100% tiền bank
        $db[$u]['h'][$i]['s'] = 'Thành công';
    } elseif ($_POST['action'] == 'done') {
        $db[$u]['h'][$i]['s'] = 'Đã xong';
    } elseif ($_POST['action'] == 'del') {
        array_splice($db[$u]['h'], $i, 1);
    }
    
    file_put_contents($file, json_encode($db));
    header("Location: " . $_SERVER['PHP_SELF']); // Load lại trang để tránh gửi lại form
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>ADMIN NGHĨA - FIX 405</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-6 font-sans">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-purple-400 mb-6 uppercase border-b border-gray-700 pb-3">Quản Lý Đơn Hàng</h1>
        
        <div class="grid gap-4">
            <?php 
            $empty = true;
            foreach($db as $user => $data) {
                foreach($data['h'] as $idx => $item) {
                    if($item['s'] == 'Chờ duyệt') {
                        $empty = false;
            ?>
                <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 flex justify-between items-center shadow-lg">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-purple-600 text-[10px] px-2 py-0.5 rounded font-bold uppercase"><?php echo $user; ?></span>
                            <span class="text-xs text-gray-400"><?php echo $item['t']; ?></span>
                        </div>
                        <p class="font-bold text-lg text-white"><?php echo $item['n']; ?> - <span class="text-green-400"><?php echo number_format($item['p']); ?>đ</span></p>
                        <p class="text-xs text-yellow-400 italic">Thông tin: <?php echo htmlspecialchars($item['info']); ?></p>
                    </div>
                    
                    <form method="POST" class="flex gap-2">
                        <input type="hidden" name="user" value="<?php echo $user; ?>">
                        <input type="hidden" name="idx" value="<?php echo $idx; ?>">
                        
                        <?php if(strpos($item['n'], 'Bank') !== false): ?>
                            <button name="action" value="bank" class="bg-green-600 hover:bg-green-500 px-4 py-2 rounded-lg font-bold text-xs">DUYỆT TIỀN</button>
                        <?php else: ?>
                            <button name="action" value="done" class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-lg font-bold text-xs">XONG ĐƠN</button>
                        <?php endif; ?>
                        
                        <button name="action" value="del" class="bg-red-500/20 text-red-400 hover:bg-red-600 hover:text-white px-3 py-2 rounded-lg text-xs">XÓA</button>
                    </form>
                </div>
            <?php 
                    }
                }
            }
            if($empty) echo "<div class='text-center py-20 opacity-30 italic'>Chưa có đơn hàng nào cần duyệt, Nghĩa ơi! :))</div>";
            ?>
        </div>
    </div>
</body>
</html>
