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

var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    prefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    sourcemap = require('gulp-sourcemaps'),
    replace = require('gulp-replace');

var assets = {
    sass: 'assets/css/',
    sprites: 'assets/css/',
    js: 'assets/js/',
};

var assets = {
    css: {
        source: 'assets/css/**/*.scss',
        dest: 'assets/css/'
    },
    js: {
        source: 'assets/js/*.js',
        dest: 'assets/js/min/'
    },
    sprites: {
        source: 'assets/css/includes/**/*.svg',
        dest: 'assets/css/vectors'
    }
};

var prefixes = [
    // Autoprefixer.
    'last 1 version', 
    '> 1%',
    'ie 10',
    'ie 9'
];

var regex = {
    comments: {
        // Remove block comments from output CSS.
        match: /^(\/\*|\s\*|\s{3}=).*[\n\r]/mg,
        replace: ''
    }
};

gulp.task('sprites', function() {
    gulp.src(assets.sprites.source)
        .pipe(gulp.dest(assets.sprites.dest));
});

gulp.task('css', function() {
    // Production minified sass, without sourcemap.
    return sass(assets.css.source, {
            emitCompileError: true,
            style: 'compressed'
        })
        .on('error', sass.logError)
        .pipe(prefixer(prefixes))
        .pipe(gulp.dest(assets.css.dest));
});

gulp.task('css-dev', function() {
    // Development unminified sass, with sourcemap.
    return sass(assets.css.source, {
            emitCompileError: true,
            sourcemap: true
        })
        .on('error', sass.logError)
        .pipe(replace(regex.comments.match, regex.comments.replace))
        .pipe(prefixer(prefixes))
        .pipe(sourcemap.write())
        .pipe(gulp.dest(assets.css.dest));
});

gulp.task('js', function() {
    // Minify all scripts in the JS folder.
    return gulp.src(assets.js.source)
        .pipe(uglify())
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest(assets.js.dest));
});

gulp.task('default', function() {
    gulp.watch(assets.js.source, ['js']);
    gulp.watch(assets.css.source, ['css']);
    gulp.watch(assets.sprites.source, ['sprites']);
});

gulp.task('dev', function() {
    gulp.watch(assets.css.source, ['css-dev']);
    gulp.watch(assets.sprites.source, ['sprites']);
});
