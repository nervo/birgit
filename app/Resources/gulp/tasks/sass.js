var
    _             = require('lodash'),
    fs            = require('fs'),
	gulp          = require('gulp'),
    gulpUtil      = require('gulp-util'),
    gulpIf        = require('gulp-if'),
    gulpPlumber   = require('gulp-plumber'),
    gulpFilter    = require('gulp-filter'),
    gulpSass      = require('gulp-ruby-sass'),
    gulpScssLint  = require('gulp-scss-lint'),
    gulpMinifyCss = require('gulp-minify-css'),
    gulpNotify    = require('gulp-notify'),
    bundleNames   = [];

gulpNotify.logLevel(0);

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        if (!fs.existsSync(bundleDir + '/sass')) {
            return;
        }

        bundleNames.push(bundleName);

        // Sass
        gulp.task('sass:' + bundleName, function(bundleName, bundleDir) {

            var
                dest = 'web/assets/css';

            return gulp.src(bundleDir + '/sass/**/*.scss')
                .pipe(gulpPlumber({
                    errorHandler: gulpNotify.onError({
                        title:  'Gulp - Error',
                        message: '<%= error.message %>'})
                }))
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
                }))
                .pipe(gulpFilter('**/!(_)'))
                .pipe(gulpSass({
                    sourcemap: global.dev,
                    debugInfo: global.dev,
                    lineNumbers: global.dev,
                    style: global.dev ? 'nested' : 'compressed',
                    precision: 10,
                    loadPath: [
                        bundleDir + 'sass',
                        'bower_components'
                    ]
                }))
                .pipe(gulp.dest(dest))
                .pipe(gulpNotify({
                    title   : 'Gulp - Success',
                    message : "\n" + 'sass:' + bundleName,
                    onLast  : true
                }));

        }.bind(this, bundleName, bundleDir));

        // Watch - Sass
        gulp.task('watch:sass:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/sass/**',
                ['sass:' + bundleName]
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

// Global Sass
gulp.task('sass', _.map(
    bundleNames,
    function(name) {return 'sass:' + name;})
);

// Global Watch - Sass
gulp.task('watch:sass', _.map(
    bundleNames,
    function(name) {return 'watch:sass:' + name;})
);
