<?php
$dbFile = 'database.json';
$db = json_decode(file_get_contents($dbFile), true);

if (isset($_POST['do_action'])) {
    $u = $_POST['target_user'];
    $i = $_POST['target_idx'];
    
    if ($_POST['do_action'] == 'bank') {
        $db[$u]['b'] += $db[$u]['h'][$i]['p']; // Cộng 100% tiền
        $db[$u]['h'][$i]['s'] = 'Thành công';
    } elseif ($_POST['do_action'] == 'done') {
        $db[$u]['h'][$i]['s'] = 'Đã xong';
    } elseif ($_POST['do_action'] == 'del') {
        array_splice($db[$u]['h'], $i, 1);
    }
    file_put_contents($dbFile, json_encode($db));
    header("Location: quan-ly-nghia.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ADMIN NGHĨA - ĐÃ FIX LỖI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-5">
    <h1 class="text-xl font-bold mb-5 text-purple-400">DANH SÁCH ĐƠN CHỜ DUYỆT</h1>
    <div class="space-y-3">
        <?php foreach($db as $user => $data): ?>
            <?php foreach($data['h'] as $idx => $item): ?>
                <?php if($item['s'] == 'Chờ duyệt'): ?>
                <div class="bg-gray-800 p-4 rounded-lg flex justify-between border border-gray-700">
                    <div>
                        <b class="text-blue-400"><?php echo $user; ?></b>: <?php echo $item['n']; ?> - <?php echo number_format($item['p']); ?>đ
                        <p class="text-xs text-yellow-500">Thông tin: <?php echo $item['info']; ?></p>
                    </div>
                    <form method="POST" class="flex gap-2">
                        <input type="hidden" name="target_user" value="<?php echo $user; ?>">
                        <input type="hidden" name="target_idx" value="<?php echo $idx; ?>">
                        <?php if(strpos($item['n'], 'Bank') !== false): ?>
                            <button name="do_action" value="bank" class="bg-green-600 px-3 py-1 rounded text-xs font-bold">DUYỆT TIỀN</button>
                        <?php else: ?>
                            <button name="do_action" value="done" class="bg-blue-600 px-3 py-1 rounded text-xs font-bold">XONG ĐƠN</button>
                        <?php endif; ?>
                        <button name="do_action" value="del" class="bg-red-600 px-3 py-1 rounded text-xs">XÓA</button>
                    </form>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>
