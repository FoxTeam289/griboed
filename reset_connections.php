<?php
if (isset($_GET['deviceId'])) {
    $deviceId = $_GET['deviceId'];

    foreach (glob("locations/*.json") as $file) {
        $locationData = json_decode(file_get_contents($file), true);
        if (isset($locationData['targetDeviceId']) && $locationData['targetDeviceId'] == $deviceId) {
            unlink($file);
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}
?>
