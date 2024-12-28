<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

$error_message = "";

if (isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('data.json'), true);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($_POST['action'] == 'register') {
        foreach ($data['users'] as $user) {
            if ($user['username'] === $username) {
                $error_message = "Данное имя пользователя уже используется. Возможно, вы регистрируетесь, вместо входа.";
                break;
            }
        }
        if ($error_message == "") {
            $data['users'][] = ['username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)];
            file_put_contents('data.json', json_encode($data));
            $_SESSION['username'] = $username;
            header("Location: profile.php");
        }
    } elseif ($_POST['action'] == 'login') {
        $found_user = false;
        foreach ($data['users'] as $user) {
            if ($user['username'] == $username && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: profile.php");
                exit();
            }
        }
        $error_message = "Неверный логин или пароль";
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
            <?php if ($error_message != ""): ?>
                <div class="field-container">
                    <p style="color:red;"><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
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