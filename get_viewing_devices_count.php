<?php
header('Content-Type: application/json');

// Путь к папке с файлами местоположений
$locationsDir = __DIR__ . '/locations';

// Получаем deviceId из POST-запроса
$deviceId = isset($_POST['deviceId']) ? $_POST['deviceId'] : null;

if ($deviceId === null) {
    echo json_encode(['status' => 'error', 'message' => 'Device ID is required.']);
    exit;
}

$viewingDevicesCount = 0;

// Проходим по всем файлам в папке locations
foreach (glob($locationsDir . '/*.json') as $file) {
    $data = json_decode(file_get_contents($file), true);
    if (isset($data['viewing']) && in_array($deviceId, $data['viewing'])) {
        $viewingDevicesCount++;
    }
}

echo json_encode(['status' => 'success', 'count' => $viewingDevicesCount]);
