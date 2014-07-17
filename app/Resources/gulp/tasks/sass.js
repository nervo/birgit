var
    _            = require('lodash'),
    fs           = require('fs'),
    rimraf       = require('rimraf'),
	gulp         = require('gulp'),
    gulpUtil     = require('gulp-util'),
    gulpPlumber  = require('gulp-plumber'),
    gulpFilter   = require('gulp-filter'),
    gulpSass     = require('gulp-sass'),
    gulpScssLint = require('gulp-scss-lint'),
    gulpSize     = require('gulp-size'),
    gulpNotify   = require('gulp-notify'),
    assetsNames  = [];

var
    dest = 'web/assets/css';

// Notify log level
gulpNotify.logLevel(0);

_.forEach(
    global.assets,
    function(assetsDir, assetsName) {

        // Don't treat assets without sass
        if (!fs.existsSync(assetsDir + '/sass')) {
            return;
        }

        assetsNames.push(assetsName);

        // Check - Sass
        gulp.task('check:sass:' + assetsName, function(assetsName, assetsDir) {

            return gulp.src(assetsDir + '/sass/**/*.scss')
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

        }.bind(this, assetsName, assetsDir));

        // Build - Sass
        gulp.task('build:sass:' + assetsName, function(assetsName, assetsDir) {

            return gulp.src(assetsDir + '/sass/**/*.scss')
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
                    title: assetsName,
                    showFiles: true
                }))
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'build:sass:' + assetsName,
                    onLast  : true
                }));

        }.bind(this, assetsName, assetsDir));

        // Watch - Sass
        gulp.task('watch:sass:' + assetsName, function(assetsName, assetsDir) {

            return gulp.watch(
                assetsDir + '/sass/**',
                ['check:sass:' + assetsName, 'build:sass:' + assetsName]
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

// Global Clean - Sass
gulp.task('clean:sass', function(callback) {
    rimraf(dest, callback);
});

// Global Check - Sass
gulp.task('check:sass', _.map(
    assetsNames,
    function(name) {return 'check:sass:' + name;}
));

// Global Build - Sass
gulp.task('build:sass',
    ['clean:sass']
        .concat(
            _.map(
                assetsNames,
                function(name) {return 'build:sass:' + name;}
            )
        )
);

// Global Watch - Sass
gulp.task('watch:sass', _.map(
    assetsNames,
    function(name) {return 'watch:sass:' + name;})
);
