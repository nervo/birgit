var
    gulp        = require('gulp'),
    gulpPlugins = require('gulp-load-plugins')();

// Bootstrap - Css
gulp.task('bootstrap:css', function() {

    var
        dest = 'web/assets/css';

    return gulp
        .src([
            'bower_components/bootstrap/dist/css/bootstrap.css'
        ])
        .pipe(gulpPlugins.if(
            global.dev,
            gulpPlugins.minifyCss({
                cache: true
            })
        ))
        .pipe(gulp.dest(dest));
});

// Bootstrap - Fonts
gulp.task('bootstrap:fonts', function() {

    var
        dest = 'web/assets/fonts';

    return gulp
        .src([
            'bower_components/bootstrap/dist/fonts/*'
        ])
        .pipe(gulpPlugins.changed(dest))
        .pipe(gulp.dest(dest));
});

// Bootstrap
gulp.task('bootstrap', ['bootstrap:css', 'bootstrap:fonts']);
