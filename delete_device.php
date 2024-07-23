<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deviceId = $_POST['deviceId'];
    $filename = "locations/$deviceId.json";

    if (file_exists($filename)) {
        unlink($filename);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Device not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
