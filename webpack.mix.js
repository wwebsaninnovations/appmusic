// webpack.mix.js
const mix = require('laravel-mix');

// Compile and bundle the app.js file
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('resources/assets', 'public/assets');  // Copy theme assets

   // Optionally, you can include Dropzone directly here
mix.copy('node_modules/dropzone/dist/min/dropzone.min.js', 'public/assets/vendor/libs/dropzone/dropzone.js')
.copy('node_modules/dropzone/dist/min/dropzone.min.css', 'public/assets/vendor/libs/dropzone/dropzone.css');