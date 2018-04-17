let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js');
mix.js('resources/assets/js/custom-jquery.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.(pug|jade)$/,
                use: ['raw-loader', 'pug-html-loader?pretty&exports=false']
            }
        ]
    }
});