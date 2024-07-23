<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deviceId = $_POST['deviceId'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $data = [
        'deviceId' => $deviceId,
        'latitude' => $latitude,
        'longitude' => $longitude,
    ];

    if (!file_exists('locations')) {
        mkdir('locations', 0777, true);
    }

    file_put_contents("locations/$deviceId.json", json_encode($data));

    // Count devices seeing this location
    $files = glob('locations/*.json');
    $count = 0;
    foreach ($files as $file) {
        $content = json_decode(file_get_contents($file), true);
        if ($content['deviceId'] !== $deviceId) {
            $count++;
        }
    }

    echo json_encode(['status' => 'success', 'viewingDevices' => $count]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
