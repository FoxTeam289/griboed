const CACHE_NAME = 'offline-cache-v1'
const urlsToCache = [
  '/index.html',
  '/bestforest.html',
  '/otziv.html',
  '/go.html',
  '/documentation.html',
  '/fallback.html' // Убедитесь, что этот файл существует и доступен
];

self.addEventListener('install', event => {
  console.log('Service Worker installing.');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
      .catch(err => console.error('Cache open failed:', err))
  );
});

self.addEventListener('fetch', event => {
  console.log('Service Worker fetching:', event.request.url);
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          console.log('Serving from cache:', event.request.url);
          return response;
        }
        return fetch(event.request)
          .catch(() => {
            console.log('Serving fallback page');
            return caches.match('/fallback.html');
          });
      })
      .catch(err => console.error('Cache match failed:', err))
  );
});


self.addEventListener('activate', event => {
	const cacheWhitelist = [CACHE_NAME]
	event.waitUntil(
		caches.keys().then(cacheNames => {
			return Promise.all(
				cacheNames.map(cacheName => {
					if (cacheWhitelist.indexOf(cacheName) === -1) {
						return caches.delete(cacheName) // Удаляем старые кэши
					}
				})
			)
		})
	)
})
