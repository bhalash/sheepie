/**
 * Gulp Build Script
 * -----------------------------------------------------------------------------
 * @category   Node.js Build File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var sourcemap = require('gulp-sourcemaps');
var prefix = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

var assets = {
    sass: 'assets/css/',
    js: 'assets/js/',
};

var paths = {
    sass: {
        batch: assets.sass + '/**/*.scss',
        output: assets.sass
    },
    js: {
        batch: assets.js + '*.js',
        output: assets.js + '/min/'
    }
};

var prefixes = [
    'last 1 version', 
    '> 1%',
    'ie 10',
    'ie 9'
];

gulp.task('sass', function() {
    // Production minified sass, without sourcemap.
    sass(assets.sass, {
            style: 'compressed'
        })
        .on('error', function(err) {
            console.log(err.message);
        })
        .pipe(prefix(prefixes))
        .pipe(gulp.dest(paths.sass.output));
});

gulp.task('sass-dev', function() {
    // Development unminified sass, with sourcemap.
    sass(assets.sass, {
            sourcemap: true,
        })
        .on('error', function(err) {
            console.log(err.message);
        })
        .pipe(prefix(prefixes))
        .pipe(sourcemap.write())
        .pipe(gulp.dest(paths.sass.output));
});

gulp.task('js', function() {
    // Minify all scripts in the JS folder.
    gulp.src(paths.js.batch)
        .pipe(uglify())
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest(paths.js.output));
});

gulp.task('default', function() {
    gulp.watch(paths.js.batch, ['js']);
    gulp.watch(paths.sass.batch, ['sass']);
});

gulp.task('dev', function() {
    gulp.watch(paths.sass.batch, ['sass-dev']);
});
