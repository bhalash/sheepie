var concat      = require('gulp-concat'),
    gulp        = require('gulp'),
    prefixer    = require('gulp-autoprefixer'),
    rename      = require('gulp-rename'),
    replace     = require('gulp-replace'),
    sass        = require('gulp-ruby-sass'),
    sourcemap   = require('gulp-sourcemaps'),
    uglify      = require('gulp-uglify');

/**
 * Asset Paths
 * -----------------------------------------------------------------------------
 */

var assets = {
    css: {
        main:   'assets/css/style.css',
        source: 'assets/css/**/*.sass',
        dest:   'assets/css/'
    },
    js: {
        concat: 'sheepie.js',
        source: 'assets/js/*.js',
        dest:   'assets/js/min/'
    },
    sprites: {
        source: 'assets/css/includes/**/*.svg',
        dest:   'assets/css/vectors'
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

gulp.task('js', () => {
    return gulp.src(assets.js.source)
        .pipe(uglify())
        .pipe(concat(assets.js.concat))
        .pipe(gulp.dest(assets.js.dest));
});

/**
 * Production Minified CSS
 * -----------------------------------------------------------------------------
 */

gulp.task('css', () => {
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

gulp.task('css-dev', ['sprites'], () => {
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

gulp.task('default', () => {
    gulp.watch(assets.css.source, ['css']);
});

gulp.task('dev', () => {
    gulp.watch(assets.css.source, ['css-dev']);
});
