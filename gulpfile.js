'use strict';

var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    watch = require('gulp-watch'),
    minifyCss = require('gulp-minify-css'),
    sass = require('gulp-sass'),
    del = require('del');

var config = {
    dest: 'web/assets',

    scripts: [
        // vendors
        './bower_components/html5-boilerplate/src/js/**/*.js',
        './bower_components/materialize/dist/js/materialize.min.js',
        './node_modules/mustache/mustache.min.js',

        // app
        './web/assets/js/app/**/**/*.js'
    ],

    css: [
        // vendors
        './bower_components/normalize.css/normalize.css',
    ],

    sass: {
        build: './web/assets/sass/build.scss',
        watch: [
            './web/assets/sass/**/**/**/**/*.scss',
        ]
    },

    fonts: [
        //vendors
        './bower_components/materialize/dist/font/**/*.{ttf,woff,eof,svg}'
    ]
}

/**
 * Clean files and folders
 */
gulp.task('clean', function() {
    del([
        './web/assets/css/app.min.css',
        './web/assets/js/app.min.js',
        './web/assets/font/**/*.{ttf,woff,eof,svg}'
    ]).then(function (paths) {
        // console.log('Deleted files/folders: \n', paths.join('\n'));
    });
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
gulp.task('sass', function() {
    gulp.src(config.sass.build)
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
    watch(config.sass.watch, function () {
        console.log('sass watched :(')
        // gulp.start('sass');
    });

    watch(config.css, function () {
        gulp.start('css');
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
gulp.task('default', [
    'clean',
    'fonts',
    'sass',
    'css',
    'scripts',
    'watch'
]);