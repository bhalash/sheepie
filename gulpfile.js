/**
 * Gulp Build Script
 * -----------------------------------------------------------------------------
 * @category   Node.js Build File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var sourcemap = require('gulp-sourcemaps');
var prefix = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

var assets = {
    folder: './assets/',
    js: './assets/js/',
    css: './assets/css/'
};

var paths = {
    css: {
        folder: assets.css,
        batch: assets.css + '*.scss',
        main: assets.css + 'main.scss',
        ie: assets.css + 'ie9.scss',
        out: assets.css
    },
    js: {
        folder: assets.js,
        batch: assets.js + '*.js',
        main: assets.js + 'main.js',
        out: assets.js + '/min/'
    }
};

var prefixes = [
    'last 1 version', 
    '> 1%',
    'ie 10',
    'ie 9'
];

gulp.task('sass', function() {
    // Build CSS.
    sass(paths.css.main, {
            style: 'compressed'
        })
        .on('error', function(err) {
            console.log(err.message);
        })
        .pipe(prefix(prefixes))
        .pipe(gulp.dest(paths.css.out));
});

gulp.task('sass-debug', function() {
    // Development and debug CSS.
    sass(paths.css.main, {
            sourcemap: true,
            style: 'compressed'
        })
        .on('error', function(err) {
            console.log(err.message);
        })
        .pipe(prefix(prefixes))
        .pipe(sourcemap.write())
        .pipe(gulp.dest(paths.css.out));
});

gulp.task('ie-sass', function() {
    // Build Internet Explorer CSS.
    sass(paths.css.ie, {
            style: 'compressed'
        })
        .on('error', function(err) {
            console.log(err.message);
        })
        .pipe(prefix(prefixes))
        .pipe(gulp.dest(paths.css.out));
});

gulp.task('ie-sass-dev', function() {
    // Development and debug CSS.
    sass(paths.css.ie, {
            sourcemap: true,
            style: 'compressed'
        })
        .on('error', function(err) {
            console.log(err.message);
        })
        .pipe(prefix(prefixes))
        .pipe(sourcemap.write())
        .pipe(gulp.dest(paths.css.out));
});

gulp.task('js', function() {
    // Minify all scripts in the JS folder.
    gulp.src(paths.js.batch)
        .pipe(uglify())
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest(paths.js.out));
});

gulp.task('default', function() {
    gulp.watch(paths.js.batch, ['js']);
    gulp.watch(paths.sass.batch, ['sass']);
    gulp.watch(paths.sass.ie, ['ie-sass']);
});

gulp.task('sass-dev-watch', function() {
    gulp.watch(paths.sass.batch, ['sass-dev']);
    gulp.watch(paths.sass.ie, ['ie-sass-dev']);
});
