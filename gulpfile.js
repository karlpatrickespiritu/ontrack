var gulp 		= require('gulp'),
	plumber		= require('gulp-plumber'),
	concat		= require('gulp-concat'),
	uglify		= require('gulp-uglify'),
	minifyCss	= require('gulp-minify-css');


var config = {
	dest: 'src',

	scripts: [
		// vendors
		'./bower_components/html5-boilerplate/src/js/**/*.js',
		'./bower_components/materialize/dist/js/materialize.min.js',
		'./node_modules/mustache/mustache.min.js'
		
		// app
		// './src/js/pages/**/*.js',
		// './src/js/utils/**/*.js'
	],

	css: [
		// vendors
		'./bower_components/normalize.css/normalize.css',
		'./bower_components/materialize/dist/css/materialize.min.css'
	],

	fonts: [
		//vendors
		'./bower_components/materialize/dist/font/**/*.{ttf,woff,eof,svg}'
	]
}

/*
* Scripts Task
**/
gulp.task('scripts', function () {
	gulp.src(config.scripts)
		.pipe(plumber())
		.pipe(concat('app.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest(config.dest + '/js'));
});

/*
* CSS Task
**/
gulp.task('css', function () {
	gulp.src(config.css)
		.pipe(plumber())
		.pipe(concat('app.min.css'))
		.pipe(minifyCss())
		.pipe(gulp.dest(config.dest + '/css'));
});

/*
* Fonts Task
**/
gulp.task('fonts', function() {
	gulp.src(config.fonts)
		.pipe(gulp.dest(config.dest + '/font'));
});

/*
* Default Task
**/
gulp.task('default', ['scripts', 'css', 'fonts']);