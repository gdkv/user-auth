let gulp = require('gulp');
let sass = require('gulp-sass');
let concat = require('gulp-concat');
let uglify = require('gulp-uglify');
let cleancss = require('gulp-clean-css');
let rename = require('gulp-rename');
let autoprefixer = require('gulp-autoprefixer');
let notify = require("gulp-notify");


gulp.task('styles', function() {
    return gulp.src('src/scss/**/*.scss')
        .pipe(sass({ outputStyle: 'expanded' }).on("error", notify.onError()))
        .pipe(rename({ suffix: '.min', prefix : '' }))
        .pipe(autoprefixer(['last 15 versions']))
        .pipe(cleancss( {level: { 1: { specialComments: 0 } } }))
        .pipe(gulp.dest('public/assets/css'))
});

gulp.task('js', function() {
    return gulp.src([
        'src/js/jquery-3.4.1.min.js',
        'src/js/jquery.mask.min.js',
        'src/js/common.js',
    ])
    .pipe(concat('scripts.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('public/assets/js'))
});