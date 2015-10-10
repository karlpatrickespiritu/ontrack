'use strict';

var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    watch = require('gulp-watch'),
    minifyCss = require('gulp-minify-css'),
    sass = require('gulp-sass');

var config = {
    dest: 'web/assets',

    scripts: [
        // vendors
        './bower_components/html5-boilerplate/src/js/**/*.js',
        './bower_components/materialize/dist/js/materialize.min.js',
        './node_modules/mustache/mustache.min.js',

        // app
        './web/assets/js/config/**/*.js',
        './web/assets/js/controllers/**/*.js',
        './web/assets/js/services/**/*.js',
        './web/assets/js/pages/**/*.js'
    ],

    css: [
        // vendors
        './bower_components/normalize.css/normalize.css',
    ],

    sass: [
        // app
        './web/assets/sass/build.scss'
    ],

    materializecssSass: [
        './bower_components/materialize/sass/**/**/*.scss'
    ],

    fonts: [
        //vendors
        './bower_components/materialize/dist/font/**/*.{ttf,woff,eof,svg}'
    ]
}

/**
 * Since I can't override Materializecss' sass defaults using another sass file (with gulp-sass).
 * I'm Just going to copy their sass varialbes on my project :/
 *
 * TODO: find a way to override default materializecss's sass variables usign another sass file.
 *
 */
gulp.task('copy-materialize-sass', function () {
    gulp.src(config.materializecssSass)
        .pipe(gulp.dest(config.dest + '/sass/materializecss'));
});

/**
 * Fonts Task
 */
gulp.task('fonts', function () {
    gulp.src(config.fonts)
        .pipe(gulp.dest(config.dest + '/font'));
});

/**
 * Scripts Task
 */
gulp.task('scripts', function () {
    gulp.src(config.scripts)
        .pipe(plumber())
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.dest + '/js'));
});

/**
 * Converting SASS files to CSS Task
 */
gulp.task('sass', function(){
    gulp.src(config.sass)
        .pipe(plumber())
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('app.min.css'))
        .pipe(minifyCss())
        .pipe(gulp.dest(config.dest + '/css'));
});

/**
 * CSS Task
 */
gulp.task('css', function () {
    gulp.src(config.css)
        .pipe(plumber())
        .pipe(concat('app.min.css'))
        .pipe(minifyCss())
        .pipe(gulp.dest(config.dest + '/css'));
});

/**
 * Watch changes and re run tasks
 */
gulp.task('watch', function () {
    watch(config.css, function () {
        gulp.start('css');
    });

    watch(config.sass, function () {
        gulp.start('sass');
    });

    watch(config.scripts, function () {
        gulp.start('scripts');
    });

    watch(config.fonts, function () {
        gulp.start('fonts');
    });
});

/**
 * Default Task
 */
gulp.task('default', ['copy-materialize-sass', 'scripts', 'sass', 'css', 'fonts', 'watch']);