const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .sass('resources/sass/appSass.scss', 'public/css')

    // admin panel
    .js('resources/js/admin/admin.js', 'public/js/admin')
    .postCss('resources/css/admin.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .sass('resources/sass/adminSass.scss', 'public/css/adminSass.css')
    .js('resources/js/admin/products/productCreateAlpine.js', 'public/js/admin/products')
    .js('resources/js/admin/products/productEditAlpine.js', 'public/js/admin/products');

if (mix.inProduction()) {
    mix.version();
}
