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
        './bower_components/materialize/dist/css/materialize.min.css'
    ],

    sass: [
        './web/assets/sass/pages/**/*.scss'
    ],

    fonts: [
        //vendors
        './bower_components/materialize/dist/font/**/*.{ttf,woff,eof,svg}'
    ]
}

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
 * SASS Task
 */
gulp.task('sass', function(){
    gulp.src(config.sass)
        .pipe(plumber())
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(config.dest + '/sass'));
});

/**
 * Fonts Task
 */
gulp.task('fonts', function () {
    gulp.src(config.fonts)
        .pipe(gulp.dest(config.dest + '/font'));
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
gulp.task('default', ['scripts', 'css', 'sass','fonts', 'watch']);