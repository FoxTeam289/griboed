<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profiles = file_get_contents('php://input');
    file_put_contents('profiles.json', $profiles);
    echo 'Профили сохранены';
}
?>