/**
 * Created by jclerc on 06.03.15.
 */
var gulp = require('gulp'),
    runSequence    = require('run-sequence'),
    concat = require('gulp-concat'),
    minifyCss = require('gulp-minify-css'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    del = require('del'),
    uglify = require('gulp-uglify');

gulp.task('default', function() {
    //Sequence
    //runSequence('clean', ['copy', 'copy-partials', 'sass', 'uglify'], 'copy-templates', function() {
    runSequence('concatCss', 'minifyCss', 'concatJs', 'uglify', 'imageMin', function() {
        console.log("Successfully built.");
    })
});

gulp.task('concatCss', function() {
    return gulp.src([
        './app/css/foundation.min.css',
        './app/assets/flickity/flickity.css',
        './app/css/animate.css',
        './app/assets/sweetAlert/sweet-alert.css',
        './app/css/styles.css',
        './app/assets/icoEqnx/styles/icoEqnx-styles.css',
        './app/assets/icoEqnx/styles/icoEqnx.css'
        ])
        .pipe(concat('main.min.css'))
        .pipe(gulp.dest('./dist/css/'));
});

gulp.task('concatJs', function() {
    return gulp.src([
        './app/js/jquery-1.11.1.min.js',
        './app/assets/foundation/foundation.min.js',
        './app/assets/flickity/flickity.pkgd.js',
        './app/assets/masonry/jquery.masonry.min.js',
        './app/assets/Wow/wow.min.js',
        './app/assets/foundation/foundation.equalizer.js',
        './app/assets/mixItUp/jquery.mixitup.js',
        './app/assets/hammer/hammer.min.js',
        './app/js/equinoxe.js',
        './app/js/eqnx_mail.js'
    ])
        .pipe(concat('main.min.js'))
        .pipe(gulp.dest('./dist/js/'));
});

gulp.task('minifyCss', function() {
    gulp.src('./dist/css/*.css')
        .pipe(minifyCss())
        .pipe(gulp.dest('./dist/css/'))
});

gulp.task('uglify', function() {
    gulp.src('./dist/js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./dist/js/'))
});

gulp.task('imageMin', function() {
    return gulp.src('./app/img/**/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('./dist/img/'));
});