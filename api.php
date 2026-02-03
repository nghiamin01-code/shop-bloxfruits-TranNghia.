<?php
$dbFile = 'database.json';
if (!file_exists($dbFile)) file_put_contents($dbFile, json_encode([]));
$db = json_decode(file_get_contents($dbFile), true);

$action = $_POST['action'] ?? '';

if ($action == 'submit_order') {
    $user = $_POST['user'];
    if (!isset($db[$user])) $db[$user] = ['b' => 0, 'h' => []];
    
    $newOrder = [
        'n' => $_POST['name'],
        'p' => $_POST['price'],
        't' => date('H:i d/m/Y'),
        's' => 'Chờ duyệt',
        'info' => $_POST['info']
    ];
    
    // Nếu là đơn mua thì trừ tiền luôn
    if (strpos($_POST['name'], 'Bank') === false) {
        $db[$user]['b'] -= $_POST['price'];
    }
    
    $db[$user]['h'][] = $newOrder;
    file_put_contents($dbFile, json_encode($db));
    echo json_encode(['status' => 'success', 'balance' => $db[$user]['b']]);
}

if ($action == 'get_data') {
    $user = $_POST['user'];
    echo json_encode($db[$user] ?? ['b' => 0, 'h' => []]);
}
?>
