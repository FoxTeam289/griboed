<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$data = json_decode(file_get_contents('chat.json'), true);
$zones = json_decode(file_get_contents('mushroom_zones.json'), true);
$users = json_decode(file_get_contents('users.json'), true);

function getUserAvatar($username, $users)
{
    foreach ($users['users'] as $user) {
        if ($user['username'] == $username) {
            return $user['avatar'];
        }
    }
    return '/4c8531dbc05c77cb7a5893297977ac89.jpg';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $message = [
            'username' => $_SESSION['username'],
            'text' => '<img src="' . $imagePath . '" alt="Изображение" class="chat-image">',
            'avatar' => getUserAvatar($_SESSION['username'], $users),
            'time' => date('H:i'),
        ];
        $data['messages'][] = $message;
        file_put_contents('chat.json', json_encode($data));
    } elseif (!empty($_POST['zone'])) {
        $zoneId = $_POST['zone'];
        $zone = null;
        foreach ($zones['zones'] as $z) {
            if ($z['id'] == $zoneId) {
                $zone = $z;
                break;
            }
        }
        $message = [
            'username' => $_SESSION['username'],
            'text' => 'Грибное место: <a href="map.php?zoneId=' . $zoneId . '">Посмотреть на карте</a>',
            'avatar' => getUserAvatar($_SESSION['username'], $users),
            'time' => date('H:i'),
        ];
        if (!empty($_POST['text'])) {
            $message['text'] .= '<br>' . htmlspecialchars($_POST['text']);
        }
        $data['messages'][] = $message;
        file_put_contents('chat.json', json_encode($data));
    } elseif (!empty($_POST['text'])) {
        $message = [
            'username' => $_SESSION['username'],
            'text' => htmlspecialchars($_POST['text']),
            'avatar' => getUserAvatar($_SESSION['username'], $users),
            'time' => date('H:i'),
        ];
        $data['messages'][] = $message;
        file_put_contents('chat.json', json_encode($data));
    }
}

$messages = $data['messages'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link rel="stylesheet" href="/assets/styles/dist/chat.css?version=<?php echo rand(0, 9999) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="box">
        <div class="container is-1">
            <h2>Добро пожаловать, <span><?php echo $_SESSION['username']; ?></span>!</h2>
            <form method="post" enctype="multipart/form-data">
                <select name="zone">
                    <option value="" disabled selected>Выберите грибное место</option>
                    <option value="wef">wf</option>
                    <option value="wef">wf</option>
                    <option value="wef">wf</option>
                    <option value="wef">wf</option>
                    <?php foreach ($zones['zones'] as $zone): ?>
                        <option value="<?php echo $zone['id']; ?>"><?php echo 'Автор: ' . $zone['username']; ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea name="text" placeholder="Введите сообщение"></textarea>
                <input type="file" name="image" accept="image/*">

                <button type="submit"><i class="fas fa-paper-plane"></i> Отправить</button>
            </form>
        </div>
        <div class="container">
            <div class="messages">
                <?php foreach ($messages as $message): ?>
                    <div class="message">
                        <img src="4c8531dbc05c77cb7a5893297977ac89.jpg" alt="Аватарка" class="avatar">
                        <div class="message-content">
                            <strong><a
                                    href="profile.php?user=<?php echo urlencode($message['username']); ?>"><?php echo $message['username']; ?></a></strong>
                            <small><?php echo $message['time']; ?></small>
                            <p><?php echo $message['text']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="mobile-menu">
        <a href="chat.php"><i class="fas fa-comments"></i></a>
        <a href="map.php"><i class="fas fa-map"></i></a>
        <a href="profile.php"><i class="fas fa-user"></i></a>
    </div>
    <div class="background"><video src="/assets/videos/bg.mp4" loop autoplay muted></video></div>
</body>

</html>