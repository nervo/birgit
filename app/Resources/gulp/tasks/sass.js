var
    _             = require('lodash'),
    fs            = require('fs'),
    rimraf        = require('rimraf'),
	gulp          = require('gulp'),
    gulpUtil      = require('gulp-util'),
    gulpPlumber   = require('gulp-plumber'),
    gulpFilter    = require('gulp-filter'),
    gulpSass      = require('gulp-sass'),
    gulpScssLint  = require('gulp-scss-lint'),
    gulpSize      = require('gulp-size'),
    gulpNotify    = require('gulp-notify'),
    bundleNames   = [];

var
    dest = 'web/assets/css';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        // Don't treat bundles without sass assets
        if (!fs.existsSync(bundleDir + '/sass')) {
            return;
        }

        bundleNames.push(bundleName);

        // Check - Sass
        gulp.task('check:sass:' + bundleName, function(bundleName, bundleDir) {

            return gulp.src(bundleDir + '/sass/**/*.scss')
                .pipe(gulpScssLint({
                    config: 'app/Resources/sass/scss-lint.yml'
                }))
                .pipe(gulpNotify(function (file) {
                    if (file.scsslint.success) {
                        return false;
                    }
                    var issues = file.scsslint.issues.map(function(issue) {
                        return '(' + issue.line + ':' + issue.column + ') ' + issue.severity + ':' + issue.reason;
                    }).join("\n");

                    return "\n" + file.relative + "\n" + issues;
                }));

        }.bind(this, bundleName, bundleDir));

        // Build - Sass
        gulp.task('build:sass:' + bundleName, function(bundleName, bundleDir) {

            return gulp.src(bundleDir + '/sass/**/*.scss')
                .pipe(gulpPlumber({
                    errorHandler: gulpNotify.onError({
                        title:  'Gulp - Error',
                        message: '<%= error.message %>'})
                }))
                .pipe(gulpFilter('**/!(_)'))
                .pipe(gulpSass({
                    errLogToConsole: true,
                    includePaths: [
                        'bower_components'
                    ],
                    outputStyle: global.dev ? 'nested' : 'compressed',
                    precision: 10,
                    sourceComments: global.dev ? 'map' : 'none'
                }))
                .pipe(gulpSize({
                    title: bundleName,
                    showFiles: true
                }))
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'build:sass:' + bundleName,
                    onLast  : true
                }));

        }.bind(this, bundleName, bundleDir));

        // Watch - Sass
        gulp.task('watch:sass:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/sass/**',
                ['check:sass:' + bundleName, 'build:sass:' + bundleName]
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

// Global Clean - Sass
gulp.task('clean:sass', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Sass
gulp.task('check:sass', _.map(
    bundleNames,
    function(name) {return 'check:sass:' + name;}
));

// Global Build - Sass
gulp.task('build:sass',
    ['clean:sass']
        .concat(
            _.map(
                bundleNames,
                function(name) {return 'build:sass:' + name;}
            )
        )
);

// Global Watch - Sass
gulp.task('watch:sass', _.map(
    bundleNames,
    function(name) {return 'watch:sass:' + name;})
);
