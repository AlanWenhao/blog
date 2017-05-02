var gulp = require('gulp');

var sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	imagemin = require('gulp-imagemin'),
	notify = require('gulp-notify'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	cache = require('gulp-cache'),
	rename = require('gulp-rename'),
	connect = require('gulp-connect'),
	livereload = require('gulp-livereload'),
	del = require('del');

// 编译Sass
gulp.task('sass', function() {
    return gulp.src(['./resource/scss/**.scss'])
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest('./public/css'))
        .pipe(rename('main.min.css'))
	    .pipe(minifycss())
	    .pipe(gulp.dest('./public/css'))
	    .pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('cssplugin', function() {
    return gulp.src(['resource/css/*.css'])
        .pipe(concat('plugin.css'))
        .pipe(gulp.dest('./public/css'))
        .pipe(rename('plugin.min.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('./public/css'));
});

gulp.task('images', function() {
  return gulp.src('./resource/img/**/*')
    .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('/public/img'))
    // .pipe(notify({ message: 'Images task complete' }));
});

// 检查，合并，压缩文件
gulp.task('scripts', function() {
    return gulp.src('./resource/js/*.js')
        .pipe(concat('main.js'))
        .pipe(gulp.dest('./public/js'))
        .pipe(rename('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'))
        .pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('jsplugin', function() {
    return gulp.src(['./resource/js/jq/*.js', './resource/js/plugin/*.js'])
        .pipe(concat('plugin.js'))
        .pipe(gulp.dest('./public/js'))
        .pipe(rename('plugin.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'))
});

gulp.task('watch', function() {
    gulp.watch('./resource/scss/*.scss', ['sass']).on('change', livereload.changed);
    gulp.watch('./resource/js/*.js', ['scripts']).on('change', livereload.changed);
    gulp.watch('./resource/img/**/*', ['images']).on('change', livereload.changed);
    livereload.listen();
    //gulp.watch(['public/**']).on('change', livereload.changed);
});

gulp.task('default', function() {
    gulp.start('sass', 'cssplugin', 'scripts', 'jsplugin', 'images', 'watch');
});
