<?php
if (isset($_GET['deviceId'])) {
    $deviceId = $_GET['deviceId'];
    $directory = 'locations';

    // Find the JSON file for the device
    $file = $directory . '/' . $deviceId . '.json';

    if (file_exists($file)) {
        $locationData = json_decode(file_get_contents($file), true);
        echo json_encode(['success' => true, 'location' => $locationData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Device not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}
?>
