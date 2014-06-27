var
    _            = require('lodash'),
    fs           = require('fs'),
    rimraf       = require('rimraf'),
    gulp         = require('gulp'),
    gulpUtil     = require('gulp-util'),
    gulpIf       = require('gulp-if'),
    gulpPlumber  = require('gulp-plumber'),
    gulpChanged  = require('gulp-changed'),
    gulpImagemin = require('gulp-imagemin'),
    gulpSize     = require('gulp-size'),
    gulpNotify   = require('gulp-notify'),
    bundleNames  = [];

var
    dest = 'web/assets/images';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        if (!fs.existsSync(bundleDir + '/images')) {
            return;
        }

        bundleNames.push(bundleName);

        // Check - Images
        gulp.task('check:images:' + bundleName);

        // Build - Images
        gulp.task('build:images:' + bundleName, function(bundleName, bundleDir) {

            return gulp.src(bundleDir + '/images/**')
                .pipe(gulpPlumber({
                    errorHandler: gulpNotify.onError({
                        title:  'Gulp - Error',
                        message: '<%= error.message %>'})
                }))
                .pipe(gulpIf(
                    global.dev,
                    gulpChanged(dest)
                ))
                .pipe(gulpIf(
                    !global.dev,
                    gulpImagemin()
                ))
                .pipe(gulpSize({
                    title: bundleName,
                    showFiles: true
                }))
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'build:images:' + bundleName,
                    onLast  : true
                }));

        }.bind(this, bundleName, bundleDir));

        // Watch - Images
        gulp.task('watch:images:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/images/**',
                ['check:images:' + bundleName, 'build:images:' + bundleName]
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

// Global Clean - Images
gulp.task('clean:images', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Images
gulp.task('check:images', _.map(
    bundleNames,
    function(name) {return 'check:images:' + name;}
));

// Global Build - Images
gulp.task('build:images',
    ['clean:images']
        .concat(
            _.map(
                bundleNames,
                function(name) {return 'build:images:' + name;}
            )
        )
);

// Global Watch - Images
gulp.task('watch:images', _.map(
    bundleNames,
    function(name) {return 'watch:images:' + name;})
);
