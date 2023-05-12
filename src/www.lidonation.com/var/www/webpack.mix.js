const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-polyfill');
const tailwindcss = require('tailwindcss');
const LiveReloadPlugin = require('webpack-livereload-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
*/
mix.ts('resources/js/catalyst-explorer.ts', 'public/js')
    .ts('resources/js/earn.ts', 'public/js')
    .ts('resources/js/reward.ts', 'public/js')
    .ts('resources/js/phuffycoin.ts', 'public/js')
    .ts('resources/js/delegators.ts', 'public/js')
    .ts('resources/js/rewards.ts', 'public/js')
    .ts('resources/js/lido-search.ts', 'public/js')
    .ts('resources/js/governance-marathon.ts', 'public/js')

    .js('resources/js/partners.ts', 'public/js')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/global.js', 'public/js')
    .js('resources/js/alpine.js', 'public/js')
    .js('resources/js/lib/vendor/splide/js/splide-shader-carousel.min.js', 'public/vendor/splide')

    .vue(3)

    .css('node_modules/@splidejs/splide/dist/css/splide-core.min.css', 'public/css')
    .css('node_modules/@splidejs/splide/dist/css/themes/splide-default.min.css', 'public/css')
    .css('node_modules/@splidejs/splide-extension-video/dist/css/splide-extension-video.min.css', 'public/css')

    .sass('resources/sass/catalyst-explorer.scss', 'public/css')
    .sass('resources/sass/earn.scss', 'public/css')
    .sass('resources/sass/rewards.scss', 'public/css')
    .sass('resources/sass/bootstrap.scss', 'public/css')
    .sass('resources/sass/partners.scss', 'public/css')
    .sass('resources/sass/delegators.scss', 'public/css')
    .sass('resources/sass/governance-day.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/lido-search.scss', 'public/css')

    .options({
        postCss: [
            tailwindcss('./tailwind.config.js')
        ]
    })
    // .postCss('resources/css/app.css', 'public/css', [
    //     require('postcss-import'),
    //     require('tailwindcss'),
    // ])
    .webpackConfig({
        output: {
            chunkFilename: 'js/[name].js?id=[chunkhash]',
        },
        // target: ['browserslist:modern'],
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: 'ts-loader',
                    options: {appendTsSuffixTo: [/\.vue$/]},
                    exclude: /node_modules/,
                },
                {
                    test: /\.json$/i,
                    use: ['json-loader'],
                    type: 'javascript/auto',
                    exclude: /node_modules/,
                },

                // {
                //     test: /\.scss$/,
                //     use: [
                //         'vue-style-loader',
                //         'css-loader',
                //         'sass-loader'
                //     ]
                // }
            ],
        },
        resolve: {
            extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
            alias: {
                '@': path.resolve('resources/js'),
                '@vendor': path.resolve('vendor')
            },
        },
        experiments: {
            asyncWebAssembly: true,
            // syncWebAssembly: true,
            outputModule: false,
            topLevelAwait: true,
            layers: true
        },
        plugins: [
            // require('unplugin-vue-define-options/webpack')()
        ]
    })
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: "defaults, not IE 11",
    })
    .version();

if (mix.inProduction()) {
    mix.version();
}

if (!mix.inProduction()) {
    mix.browserSync(
        {
            proxy: 'http://localhost:8880',
            ui: false,
            ws: true,
            port: 3001,
            // httpModule: 'http2',
            https: false,
            open: false
        }
    );
}
