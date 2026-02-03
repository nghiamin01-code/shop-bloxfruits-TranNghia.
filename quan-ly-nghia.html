<?php
// Đọc dữ liệu từ file json chung
$dbFile = 'database.json';
$data = json_decode(file_get_contents($dbFile), true);

// Xử lý khi Nghĩa bấm Duyệt
if(isset($_POST['action'])) {
    $user = $_POST['user'];
    $idx = $_POST['idx'];
    
    if($_POST['action'] == 'approve_bank') {
        $amount = $_POST['amount'];
        $data[$user]['b'] += $amount;
        $data[$user]['h'][$idx]['s'] = "Thành công";
    } elseif($_POST['action'] == 'done') {
        $data[$user]['h'][$idx]['s'] = "Đã xong";
    }
    file_put_contents($dbFile, json_encode($data));
    header("Location: quan-ly-nghia.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ADMIN CHÍNH THỨC - NGHĨA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white p-8">
    <h1 class="text-2xl font-bold text-purple-400 mb-6 uppercase">Hệ Thống Duyệt Đơn Tập Trung</h1>
    
    <div class="space-y-4">
        <?php foreach($data as $username => $info): ?>
            <?php foreach($info['h'] as $index => $item): ?>
                <?php if($item['s'] == "Chờ duyệt"): ?>
                    <div class="bg-slate-800 p-4 rounded-xl border border-white/10 flex justify-between items-center">
                        <div>
                            <span class="text-green-400 font-bold">[<?php echo $username; ?>]</span>
                            <span class="mx-2">-</span>
                            <span><?php echo $item['n']; ?> (<?php echo number_format($item['p']); ?>đ)</span>
                            <p class="text-xs text-gray-400">Info: <?php echo $item['info'] ?? 'Nạp Bank'; ?></p>
                        </div>
                        <form method="POST" class="flex gap-2">
                            <input type="hidden" name="user" value="<?php echo $username; ?>">
                            <input type="hidden" name="idx" value="<?php echo $index; ?>">
                            
                            <?php if(strpos($item['n'], 'Bank') !== false): ?>
                                <input type="hidden" name="amount" value="<?php echo $item['p']; ?>">
                                <button name="action" value="approve_bank" class="bg-green-600 px-4 py-2 rounded font-bold">DUYỆT TIỀN</button>
                            <?php else: ?>
                                <button name="action" value="done" class="bg-blue-600 px-4 py-2 rounded font-bold">XONG ĐƠN</button>
                            <?php endif; ?>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>
