var
    _                  = require('lodash'),
    fs                 = require('fs'),
    gulp               = require('gulp'),
    gulpUtil           = require('gulp-util'),
    gulpRimraf         = require('gulp-rimraf'),
    metaimageGenerator = require('metaimage-generator'),
    bundleNames        = [];

var
    dest = 'web';

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        if (!fs.existsSync(bundleDir + '/favicon')) {
            return;
        }

        bundleNames.push(bundleName);

        // Build - Metaimage
        gulp.task('build:metaimage:' + bundleName, function(bundleName, bundleDir, callback) {

            metaimageGenerator({
                source: bundleDir + '/favicon/favicon.png',
                types: [
      				'apple',
      				'android',
      				'opengraph',
      				'windows'
  				],
                out: dest,
                upscale: false
            });

        }.bind(this, bundleName, bundleDir));

        // Watch - Metaimage
        gulp.task('watch:favicon:' + bundleName, function(bundleName, bundleDir) {

            return gulp.watch(
                bundleDir + '/favicon/**',
                ['build:metaimage:' + bundleName]
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

// Global Clean - Metaimage
gulp.task('clean:metaimage', function() {
    return gulp.src([
    		dest + '/apple-touch-icon.png',
    		dest + '/android-touch-icon.png',
    		dest + '/open-graph.png',
    		dest + '/windows-touch-icon.png'
    	], {read: false})
        .pipe(gulpRimraf());
});

// Global Build - Metaimage
gulp.task('build:metaimage',
    ['clean:metaimage']
        .concat(
            _.map(
                bundleNames,
                function(name) {return 'build:metaimage:' + name;}
            )
        )
);
