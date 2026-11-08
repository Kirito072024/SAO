/* =========================================================
   Практичне заняття 26: простий service worker
   - при встановленні кешує головну сторінку, стилі, скрипт, новини й картинки;
   - сторінка й новини: спершу мережа (щоб бачити свіжу версію після деплою),
     без мережі — версія з кешу;
   - стилі, скрипти, картинки: спершу кеш (швидко), якщо в кеші немає — мережа.
   Після зміни файлів сайту збільшуйте номер версії — старий кеш видалиться.
   ========================================================= */

const CACHE_NAME = 'sao-v1';

// шляхи відносні — працює і в корені домену (Vercel/Netlify), і в підпапці (GitHub Pages /SAO/)
const PRECACHE = [
  './',
  'index.html',
  'style.css',
  'src/output.css',
  'script.js',
  'news.json',
  'manifest.json',
  'icons/icon-192.png',
  'icons/icon-512.png',
  'images/aincrad-480.webp',
  'images/aincrad-960.webp',
  'images/kirito-400.webp',
  'images/asuna-400.webp',
  'images/klein-400.webp',
  'images/yui-400.webp'
];

// 1. Встановлення: кладемо файли в кеш
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(PRECACHE))
      .then(() => self.skipWaiting())
  );
});

// 2. Активація: видаляємо кеші старих версій
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))))
      .then(() => self.clients.claim())
  );
});

// 3. Запити
self.addEventListener('fetch', (event) => {
  const request = event.request;
  const url = new URL(request.url);

  // лише GET свого сайту: POST форми, API на localhost:3000 і Google Fonts ідуть напряму в мережу
  if (request.method !== 'GET' || url.origin !== self.location.origin) {
    return;
  }

  const networkFirst = request.mode === 'navigate' || url.pathname.endsWith('.json');

  if (networkFirst) {
    event.respondWith(
      fetch(request)
        .then((response) => {
          const copy = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, copy));
          return response;
        })
        .catch(() => caches.match(request).then((cached) => cached || caches.match('index.html')))
    );
  } else {
    event.respondWith(
      caches.match(request).then((cached) => cached || fetch(request))
    );
  }
});
