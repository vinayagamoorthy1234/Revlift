var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

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

elixir(function(mix) {
		mix.less('app.less', 'public/css', {
      paths: [
      	__dirname + '/vendor/twbs/bootstrap/less',
      	__dirname + '/resources/assets/less'
      ]
    })
    .less('dashboard.less')
    .less('login.less');
		
		mix.copy('resources/assets/images', 'public/images')
			 .copy('resources/assets/plugins', 'public/plugins')
			 .copy('resources/assets/js', 'public/js');
		
		mix.browserify('app.js');

		mix.browserSync({
			proxy: 'anyware.revlift.dev'
		});
});
