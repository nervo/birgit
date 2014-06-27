var
    _                = require('lodash'),
    fs               = require('fs'),
    gulp             = require('gulp'),
    gulpUtil         = require('gulp-util'),
    gulpRimraf       = require('gulp-rimraf'),
    faviconGenerator = require('favicon-generator'),
    bundleNames      = [];

var
    dest = 'web';

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        if (!fs.existsSync(bundleDir + '/favicon')) {
            return;
        }

        bundleNames.push(bundleName);

        // Build - Favicon
        gulp.task('build:favicon:' + bundleName, function(bundleName, bundleDir) {

            faviconGenerator({
                source: bundleDir + '/favicon/favicon.png',
                sizes: [16, 32, 48, 64],
                out: dest + '/favicon.ico',
                upscale: false
            });

        }.bind(this, bundleName, bundleDir));

        // Watch - Favicon
        gulp.task('watch:favicon:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/favicon/**',
                ['build:favicon:' + bundleName]
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

// Global Clean - Favicon
gulp.task('clean:favicon', function() {
    return gulp.src(dest + '/favicon.ico', {read: false})
        .pipe(gulpRimraf());
});

// Global Build - Favicon
gulp.task('build:favicon',
    ['clean:favicon']
        .concat(
            _.map(
                bundleNames,
                function(name) {return 'build:favicon:' + name;}
            )
        )
);
