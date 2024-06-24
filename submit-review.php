<?php
// Функция для сохранения отзыва в JSON файл

function saveReview($reviewData) {
    $reviewsFile = 'reviews.json';

    // Чтение существующих отзывов
    $reviews = [];
    if (file_exists($reviewsFile)) {
        $reviews = json_decode(file_get_contents($reviewsFile), true);
    }

    // Добавление нового отзыва
    $reviews[] = $reviewData;

    // Сохранение обновленного списка отзывов
    file_put_contents($reviewsFile, json_encode($reviews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Обработка формы отзыва
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $forest = $_POST['forest'];
    $customForest = isset($_POST['customForest']) ? $_POST['customForest'] : '';
    $rating = $_POST['rating'];
    $foundMushrooms = $_POST['foundMushrooms'];
    $impressions = $_POST['impressions'];
    $image = $_FILES['forestImage'];

    // Подготовка данных отзыва
    $reviewData = [
        'forest' => $forest,
        'customForest' => $customForest,
        'rating' => $rating,
        'foundMushrooms' => $foundMushrooms,
        'impressions' => $impressions,
        'image' => ''
    ];

    // Обработка загруженного изображения
    if ($image['size'] > 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Проверка на изображение
        $check = getimagesize($image["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Проверка на размер файла
        if ($image["size"] > 500000) {
            $uploadOk = 0;
        }

        // Разрешить только определенные форматы файлов
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Проверка флага на ошибки
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                $reviewData['image'] = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Сохранение отзыва
    saveReview($reviewData);

    // Перенаправление на страницу с лучшими отзывами
    header("Location: bestforest.php");
    exit();
}
?>
