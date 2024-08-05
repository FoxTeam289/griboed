<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Device Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: #f0f4f8;
                overflow-x: hidden;
                color: #333;
            }
            h1 {
                margin-top: 20px;
                color: #2c3e50;
                font-size: 2rem;
                animation: fadeIn 1s ease-in-out;
            }
            #map {
                height: 400px;
                width: 80%;
                max-width: 1200px;
                margin: 20px 0;
                border-radius: 12px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                animation: fadeIn 1s ease-in-out;
            }
            .button {
                background-color: #3498db;
                border: none;
                color: white;
                padding: 12px 24px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 8px 4px;
                cursor: pointer;
                border-radius: 8px;
                transition: background-color 0.3s, transform 0.3s;
                animation: fadeIn 1s ease-in-out;
            }
            .button:hover {
                background-color: #2980b9;
                transform: scale(1.05);
            }
            .hidden {
                display: none;
            }
            .visible {
                display: block;
            }
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
                margin: 10px;
            }
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }
            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                border-radius: 50%;
                background-color: white;
                left: 4px;
                bottom: 4px;
                transition: .4s;
            }
            input:checked + .slider {
                background-color: #2ecc71;
            }
            input:checked + .slider:before {
                transform: translateX(26px);
            }
            .info {
                text-align: center;
                margin-bottom: 20px;
                animation: fadeIn 1s ease-in-out;
            }
            input[type="text"] {
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
                transition: border-color 0.3s;
            }
            .language-selector{
                                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
                transition: border-color 0.3s;
            }
            input[type="text"]:focus {
                border-color: #3498db;
                outline: none;
            }
            #footer {
                margin-top: 20px;
                font-size: 14px;
                color: #555;
                text-align: center;
                animation: fadeIn 2s ease-in-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            .chat-widget {
                position: fixed;
                bottom: 0;
                right: 0;
                margin: 10px;
                z-index: 1000;
            }
        </style>
    </head>
    <body>
        <h1 id="pageTitle">Трекер Устройств 📍</h1>

        <select id="languageSelector" class="language-selector">
    <option value="en">English</option>
    <option value="ru">Русский</option>
</select>

        <div class="info">
            <p>Ваш ID: <span id="deviceId"></span></p>
            <button id="hideIdButton" class="button">Скрыть ID 🙈</button>
            <button id="showIdButton" class="button hidden">Показать ID 👁️</button>
        </div>
        <div class="info">
            <input type="text" id="targetDeviceId" placeholder="Введите ID устройства">
            <button id="connectButton" class="button">Подключиться 🔗</button>
        </div>
        <div class="info">
            <p>Количество подключенных устройств: <span id="viewingCount">0</span></p>
        </div>
        <div class="info">
            <button id="allowConnectionButton" class="button">Разрешить подключение ✔️</button>
            <button id="revokePermissionsButton" class="button">Отозвать права и удалить данные 🗑️</button>
        </div>
        <div class="info">
            <label class="switch">
                <input type="checkbox" id="autoDetectSwitch">
                <span class="slider"></span>
            </label>
            <span id="autoDetectLabel">Автоопределение 🔍</span>
        </div>
        <div class="info">
            <label class="switch">
                <input type="checkbox" id="autoRefreshSwitch">
                <span class="slider"></span>
            </label>
            <span id="autoRefreshLabel">Автообновление карты 🔄</span>
        </div>
        <div id="map"></div>
        <p id="footer">* Мы не собираем и не передаем данные пользователей. Все данные удаляются при нажатии на 'Отозвать права и удалить данные'. Мы рекомендуем делать это после каждого использования.</p>

        <!-- Chat Widget -->
        <div class="chat-widget">
            <script src="https://w.tb.ru/open-messenger/widget?wId=W-A4C534CFD5CB45B5800E64336DF4EA04"></script>
        </div>
        <script src="https://api-maps.yandex.ru/2.1/?apikey=86c4a0b5-0c50-44da-a0d8-a9b213634759&lang=ru_RU" type="text/javascript"></script>
    <script>
                let map, marker;
        let currentDeviceId = null;
        let autoDetectInterval = null;
        let autoRefreshInterval = null;

        ymaps.ready(init);

        function init() {
            map = new ymaps.Map("map", {
                center: [55.76, 37.64], // Center of Moscow
                zoom: 10
            });

            marker = new ymaps.Placemark([55.76, 37.64], {}, {
                preset: 'islands#icon',
                iconColor: '#0095b6'
            });

            map.geoObjects.add(marker);
        }
