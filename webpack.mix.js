const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/views/basico/desktop/vue/app.js', 'public/temas/basico/dist/desktop/vue')
    .sass('resources/views/basico/desktop/sass/app.scss', 'public/temas/basico/dist/desktop/css');

mix.js('resources/views/basico/mobile/vue/app.js', 'public/temas/basico/dist/mobile/vue')
    .sass('resources/views/basico/mobile/sass/app.scss', 'public/temas/basico/dist/mobile/css');

