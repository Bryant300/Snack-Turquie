const CACHE_NAME = 'snack-turquie-v2';
const CORE_ASSETS = [
    '/',
    '/index.html',
    '/menu.html',
    '/panier.html',
    '/checkout.html',
    '/contact.html',
    '/assets/css/style.css',
    '/assets/js/script.js',
    '/assets/img/logo-snack-turquie.png',
    '/assets/img/halal.svg',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(CORE_ASSETS))
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => Promise.all(
            cacheNames
                .filter((cacheName) => cacheName !== CACHE_NAME)
                .map((cacheName) => caches.delete(cacheName))
        ))
    );
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                const responseCopy = response.clone();

                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseCopy);
                });

                return response;
            })
            .catch(() => caches.match(event.request))
    );
});
