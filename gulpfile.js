// Requires
var gulp = require('gulp')
    plumber = require('gulp-plumber'),
    notify = require('gulp-notify'),
    phpspec = require('gulp-phpspec');

// Paths
    var phpspec_path = './bin/phpspec run',
    php_files = ['src/**/*.php', 'spec/**/*.php'];

// Task
gulp.task('phpspec', function() {
    return gulp.src('')
        .pipe(plumber({errorHandler: notify.onError({
            title: "[PHPSpec] Failed!",
            message: "Make it pass!",
            icon: __dirname + '/fail.png'
        })}))
        .pipe(phpspec(phpspec_path, {
            notify: true,
            clear: true
        }))
        .pipe(notify({
            title: "[PHPSpec] Passed!",
            message: "Time to refactor!",
            icon: __dirname + '/pass.png'
        }));
});

gulp.task('watch', function() {
    gulp.watch(php_files, ['phpspec']);
});

gulp.task('default', ['phpspec', 'watch']);
