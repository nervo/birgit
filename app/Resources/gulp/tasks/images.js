var
    _           = require('lodash'),
    gulp        = require('gulp'),
    gulpPlugins = require('gulp-load-plugins')();

// Images
gulp.task('images', function() {

    var
        dest = 'web/assets/images';

    return gulp
        .src(
            _.map(
                global.assets,
                function(asset) {return asset + '/images/**';}
            )
        )
        .pipe(gulpPlugins.changed(dest))
        .pipe(gulpPlugins.imagemin())
        .pipe(gulp.dest(dest));
});
