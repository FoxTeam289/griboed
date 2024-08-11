const CACHE_NAME = 'offline-cache-v1'
const urlsToCache = [
	'/index.html',
	'/bestforest.html',
	'/otziv.html',
	'/go.html',
	'/documentation.html',
]

self.addEventListener('install', event => {
	event.waitUntil(
		caches.open(CACHE_NAME).then(cache => {
			return cache.addAll(urlsToCache)
		})
	)
})

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response;  // Возвращаем кэшированный ресурс
        }
        return fetch(event.request).catch(() => caches.match('/fallback.html'));
      })
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
