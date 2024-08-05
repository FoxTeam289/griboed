<?php
if (isset($_GET['deviceId']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $deviceId = $_GET['deviceId'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];

    $directory = 'locations';
    if (!is_dir($directory)) {
        mkdir($directory);
    }

    $file = $directory . '/' . $deviceId . '.json';

    // Write the new location to the file
    $locationData = [
        'deviceId' => $deviceId,
        'latitude' => $latitude,
        'longitude' => $longitude,
    ];

    file_put_contents($file, json_encode($locationData));

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}
?>
