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

/**
 * Modules
 * -----------------------------------------------------------------------------
 */

var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var prefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sourcemap = require('gulp-sourcemaps');
var replace = require('gulp-replace');
var concat = require('gulp-concat');

/**
 * Asset Paths
 * -----------------------------------------------------------------------------
 */

var assets = {
    css: {
        main: 'assets/css/style.css',
        critical: 'assets/css/critical.css',
        source: 'assets/css/**/*.scss',
        dest: 'assets/css/'
    },
    js: {
        concat: 'sheepie.js',
        source: 'assets/js/*.js',
        dest: 'assets/js/min/'
    },
    sprites: {
        source: 'assets/css/includes/**/*.svg',
        dest: 'assets/css/vectors'
    }
};

/**
 * Autoprefixer
 * -----------------------------------------------------------------------------
 */

var prefixes = [
    'last 1 version',
    '> 1%',
    'ie 10',
    'ie 9'
];

/**
 * Regex Replacements in comments
 * -----------------------------------------------------------------------------
 * Remove block comments from unminified output CSS.
 */

var regex = {
    match: /^(\/\*|\s\*|\s{3}=).*[\n\r]/mg,
    replace: ''
};

/**
 * Move Sprite Assets
 * -----------------------------------------------------------------------------
 */

gulp.task('sprites', function() {
    gulp.src(assets.sprites.source)
        .pipe(rename({ dirname: '' }))
        .pipe(gulp.dest(assets.sprites.dest));
});

/**
 * Minify JS
 * -----------------------------------------------------------------------------
 * Minify all scripts in the JS folder.
 */

gulp.task('js', function() {
    return gulp.src(assets.js.source)
        .pipe(uglify())
        .pipe(concat(assets.js.concat))
        .pipe(gulp.dest(assets.js.dest));
});

/**
 * Production Minified CSS
 * -----------------------------------------------------------------------------
 */

gulp.task('css', function() {
    sass(assets.css.source, {
        emitCompileError: true,
        style: 'compressed'
    })
    .on('error', sass.logError)
    // .pipe(prefixer(prefixes))
    .pipe(gulp.dest(assets.css.dest));
});

/**
 * Unminified CSS with Sourcemap
 * -----------------------------------------------------------------------------
 */

gulp.task('css-dev', ['sprites'], function() {
    return sass(assets.css.source, {
        emitCompileError: true,
        verbose: true,
        sourcemap: true
    })
    .on('error', sass.logError)
    .pipe(replace(regex.match, regex.replace))
    .pipe(prefixer(prefixes))
    .pipe(sourcemap.write())
    .pipe(gulp.dest(assets.css.dest));
});

/**
 * Watch Tasks
 * -----------------------------------------------------------------------------
 */

gulp.task('default', function() {
    gulp.watch(assets.css.source, ['css']);
});

gulp.task('dev', function() {
    gulp.watch(assets.css.source, ['css-dev']);
});
