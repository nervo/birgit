var
    _            = require('lodash'),
    fs           = require('fs'),
    gulp         = require('gulp'),
    gulpUtil     = require('gulp-util'),
    gulpPlumber  = require('gulp-plumber'),
    gulpChanged  = require('gulp-changed'),
    gulpImagemin = require('gulp-imagemin'),
    gulpNotify   = require('gulp-notify'),
    bundleNames  = [];

gulpNotify.logLevel(0);

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        if (!fs.existsSync(bundleDir + '/images')) {
            return;
        }

        bundleNames.push(bundleName);

        // Images
        gulp.task('images:' + bundleName, function(bundleName, bundleDir) {

            var
                dest = 'web/assets/images';

            return gulp.src(bundleDir + '/images/**')
                .pipe(gulpPlumber({
                    errorHandler: gulpNotify.onError({
                        title:  'Gulp - Error',
                        message: '<%= error.message %>'})
                }))
                .pipe(gulpChanged(dest))
                .pipe(gulpImagemin())
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'images:' + bundleName,
                    onLast  : true
                }));

        }.bind(this, bundleName, bundleDir));

        // Watch - Images
        gulp.task('watch:images:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/images/**',
                ['images:' + bundleName]
            )
            .on('change', function(event) {
                gulpUtil.log(
                    'Watch',
                    "'" + gulpUtil.colors.cyan(event.path) + "'",
                    'has',
                    gulpUtil.colors.magenta(event.type)
                );
            });

        }.bind(this, bundleName, bundleDir));

    }
);

// Global Images
gulp.task('images', _.map(
    bundleNames,
    function(name) {return 'images:' + name;})
);

// Global Watch - Images
gulp.task('watch:images', _.map(
    bundleNames,
    function(name) {return 'watch:images:' + name;})
);
