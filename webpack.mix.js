const mix = require('laravel-mix');

mix.js('resources/js/role-handler.js', 'public/js')
   .js('resources/js/app.js', 'public/js') // Jika Anda memiliki file app.js
   .sass('resources/sass/app.scss', 'public/css'); // Jika Anda memproses file SCSS/CSS