let mix = require('laravel-mix');

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix
    .js('resources/assets/js/app.js', 'public/js')
    .extract([
        'axios',
        'vue',
        'vuex',
        'vuejs-datepicker',
        'vue2-timepicker',
        'vue-material',
        'vue-router',
        'vue-browser-acl',
        'moment',
    ])
    // .sourceMaps()
    .version();

mix.disableSuccessNotifications();