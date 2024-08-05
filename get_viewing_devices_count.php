<?php
if (isset($_GET['deviceId'])) {
    $deviceId = $_GET['deviceId'];
    $directory = 'locations';
    $files = glob($directory . '/*.json');
    
    $count = 0;
    foreach ($files as $file) {
        $fileDeviceId = basename($file, '.json');
        if ($fileDeviceId !== $deviceId) {
            $count++;
        }
    }

    echo json_encode(['success' => true, 'count' => $count]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
}
?>
