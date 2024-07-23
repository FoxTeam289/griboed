<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $files = glob('locations/*.json');

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
