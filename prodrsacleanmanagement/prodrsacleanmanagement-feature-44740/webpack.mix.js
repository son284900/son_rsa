/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

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
mix.webpackConfig({
    module: {
        rules: [
            {
                // enforce: 'pre',
                // exclude: /node_modules/,
                // loader: 'eslint-loader',
                // test: /\.(js|vue)?$/,
            },
        ],
    },
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            // eslint-disable-next-line no-undef
            '@': path.resolve(__dirname, './resources'),
        },
    },
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
    });

// mix.copy( 'resources/assets/images', 'public/images', false );