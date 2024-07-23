<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $deviceId = $_GET['deviceId'];

    $filename = "locations/$deviceId.json";
    if (file_exists($filename)) {
        $data = json_decode(file_get_contents($filename), true);
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Location not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
