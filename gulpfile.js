'use strict';

let gulp = require('gulp');
let sass = require('gulp-sass');
let cssnano = require('gulp-cssnano');
let sourcemaps = require('gulp-sourcemaps');
let autoprefixer = require('gulp-autoprefixer');
let concat = require('gulp-concat');
let uglify = require('gulp-uglifyes');
let gutil = require('gulp-util');
let rename = require('gulp-rename');

gulp.task('styles', function() {
    gulp.src('src/sass/main.scss')

    .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(cssnano())
        .pipe(sourcemaps.write('./'))
        .pipe(rename('combined.min.css'))

    .pipe(gulp.dest('dist/public/css/'))
});

gulp.task('scripts', function() {
    gulp.src('src/js/*.js')
        .pipe(uglify({
            mangle: false,
            ecma: 6
        }))
        .on('error', function(err) {
            gutil.log(gutil.colors.red('[Error]'), err.toString());
        })
        .pipe(concat('main.js'))
        .pipe(gulp.dest('dist/public/js/'));
});

gulp.task('watch', function() {
    gulp.watch('src/sass/**/*.scss', ['styles']);
    gulp.watch('src/js/**/*.js', ['scripts']);
});

gulp.task('default', ['styles', 'scripts']);