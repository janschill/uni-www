'use strict';

let gulp = require('gulp');
let sass = require('gulp-sass');
let cssnano = require('gulp-cssnano');
let sourcemaps = require('gulp-sourcemaps');
let autoprefixer = require('gulp-autoprefixer');
let imagemin = require('gulp-imagemin');
let concat = require('gulp-concat');
let uglify = require('gulp-uglify');
let gutil = require('gulp-util');

gulp.task('workflow', function()
{
  gulp.src('./src/sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer(
    {
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(cssnano())
    .pipe(sourcemaps.write('./'))

    .pipe(gulp.dest('./dist/public/css/'))
});

gulp.task('imageMin', function()
{
  gulp.src('src/images/*')
    .pipe(imagemin())
    .pipe(gulp.dest('dist/public/images'))
});

gulp.task('scripts', function()
{
  gulp.src('src/js/*.js')
    .pipe(concat('main.js'))
    .pipe(uglify())
    .on('error', function(err)
    {
      gutil.log(gutil.colors.red('[Error]'), err.toString());
    })
    .pipe(gulp.dest('dist/public/js'));
});

gulp.task('default', function()
{
  gulp.watch('src/sass/*.scss', ['workflow']);
  gulp.watch('./src/images', ['imageMin']);
  gulp.watch('./src/js/*.js', ['scripts']);
});
