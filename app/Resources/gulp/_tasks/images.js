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
    assets       = require('../assets'),
    assetsNames  = [];

var
    dest = 'web/assets/images';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    assets(),
    function(assetsDir, assetsName) {

        if (!fs.existsSync(assetsDir + '/images')) {
            return;
        }

        assetsNames.push(assetsName);

        // Check - Images
        gulp.task('check:images:' + assetsName);

        // Build - Images
        gulp.task('build:images:' + assetsName, function(assetsName, assetsDir) {

            return gulp.src(assetsDir + '/images/**')
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
                    title: assetsName,
                    showFiles: true
                }))
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'build:images:' + assetsName,
                    onLast  : true
                }));

        }.bind(this, assetsName, assetsDir));

        // Watch - Images
        gulp.task('watch:images:' + assetsName, function(assetsName, assetsDir) {

            return gulp.watch(
                assetsDir + '/images/**',
                ['check:images:' + assetsName, 'build:images:' + assetsName]
            )
            .on('change', function(event) {
                gulpUtil.log(
                    'Watch',
                    "'" + gulpUtil.colors.cyan(event.path) + "'",
                    'has',
                    gulpUtil.colors.magenta(event.type)
                );
            });

        }.bind(this, assetsName, assetsDir));

    }
);

// Global Clean - Images
gulp.task('clean:images', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Images
gulp.task('check:images', _.map(
    assetsNames,
    function(name) {return 'check:images:' + name;}
));

// Global Build - Images
gulp.task('build:images',
    ['clean:images']
        .concat(
            _.map(
                assetsNames,
                function(name) {return 'build:images:' + name;}
            )
        )
);

// Global Watch - Images
gulp.task('watch:images', _.map(
    assetsNames,
    function(name) {return 'watch:images:' + name;})
);
