const nom_cache = 'OpenTAN'
const ver_cache = '1.1'

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(nom_cache + '_' + ver_cache)
        .then(cache => cache.addAll([
            '/',
            '/index.php',
            '/horaires.php',
            '/settings.php',
            '/faq.php',
            '/open_source.php',
            '/about.php',
            '/contact.php',
            '/ressources/css/style.css',
            '/ressources/css/sombre.css',
            '/ressources/fonts/Frutiger-Cn.otf',
            '/ressources/js/autocompletion.js',
            '/ressources/js/hamburger.js',
            '/ressources/js/manifest.json',
            '/ressources/js/settings.js',
            '/ressources/images/logo/logo_header.png',
            '/ressources/images/logo/logo_image.png'
        ]))
    )
    console.log('Fichiers mis en cache')
})

self.addEventListener('fetch', function (e)
{
    e.respondWith(
        caches.match(e.request)
        .then(function (response)
        {
            if (response)
            {
                return response;
            }
            return fetch(e.request)
        })
    )
})

self.addEventListener('activate', function()
{
    var cache_actif = nom_cache + '_' + ver_cache
    caches.keys().then(function(cacheNames)
    {
        return Promise.all(
            cacheNames.map(function(cacheName)
            {
                if (cacheName.indexOf(nom_cache) == -1)
                {
                    return;
                }

                if (cacheName != cache_actif)
                {
                    return caches.delete(cacheName)
                }
            })
        )
    })
})

self.addEventListener('message', function (e)
{
    if (e.data.action === 'wait_update')
    {
      self.skipWaiting()
    }
})