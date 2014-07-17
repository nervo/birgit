var
    _             = require('lodash'),
    fs            = require('fs'),
    rimraf        = require('rimraf'),
    path          = require('path'),
    eventStream   = require('event-stream'),
    prettyHrtime  = require('pretty-hrtime'),
    browserify    = require('browserify'),
    watchify      = require('watchify'),
    debowerify    = require('debowerify'),
    source        = require('vinyl-source-stream'),    
    gulp          = require('gulp'),
    gulpUtil      = require('gulp-util'),
    gulpIf        = require('gulp-if'),
    gulpPlumber   = require('gulp-plumber'),
    streamify     = require('gulp-streamify'),
    gulpUglify    = require('gulp-uglify'),
    gulpJsHint    = require('gulp-jshint'),
    gulpJsCs      = require('gulp-jscs'),
    gulpLogWarn   = require('gulp-logwarn'),
    gulpNotify    = require('gulp-notify'),
    resourceNames = [];

var
    dest = 'web/assets/js';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    global.resources,
    function(resourceDir, resourceName) {

        // Don't treat resources without js assets
        if (!fs.existsSync(resourceDir + '/js')) {
            return;
        }

        if (!global.js[resourceName]) {
            return;
        }

        resourceNames.push(resourceName);

        // Check - Js
        gulp.task('check:js:' + resourceName, function(resourceName, resourceDir) {

            return gulp.src(resourceDir + '/js/**/*.js')
                .pipe(gulpPlumber({
                    errorHandler: gulpNotify.onError({
                        title:  'Gulp - Error',
                        message: '<%= error.message %>'})
                }))
                .pipe(gulpJsHint('app/Resources/js/.jshintrc'))
                .pipe(gulpJsHint.reporter('jshint-stylish'))
                .pipe(gulpNotify(function (file) {
                    if (file.jshint.success) {
                        return false;
                    }
                    var errors = file.jshint.results.map(function(result) {
                        if (result.error) {
                            return '(' + result.error.line + ':' + result.error.character + ') ' + result.error.reason;
                        }
                    }).join("\n");

                    return "\n" + file.relative + "\n" + errors;
                }))
                .pipe(gulpJsCs('app/Resources/js/.jscsrc'))
                .pipe(gulpLogWarn([]));

        }.bind(this, resourceName, resourceDir));

        // Proxy
        function proxy(resourceName, resourceDir, watch) {
            var
                streams = [];

            _.forEach(global.js[resourceName], function(options, file) {

                var
                    bundler  = watch ? watchify() : browserify(),
                    rebundle = function() {
                        var
                            startTime = process.hrtime();
                        if (watch) {
                            gulp.start('check:js:' + resourceName);
                        }
                        gulpUtil.log('Running', gulpUtil.colors.green("'build:js:" + resourceName + "'"), gulpUtil.colors.magenta(file), '...');
                        return bundler
                            .bundle({
                                debug: global.dev
                            })
                            .on('error', function() {
                                var
                                    args = Array.prototype.slice.call(arguments);

                                gulpNotify.onError({
                                    title: 'Gulp - Error',
                                    message: '<%= error.message %>'
                                }).apply(this, args);

                                this.emit('end');
                            })
                            .pipe(source(file))
                            .pipe(gulpIf(
                                !global.dev,
                                streamify(gulpUglify())
                            ))
                            .pipe(gulp.dest(dest))
                            .on('end', function() {
                                var
                                    taskTime = process.hrtime(startTime);
                                    prettyTime = prettyHrtime(taskTime);
                                gulpUtil.log('Finished', gulpUtil.colors.green("'build:js:" + resourceName + "'"), gulpUtil.colors.magenta(file), 'in', gulpUtil.colors.magenta(prettyTime));
                            })
                            .pipe(gulpNotify({
                                title   : 'Gulp - Success',
                                message : "\n" + 'build:js:' + resourceName,
                                onLast  : true
                            }));
                    };


                bundler
                    .add('./' + path.join(resourceDir, 'js',file))
                    .transform(debowerify);

                if (watch) {
                    bundler.on('update', rebundle);
                }

                streams.push(rebundle());
            });

            return eventStream.readArray(streams);
        }

        // Build - Js
        gulp.task('build:js:' + resourceName, function(resourceName, resourceDir) {

            return proxy(resourceName, resourceDir, false);

        }.bind(this, resourceName, resourceDir));

        // Watch - Js
        gulp.task('watch:js:' + resourceName, function(resourceName, resourceDir) {

            return proxy(resourceName, resourceDir, true);

        }.bind(this, resourceName, resourceDir));
    }
);

// Global Clean - Js
gulp.task('clean:js', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Js
gulp.task('check:js', _.map(
    resourceNames,
    function(name) {return 'check:js:' + name;}
));

// Global Build - Js
gulp.task('build:js',
    ['clean:js']
        .concat(
            _.map(
                resourceNames,
                function(name) {return 'build:js:' + name;}
            )
        )
);

// Global Watch - Js
gulp.task('watch:js', _.map(
    resourceNames,
    function(name) {return 'watch:js:' + name;})
);
