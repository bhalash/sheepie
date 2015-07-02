/**
 * Gulp Build Script
 * -----------------------------------------------------------------------------
 * @category   Node.js Build File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 *
 * This file is part of Sheepie.
 *
 * Sheepie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Sheepie is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Sheepie. If not, see <http://www.gnu.org/licenses/>.
 */

'use strict';

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
    'ie 9',
    'ie 8'
];

gulp.task('css', function() {
    // Build CSS.
    return sass(paths.css.main, {
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
    return gulp.src(paths.js.batch)
        .pipe(uglify())
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest(paths.js.out));
});

gulp.task('default', function() {
    gulp.watch(paths.js.batch, ['js']);
    gulp.watch(paths.css.batch, ['css']);
});
