const CACHE_NAME = 'offline-cache-v1';
const urlsToCache = [
  '/index.html',
  '/bestforest.html',
  '/otziv.html',
  '/go.html',
  '/documentation.html',
  '/fallback.html' // Файл для отображения при отсутствии подключения
];

// Кэширование файлов при установке Service Worker
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
});

// Обработка запросов
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response; // Вернуть кэшированный ресурс, если он есть
        }
        return fetch(event.request)
          .catch(() => caches.match('/fallback.html')); // Вернуть резервную страницу при отсутствии подключения
      })
  );
});

// Удаление старых кэшей
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName); // Удаление старых кэшей
          }
        })
      );
    })
  );
});

