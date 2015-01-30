// Requires
var gulp = require('gulp')
    plumber = require('gulp-plumber'),
    notify = require('gulp-notify'),
    phpunit = require('gulp-phpunit');

// Paths
    var phpunit_path = 'bin/phpunit',
    php_files = ['src/**/*.php', 'tests/**/*.php'];

// Task
gulp.task('phpunit', function() {
    return gulp.src('phpunit.xml')
        .pipe(plumber({errorHandler: notify.onError({
            title: "[PHPUnit] Vermelho!",
            message: ":'(",
            icon: __dirname + '/fail.png'
        })}))
        .pipe(phpunit(phpunit_path, {
            notify: true,
            clear: true,
            debug: false
        }))
        .pipe(notify({
            title: "[PHPUnit] Verde!",
            message: ":D",
            icon: __dirname + '/pass.png'
        }));
});

gulp.task('watch', function() {
    gulp.watch(php_files, ['phpunit']);
});

gulp.task('default', ['phpunit', 'watch']);
