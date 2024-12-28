<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Проверка существования файла и инициализация, если файла нет
if (!file_exists('users.json')) {
    file_put_contents('users.json', json_encode(['users' => []]));
}

$data = json_decode(file_get_contents('users.json'), true);
if ($data === null || !isset($data['users'])) {
    $data = ['users' => []]; // Установить в пустой массив, если декодирование не удалось
}

$username = $_GET['user'] ?? $_SESSION['username'];
$user = null;

foreach ($data['users'] as &$u) {
    if ($u['username'] == $username) {
        $user = &$u;
        break;
    }
}

// Если пользователь не найден в JSON файле, добавить его
if (!$user && $username == $_SESSION['username']) {
    $user = [
        'username' => $username,
        'name' => '',
        'avatar' => 'uploads/default.PNG',
        'city' => ''
    ];
    $data['users'][] = &$user;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $username == $_SESSION['username']) {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
        $avatarPath = 'uploads/' . basename($_FILES['avatar']['name']);
        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
        $user['avatar'] = $avatarPath;
    }
    if (isset($_POST['name'])) {
        $user['name'] = htmlspecialchars($_POST['name']);
    }
    if (isset($_POST['city'])) {
        $user['city'] = htmlspecialchars($_POST['city']);
    }
    file_put_contents('users.json', json_encode($data));
}

if (!file_exists('mushroom_zones.json')) {
    file_put_contents('mushroom_zones.json', json_encode(['zones' => []]));
}

$zones = json_decode(file_get_contents('mushroom_zones.json'), true);
if ($zones === null || !isset($zones['zones'])) {
    $zones = ['zones' => []]; // Установить в пустой массив, если декодирование не удалось
}

$user_zones = array_filter($zones['zones'], function ($zone) use ($username) {
    return $zone['username'] == $username;
});
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="/assets/styles/dist/profile.css?version=<?php echo rand(0, 9999) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="box">
        <div class="container is-1">
            <h2>Профиль пользователя</h2>
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Аватарка" class="avatar">
                <?php if ($username == $_SESSION['username']): ?>
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="avatar">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                            placeholder="Ваше имя">
                        <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>"
                            placeholder="Город">
                        <button type="submit">Обновить профиль</button>
                    </form>
                    <form method="post" action="logout.php">
                        <button type="submit">Выйти из профиля</button>
                    </form>
                <?php else: ?>
                    <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Город:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="container">
            <h3>Мои грибные места (<?php echo count($user_zones); ?>)</h3>
            <div class="zones">
                <?php foreach ($user_zones as $zone): ?>
                    <div class="zone">
                        <img src="<?php echo htmlspecialchars($zone['image']); ?>" alt="Грибная зона" class="imgZona">
                        <p><strong>Место:</strong> <a href="map.php?zoneId=<?php echo htmlspecialchars($zone['id']); ?>">Посмотреть на карте</a></p>
                        <p><strong>Голоса:</strong> Да - <?php echo htmlspecialchars($zone['votes']['yes']); ?>, Нет - <?php echo htmlspecialchars($zone['votes']['no']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="mobile-menu">
            <a href="chat.php"><i class="fas fa-comments"></i></a>
            <a href="map.php"><i class="fas fa-map"></i></a>
            <a href="profile.php"><i class="fas fa-user"></i></a>
        </div>
        <div class="background"><video src="/assets/videos/bg.mp4" loop autoplay muted></video></div>
    </div>
</body>

</html>
