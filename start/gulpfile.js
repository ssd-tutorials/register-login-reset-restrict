var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass'),
    cssMin = require('gulp-css');

gulp.task('sass', function() {

    return gulp.src('./resources/assets/scss/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/assets/css'));

});

gulp.task('css', ['sass'], function() {

    gulp.src([
            './public/assets/css/app.css'
        ])
        .pipe(concat('app.css'))
        .pipe(cssMin())
        .pipe(gulp.dest('./public/assets/css'));

});

gulp.task('scripts', function() {

    gulp.src([
            './node_modules/jquery/dist/jquery.js',
            './node_modules/ssd-form/src/jquery.ssd-form.js',
            './resources/assets/js/app.js'
        ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/assets/js'));

});

gulp.task('default', ['css', 'scripts']);