const translations = {
    en: {
        pageTitle: "Device Tracker 📍",
        hideIdButton: "Hide ID 🙈",
        showIdButton: "Show ID 👁️",
        connectButton: "Connect 🔗",
        allowConnectionButton: "Allow Connection ✔️",
        revokePermissionsButton: "Revoke Permissions and Delete My Data 🗑️",
        autoDetectLabel: "Auto-Detect 🔍",
        autoRefreshLabel: "Auto-Refresh Map 🔄",
        footer: "* We do not collect or share user data. All data is deleted when you click 'Revoke Permissions and Delete My Data'. We recommend doing this after each use."
    },
    ru: {
        pageTitle: "Трекер Устройств 📍",
        hideIdButton: "Скрыть ID 🙈",
        showIdButton: "Показать ID 👁️",
        connectButton: "Подключиться 🔗",
        allowConnectionButton: "Разрешить подключение ✔️",
        revokePermissionsButton: "Отозвать права и удалить данные 🗑️",
        autoDetectLabel: "Автоопределение 🔍",
        autoRefreshLabel: "Автообновление карты 🔄",
        footer: "* Мы не собираем и не передаем данные пользователей. Все данные удаляются при нажатии на 'Отозвать права и удалить данные'. Мы рекомендуем делать это после каждого использования."
    }
};

        let deviceId = localStorage.getItem('deviceId') || 'device-' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('deviceId', deviceId);

        document.getElementById('deviceId').textContent = deviceId;
        document.getElementById('hideIdButton').addEventListener('click', hideId);
        document.getElementById('showIdButton').addEventListener('click', showId);
        document.getElementById('connectButton').addEventListener('click', connectToDevice);
        document.getElementById('allowConnectionButton').addEventListener('click', allowConnection);
        document.getElementById('revokePermissionsButton').addEventListener('click', revokePermissions);

        let autoDetectEnabled = localStorage.getItem('autoDetectEnabled') === 'true';
        let autoRefreshEnabled = localStorage.getItem('autoRefreshEnabled') === 'true';

        document.getElementById('autoDetectSwitch').checked = autoDetectEnabled;
        document.getElementById('autoRefreshSwitch').checked = autoRefreshEnabled;

        document.getElementById('autoDetectLabel').textContent = autoDetectEnabled ? translations.en.autoDetectLabel : translations.ru.autoDetectLabel;
        document.getElementById('autoRefreshLabel').textContent = autoRefreshEnabled ? translations.en.autoRefreshLabel : translations.ru.autoRefreshLabel;
        document.getElementById('pageTitle').textContent = translations.en.pageTitle;
        document.getElementById('hideIdButton').textContent = translations.en.hideIdButton;
        document.getElementById('showIdButton').textContent = translations.en.showIdButton;
        document.getElementById('connectButton').textContent = translations.en.connectButton;
        document.getElementById('allowConnectionButton').textContent = translations.en.allowConnectionButton;
        document.getElementById('revokePermissionsButton').textContent = translations.en.revokePermissionsButton;
        document.getElementById('footer').textContent = translations.en.footer;

        if (autoDetectEnabled) {
            startAutoDetect();
        }

        if (autoRefreshEnabled) {
            startAutoRefresh();
        }

        document.getElementById('autoDetectSwitch').addEventListener('change', function() {
            autoDetectEnabled = this.checked;
            localStorage.setItem('autoDetectEnabled', autoDetectEnabled);
            document.getElementById('autoDetectLabel').textContent = autoDetectEnabled ? translations.en.autoDetectLabel : translations.ru.autoDetectLabel;

            if (autoDetectEnabled) {
                startAutoDetect();
            } else {
                stopAutoDetect();
            }
        });

        document.getElementById('autoRefreshSwitch').addEventListener('change', function() {
            autoRefreshEnabled = this.checked;
            localStorage.setItem('autoRefreshEnabled', autoRefreshEnabled);
            document.getElementById('autoRefreshLabel').textContent = autoRefreshEnabled ? translations.en.autoRefreshLabel : translations.ru.autoRefreshLabel;

            if (autoRefreshEnabled) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });

        function hideId() {
            document.getElementById('deviceId').classList.add('hidden');
            document.getElementById('hideIdButton').classList.add('hidden');
            document.getElementById('showIdButton').classList.remove('hidden');
            localStorage.setItem('hideId', 'true');
        }

        function showId() {
            document.getElementById('deviceId').classList.remove('hidden');
            document.getElementById('hideIdButton').classList.remove('hidden');
            document.getElementById('showIdButton').classList.add('hidden');
            localStorage.setItem('hideId', 'false');
        }

        function connectToDevice() {
            const targetDeviceId = document.getElementById('targetDeviceId').value;
            if (targetDeviceId) {
                fetch(`check_connection.php?deviceId=${targetDeviceId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            currentDeviceId = targetDeviceId;
                            updateMap(data.location.latitude, data.location.longitude);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function allowConnection() {
            const updateLocation = () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        const { latitude, longitude } = position.coords;
                        fetch(`update_location.php?deviceId=${deviceId}&latitude=${latitude}&longitude=${longitude}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log("Real-time location updated");
                                } else {
                                    console.error(data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }, error => {
                        console.error('Error getting geolocation:', error);
                    });
                }
            };

            function updateLanguage(language) {
    document.getElementById('pageTitle').textContent = translations[language].pageTitle;
    document.getElementById('hideIdButton').textContent = translations[language].hideIdButton;
    document.getElementById('showIdButton').textContent = translations[language].showIdButton;
    document.getElementById('connectButton').textContent = translations[language].connectButton;
    document.getElementById('allowConnectionButton').textContent = translations[language].allowConnectionButton;
    document.getElementById('revokePermissionsButton').textContent = translations[language].revokePermissionsButton;
    document.getElementById('autoDetectLabel').textContent = translations[language].autoDetectLabel;
    document.getElementById('autoRefreshLabel').textContent = translations[language].autoRefreshLabel;
    document.getElementById('footer').textContent = translations[language].footer;
}

