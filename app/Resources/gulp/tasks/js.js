var
    _            = require('lodash'),
    fs           = require('fs'),
    rimraf       = require('rimraf'),
    path         = require('path'),
    eventStream  = require('event-stream'),
    prettyHrtime = require('pretty-hrtime'),
    browserify   = require('browserify'),
    watchify     = require('watchify'),
    debowerify   = require('debowerify'),
    source       = require('vinyl-source-stream'),    
    gulp         = require('gulp'),
    gulpUtil     = require('gulp-util'),
    gulpIf       = require('gulp-if'),
    gulpPlumber  = require('gulp-plumber'),
    streamify    = require('gulp-streamify'),
    gulpUglify   = require('gulp-uglify'),
    gulpJsHint   = require('gulp-jshint'),
    gulpJsCs     = require('gulp-jscs'),
    gulpLogWarn  = require('gulp-logwarn'),
    gulpNotify   = require('gulp-notify'),
    assetsNames  = [];

var
    dest = 'web/assets/js';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    global.assets,
    function(assetsDir, assetsName) {

        // Don't treat assets without js
        if (!fs.existsSync(assetsDir + '/js')) {
            return;
        }

        if (!global.js[assetsName]) {
            return;
        }

        assetsNames.push(assetsName);

        // Check - Js
        gulp.task('check:js:' + assetsName, function(assetsName, assetsDir) {

            return gulp.src(assetsDir + '/js/**/*.js')
                .pipe(gulpPlumber({
                    errorHandler: gulpNotify.onError({
                        title:  'Gulp - Error',
                        message: '<%= error.message %>'})
                }))
                .pipe(gulpJsHint('app/Resources/jshint.json'))
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
                .pipe(gulpJsCs('app/Resources/jscs.json'))
                .pipe(gulpLogWarn([]));

        }.bind(this, assetsName, assetsDir));

        // Proxy
        function proxy(assetsName, assetsDir, watch) {
            var
                streams = [];

            _.forEach(global.js[assetsName], function(options, file) {

                var
                    bundler  = watch ? watchify() : browserify(),
                    rebundle = function() {
                        var
                            startTime = process.hrtime();
                        if (watch) {
                            gulp.start('check:js:' + assetsName);
                        }
                        gulpUtil.log('Running', gulpUtil.colors.green("'build:js:" + assetsName + "'"), gulpUtil.colors.magenta(file), '...');
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
                                gulpUtil.log('Finished', gulpUtil.colors.green("'build:js:" + assetsName + "'"), gulpUtil.colors.magenta(file), 'in', gulpUtil.colors.magenta(prettyTime));
                            })
                            .pipe(gulpNotify({
                                title   : 'Gulp - Success',
                                message : "\n" + 'build:js:' + assetsName,
                                onLast  : true
                            }));
                    };


                bundler
                    .add('./' + path.join(assetsDir, 'js',file))
                    .transform(debowerify);

                if (watch) {
                    bundler.on('update', rebundle);
                }

                streams.push(rebundle());
            });

            return eventStream.readArray(streams);
        }

        // Build - Js
        gulp.task('build:js:' + assetsName, function(assetsName, assetsDir) {

            return proxy(assetsName, assetsDir, false);

        }.bind(this, assetsName, assetsDir));

        // Watch - Js
        gulp.task('watch:js:' + assetsName, function(assetsName, assetsDir) {

            return proxy(assetsName, assetsDir, true);

        }.bind(this, assetsName, assetsDir));
    }
);

// Global Clean - Js
gulp.task('clean:js', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Js
gulp.task('check:js', _.map(
    assetsNames,
    function(name) {return 'check:js:' + name;}
));

// Global Build - Js
gulp.task('build:js',
    ['clean:js']
        .concat(
            _.map(
                assetsNames,
                function(name) {return 'build:js:' + name;}
            )
        )
);

// Global Watch - Js
gulp.task('watch:js', _.map(
    assetsNames,
    function(name) {return 'watch:js:' + name;})
);
