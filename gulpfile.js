const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js');

    mix.copy('resources/components/jquery-search/jquery.searchabledropdown-1.0.8.min.js', 'resources/assets/js');
    mix.copy('resources/components/template/js/main.js', 'resources/assets/js');
    mix.copy('resources/components/select2/dist/css/select2.css', 'resources/assets/css');
    mix.copy('resources/components/select2/dist/js/select2.full.js', 'resources/assets/js');

    mix.styles(['select2.css']);

    mix.scripts([
        'select2.full.js',
        'main.js',
    ]);
});
