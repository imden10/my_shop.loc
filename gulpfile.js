var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();

gulp.task('serve', ['sass'], function () {

    browserSync.init({
        proxy: "http://translo"
    });

    gulp.watch("resources/assets/sass/*.scss", ['sass']);
    gulp.watch("resources/assets/sass/admin/*.scss", ['sassadmin']);
    gulp.watch("resources/views/**/*.*.php").on('change', browserSync.reload);
    gulp.watch("app/Http/**/*.php").on('change', browserSync.reload);

});

gulp.task('sass', function () {
    return gulp.src("resources/assets/sass/*.scss")
        .pipe(sass({outputStyle: 'compressed'}))
        .on('error', catchErr)
        .pipe(gulp.dest("public/frontend/css"))
        .pipe(browserSync.stream());
});

gulp.task('sassadmin', function () {
    return gulp.src("resources/assets/sass/admin/*.scss")
        .pipe(sass({outputStyle: 'compressed'}))
        .on('error', catchErr)
        .pipe(gulp.dest("public/admin/css"))
        .pipe(browserSync.stream());
});

function catchErr(error) {
    console.log(error);
    this.emit('end');
}

// gulp.task('js', function() {
//     return gulp.src("resources/assets/js/**/*.js")
//         .pipe(js())
//         .on('error', catchErr)
//         .pipe(rename({suffix: '.min'}))
//         .pipe(rename({dirname: ''}))
//         .pipe(gulp.dest("public/frontend/js/"))
//         .pipe(browserSync.stream());
// });

gulp.task('default', ['serve']);