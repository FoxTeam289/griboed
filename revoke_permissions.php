<?php
if (isset($_GET['deviceId'])) {
    $deviceId = $_GET['deviceId'];
    $directory = 'locations';

    // Remove the JSON file for the device
    $file = $directory . '/' . $deviceId . '.json';
    if (file_exists($file)) {
        unlink($file);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Device not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}
?>
