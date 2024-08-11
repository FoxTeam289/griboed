// Название кэша
const CACHE_NAME = 'offline-cache-v1';

// Список файлов, которые необходимо закэшировать для работы в оффлайн-режиме
const urlsToCache = [
  '/index.html',
  '/bestforest.html',
  '/otziv.html',
  '/go.html',
  '/documentation.html',
  '/fallback.html' // Этот файл будет показан, если пользователь пытается загрузить страницу без подключения
];

// Установка Service Worker и кэширование ресурсов
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

// Обработка запросов: сначала проверяем кэш, если ресурса нет, пытаемся загрузить из сети
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          // Если ресурс найден в кэше, возвращаем его
          console.log('Serving from cache:', event.request.url);
          return response;
        }
        // Если ресурс не найден в кэше, пытаемся получить его из сети
        return fetch(event.request).catch(() => {
          // Если нет подключения к сети, возвращаем резервную страницу
          console.log('No network, serving fallback page');
          return caches.match('/fallback.html');
        });
      })
  );
});

// Активация Service Worker и удаление старых версий кэша
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            // Удаляем старый кэш
            console.log('Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});
