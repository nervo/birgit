var
    _             = require('lodash'),
    fs            = require('fs'),
    gulp          = require('gulp'),
    gulpUtil      = require('gulp-util'),
    gulpIf        = require('gulp-if'),
    gulpPlumber   = require('gulp-plumber'),
    gulpFilter    = require('gulp-filter'),
    gulpJsHint    = require('gulp-jshint'),
    gulpNotify    = require('gulp-notify'),
    bundleNames   = [];

gulpNotify.logLevel(0);

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        // Don't treat bundles without js assets
        if (!fs.existsSync(bundleDir + '/js')) {
            return;
        }

        bundleNames.push(bundleName);

        // Js
        gulp.task('js:' + bundleName, function(bundleName, bundleDir) {

            var
                dest = 'web/assets/js';

            return gulp.src(bundleDir + '/js/**/*.js')
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
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'js:' + bundleName,
                    onLast  : true
                }));

        }.bind(this, bundleName, bundleDir));

        // Watch - Js
        gulp.task('watch:js:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/js/**',
                ['js:' + bundleName]
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

// Global Js
gulp.task('js', _.map(
    bundleNames,
    function(name) {return 'js:' + name;})
);

// Global Watch - Js
gulp.task('watch:js', _.map(
    bundleNames,
    function(name) {return 'watch:js:' + name;})
);


/*
var
	_           = require('lodash'),
	gulp        = require('gulp'),
    browserify  = require('browserify'),
    debowerify  = require('debowerify'),
    source      = require('vinyl-source-stream');

// Js
gulp.task('js', function() {

	var
		dest = 'web/assets/js';

    return browserify('./src/Birgit/Front/Bundle/Bundle/Resources/assets/js/task.js')
        .transform(debowerify)
        .bundle()
        .pipe(source('task.js'))
        .pipe(gulpPlugins.if(
            !global.dev,
            gulpPlugins.streamify(gulpPlugins.uglify())
        ))
        .pipe(gulp.dest(dest));
});
*/