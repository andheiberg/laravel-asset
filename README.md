Asset
===
Simple asset workflow for laravel using gulp and blade helpers.

Gulpfile and asset helpers for laravel. This will:
- Compile scss (sass)
- Allow you to concatinate js files with browserify
- Minify scss and js
- Work with LiveReload
- Add cachebusting cashes to each url
- Minify images
- Add artisan asset:watch and artisan asset:build

Installation
---
Run ```composer require andheiberg/asset:1.*```

Add `'Andheiberg\Asset\AssetServiceProvider',` to `providers` in `app/config/app.php`

Run ```php artisan asset:setup```

Run ```php artisan asset:build``` or ```php artisan asset:watch```

Add the following to you .htaccess or php.ini (add before laravels)

    <IfModule mod_rewrite.c>
        # Remove cachebuster hash from request URLs if present
        RewriteRule ^(.+)\.([a-zA-Z\d]+)\.(js|css|png|jpg|gif)$ $1.$3 [L]
    </IfModule>

View helpers/Blade helpers
---

Get cachebuster url to asset.

    {{ Asset::url('/assets/css/main.css') }}

    @asset('/assets/css/main.css')

    // both returns '/assets/css/main.59b29833cff2003c9981ad1359777815.css'

Get cachebuster url to css asset.

    {{ Asset::css('main') }}

    @css('main')

    // both returns '<link rel="stylesheet" href="/assets/css/main.59b29833cff2003c9981ad1359777815.css">'

Get cachebuster url to js asset.

    {{ Asset::js('main') }}

    @js('main')

    // both returns '<script src="/assets/js/main.d41d8cd98f00b204e9800998ecf8427e.js"></script>'