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

mix
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/serebo.dashboard.scss', 'public/css')
    .sourceMaps();
mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/serebo.dashboard.core.js', 'public/js')
    .js('resources/js/serebo.dashboard.js', 'public/js')
    .sourceMaps();
mix.version();