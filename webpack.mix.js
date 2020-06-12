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

mix.js('resources/js/app.js', 'public/js')
   //.js('resources/js/additional_js/article1.js', 'public/js/additional_js')
   .js(['resources/js/app.js','resources/js/admin/app_admin.js'], 'public/js/admin/app_admin.js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/admin/app_admin.scss', 'public/css/admin')
   //.sass('resources/sass/additional_css/test1.scss', 'public/css/additional_css')
