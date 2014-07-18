var
    gulp = require('gulp'),
    dest = 'web/assets/images';

gulp.task('images', function() {
    var
        _       = require('lodash'),
        plugins = require('gulp-load-plugins')(),
        assets  = require('../../assets').get();

    // Filter on assets
    if (plugins.util.env.assets) {
        assets = _.filter(assets, {name: plugins.util.env.assets});
    }

    return gulp.src(_.map(assets, function(asset) {
            return asset.path + '/images/**';
        }))
        .pipe(plugins.if(
            plugins.util.env.notify,
            plugins.plumber({
                errorHandler: plugins.notify.onError({
                    title:  'Gulp - Error',
                    message: '<%= error.message %>'
                })
            })
        ))
        .pipe(plugins.if(
            plugins.util.env.dev,
            plugins.changed(dest)
        ))
        .pipe(plugins.if(
            !plugins.util.env.dev,
            plugins.imagemin()
        ))
        .pipe(plugins.size({
            showFiles: true
        }))
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

gulp.task('watch:images', function() {
    var
        _        = require('lodash'),
        plugins  = require('gulp-load-plugins')(),
        assets   = require('../../assets');

    return gulp.watch(
        _.map(assets.get(), function(asset) {
            return asset.path + '/images/**';
        }),
        ['images']
    )
    .on('change', function(event) {
        // Set assets name
        plugins.util.env.assets = assets.find(event.path).name;
        // Log
        plugins.util.log(
            'Watched', "'" + plugins.util.colors.cyan(event.path) + "'",
            'has', plugins.util.colors.magenta(event.type)
        );
    });
});
