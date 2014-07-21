var
    gulp = require('gulp'),
    dest = 'web/assets/images';

gulp.task('images', function() {
    var
        _       = require('lodash'),
        plugins = require('gulp-load-plugins')(),
        assets  = require('../../assets');

    return gulp
        .src(assets.get('/images/**'))
        .pipe(plugins.plumber())
        .pipe(plugins.if(
            plugins.util.env.dev,
            plugins.changed(dest)
        ))
        .pipe(plugins.if(
            !plugins.util.env.dev,
            plugins.imagemin()
        ))
        .pipe(plugins.size({showFiles: true}))
        .pipe(gulp.dest(dest))
        .pipe(plugins.if(
            plugins.util.env.notify,
            plugins.notify({
                title   : 'Gulp - Success',
                message : "\n" + 'images',
                onLast  : true
            })
        ));
});

// Watch
gulp.task('watch:images', function() {
    var
        _        = require('lodash'),
        plugins  = require('gulp-load-plugins')(),
        assets   = require('../../assets');

    return gulp
        .watch(assets.get('/images/**'), ['images'])
        .on('change', function(event) {
            // Set assets name
            assets.setName(event.path);
            // Log
            plugins.util.log(
                'Watched', "'" + plugins.util.colors.cyan(event.path) + "'",
                'has', plugins.util.colors.magenta(event.type)
            );
        });
});

// Clean
gulp.task('clean:images', function(callback) {
    var
        rimraf = require('rimraf');

    rimraf(dest, callback);
});
