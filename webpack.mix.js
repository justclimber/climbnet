let mix = require('laravel-mix');

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix
    .js('resources/assets/js/app.js', 'public/js')
    .extract([
        'axios',
        'vue',
        'vuetify',
        'vuex',
        'vue-router',
        'vue-browser-acl',
        'date-fns',
        './resources/assets/js/vk.js'
    ])
    // .sourceMaps()
    .version();

mix.disableSuccessNotifications();