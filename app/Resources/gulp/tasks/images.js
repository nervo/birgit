var
    _             = require('lodash'),
    fs            = require('fs'),
    rimraf        = require('rimraf'),
    gulp          = require('gulp'),
    gulpUtil      = require('gulp-util'),
    gulpIf        = require('gulp-if'),
    gulpPlumber   = require('gulp-plumber'),
    gulpChanged   = require('gulp-changed'),
    gulpImagemin  = require('gulp-imagemin'),
    gulpSize      = require('gulp-size'),
    gulpNotify    = require('gulp-notify'),
    resourceNames = [];

var
    dest = 'web/assets/images';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    global.resources,
    function(resourceDir, resourceName) {

        if (!fs.existsSync(resourceDir + '/images')) {
            return;
        }

        resourceNames.push(resourceName);

        // Check - Images
        gulp.task('check:images:' + resourceName);

        // Build - Images
        gulp.task('build:images:' + resourceName, function(resourceName, resourceDir) {

            return gulp.src(resourceDir + '/images/**')
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
                    title: resourceName,
                    showFiles: true
                }))
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'build:images:' + resourceName,
                    onLast  : true
                }));

        }.bind(this, resourceName, resourceDir));

        // Watch - Images
        gulp.task('watch:images:' + resourceName, function(resourceName, resourceDir) {

            return gulp.watch(
                resourceDir + '/images/**',
                ['check:images:' + resourceName, 'build:images:' + resourceName]
            )
            .on('change', function(event) {
                gulpUtil.log(
                    'Watch',
                    "'" + gulpUtil.colors.cyan(event.path) + "'",
                    'has',
                    gulpUtil.colors.magenta(event.type)
                );
            });

        }.bind(this, resourceName, resourceDir));

    }
);

// Global Clean - Images
gulp.task('clean:images', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Images
gulp.task('check:images', _.map(
    resourceNames,
    function(name) {return 'check:images:' + name;}
));

// Global Build - Images
gulp.task('build:images',
    ['clean:images']
        .concat(
            _.map(
                resourceNames,
                function(name) {return 'build:images:' + name;}
            )
        )
);

// Global Watch - Images
gulp.task('watch:images', _.map(
    resourceNames,
    function(name) {return 'watch:images:' + name;})
);
