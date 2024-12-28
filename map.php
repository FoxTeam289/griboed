<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$data = json_decode(file_get_contents('mushroom_zones.json'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $imagePath = 'uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    $location = json_decode($_POST['location'], true);
    $zone = [
        'id' => uniqid(),
        'username' => $_SESSION['username'],
        'image' => $imagePath,
        'location' => $location,
        'votes' => ['yes' => 0, 'no' => 0, 'userVotes' => []]
    ];
    $data['zones'][] = $zone;
    file_put_contents('mushroom_zones.json', json_encode($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
    $zoneId = $_POST['zoneId'];
    $voteType = $_POST['voteType'];
    $username = $_SESSION['username'];

    foreach ($data['zones'] as &$zone) {
        if ($zone['id'] == $zoneId && !in_array($username, $zone['votes']['userVotes'])) {
            $zone['votes'][$voteType]++;
            $zone['votes']['userVotes'][] = $username;

            if ($zone['votes']['no'] > 5) {
                $data['zones'] = array_filter($data['zones'], function ($z) use ($zoneId) {
                    return $z['id'] !== $zoneId;
                });
            }
            break;
        }
    }
    file_put_contents('mushroom_zones.json', json_encode($data));
    exit();
}

$zones = $data['zones'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта грибных мест</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/assets/styles/dist/map.css?version=<?php echo rand(0, 9999) ?>">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>

<body>
    <div class="box">
        <div class="container">
            <h2>Карта грибных мест</h2>
            <div id="map"></div>
            <p>Чтобы добавить грибное место, кликните на карту</p>
            <div id="popup" class="popup" style="display:none;">
                <p>Хотите поставить грибное место в этом месте?</p>
                <button onclick="confirmLocation()" class="isDBtn">Да</button>
                <button onclick="cancelLocation()" class="isDBtn">Нет</button>
            </div>
            <form id="uploadForm" method="post" enctype="multipart/form-data" style="display:none;">
                <input type="file" name="image" accept="image/*" required>
                <input type="hidden" name="location" id="location">
                <button type="submit" class="isDBtn is-2">Загрузить фото и подтвердить местоположение</button>
            </form>
        </div>
    </div>
    <div class="mobile-menu">
        <a href="chat.php"><i class="fas fa-comments"></i></a>
        <a href="map.php"><i class="fas fa-map"></i></a>
        <a href="profile.php"><i class="fas fa-user"></i></a>
    </div>
    <div class="background"><video src="/assets/videos/bg.mp4" loop autoplay muted></video></div>

    <script>
        ymaps.ready(init);

        var selectedCoords;

        function init() {
            var myMap = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 10
            });

            var zones = <?php echo json_encode($zones); ?>;

            zones.forEach(function (zone) {
                var placemark = new ymaps.Placemark(zone.location, {
                    balloonContent: '<strong>Автор:</strong> ' + zone.username + '<br><img src="' + zone.image + '" alt="Грибная зона" class="mapImg"><br><p>Голоса: Есть грибы - ' + zone.votes.yes + ', Нет грибов - ' + zone.votes.no + '</p><div class="btnMapContainer"><button onclick="vote(\'' + zone.id + '\', \'yes\')" class="btnMap">Есть грибы</button><button onclick="vote(\'' + zone.id + '\', \'no\')" class="btnMap">Нет грибов</button></div>'
                });
                myMap.geoObjects.add(placemark);
            });

            myMap.events.add('click', function (e) {
                selectedCoords = e.get('coords');
                document.getElementById('popup').style.display = 'block';
            });
        }

        function confirmLocation() {
            document.getElementById('location').value = JSON.stringify(selectedCoords);
            document.getElementById('uploadForm').style.display = 'flex';
            document.getElementById('popup').style.display = 'none';
        }

        function cancelLocation() {
            document.getElementById('popup').style.display = 'none';
            selectedCoords = null;
        }

        function uploadMushroomPhoto() {
            alert('Пожалуйста, выберите место на карте для загрузки изображения.');
        }

        function vote(zoneId, voteType) {
            var formData = new FormData();
            formData.append('vote', true);
            formData.append('zoneId', zoneId);
            formData.append('voteType', voteType);

            fetch('map.php', {
                method: 'POST',
                body: formData
            }).then(response => location.reload());
        }
    </script>
</body>

</html>