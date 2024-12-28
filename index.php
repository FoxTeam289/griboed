<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('data.json'), true);
    if ($_POST['action'] == 'register') {
        $data['users'][] = ['username' => $_POST['username'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)];
        file_put_contents('data.json', json_encode($data));
        $_SESSION['username'] = $_POST['username'];
        header("Location: chat.php");
    } elseif ($_POST['action'] == 'login') {
        foreach ($data['users'] as $user) {
            if ($user['username'] == $_POST['username'] && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['username'] = $_POST['username'];
                header("Location: chat.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма входа и регистрации</title>
    <link rel="stylesheet" href="/assets/styles/dist/index.css?version=<?php echo rand(0, 9999) ?>">
</head>

<body>
    <div class="container">
        <form method="post">
            <img src="/assets/images/2.png" class="bg" alt="Hello">
            <div class="field-container">
                <input type="text" name="username" placeholder="Имя пользователя" required>
            </div>
            <div class="field-container">
                <input type="password" name="password" placeholder="Пароль" required>
            </div>
            <div class="btns">
                <div class="is-1">
                    <div class="field-container">
                        <button type="submit" name="action" value="register" class="tooltip">
                            Регистрация
                            <!-- <span class="tooltiptext">Нажмите, если вы тут впервые</span> -->
                        </button>
                    </div>
                    <div class="field-container">
                        <button type="submit" name="action" value="login" class="tooltip">
                            Вход
                            <!-- <span class="tooltiptext">Нажмите, если вы тут уже зарегистрированы</span> -->
                        </button>
                    </div>
                </div>
                <div class="is-2">
                    <button><img src="/assets/images/yandex.png" alt="Yandex"> Войти с Яндекс ID</button>
                </div>
            </div>
        </form>
    </div>
    <div class="background"></div>
</body>

</html>