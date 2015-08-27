var gulp 		= require('gulp'),
	plumber		= require('gulp-plumber'),
	concat		= require('gulp-concat'),
	uglify		= require('gulp-uglify'),
	minifyCss	= require('gulp-minify-css');


var config = {
	dest: 'src',

	scripts: [
		'./bower_components/hmt5-boilerplate/dist/js/**/**/*.js'
	],

	css: [
		'./bower_components/normalize.css/normalize.css'
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
		// .pipe(uglify()) -- bug 
		.pipe(minifyCss())
		.pipe(gulp.dest(config.dest + '/css'));
});


gulp.task('default', ['scripts', 'css']);