document.getElementById('languageSelector').addEventListener('change', (event) => {
    const selectedLanguage = event.target.value;
    updateLanguage(selectedLanguage);
});

// Initialize with the default language (Russian in this case)
updateLanguage('ru');

            // Update location every 5 seconds
            updateLocation();
            setInterval(() => {
                updateLocation();
                if (currentDeviceId) {
                    fetch(`check_connection.php?deviceId=${currentDeviceId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateMap(data.location.latitude, data.location.longitude);
                            } else {
                                console.error(data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            }, 5000);
        }

        function revokePermissions() {
            fetch(`revoke_permissions.php?deviceId=${deviceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('deviceId');
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function startAutoDetect() {
            if (autoDetectInterval) return; // Stop any existing interval

            autoDetectInterval = setInterval(() => {
                document.getElementById('allowConnectionButton').click();
            }, 5000);
        }

        function stopAutoDetect() {
            if (autoDetectInterval) {
                clearInterval(autoDetectInterval);
                autoDetectInterval = null;
            }
        }

        function startAutoRefresh() {
            if (autoRefreshInterval) return; // Stop any existing interval

            autoRefreshInterval = setInterval(() => {
                document.getElementById('connectButton').click();
            }, 5000);
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
            }
        }

        function updateMap(latitude, longitude) {
            marker.geometry.setCoordinates([latitude, longitude]);
            map.setCenter([latitude, longitude]);

            // Fetch and update the count of devices viewing your location
            fetch(`get_viewing_devices_count.php?deviceId=${deviceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('viewingCount').textContent = data.count;
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        
    </script>
</body>
</html>
