var
    _           = require('lodash'),
    fs          = require('fs'),
    gulp        = require('gulp'),
    favicons    = require('favicons'),
    bundleNames = [];

var
    dest = 'web';

_.forEach(
    global.bundles,
    function(bundleDir, bundleName) {

        if (!fs.existsSync(bundleDir + '/favicon/favicon.png')) {
            return;
        }

        bundleNames.push(bundleName);

        // Favicon
        gulp.task('favicon:' + bundleName, function(bundleName, bundleDir, callback) {

            favicons({
                // I/O
                source: bundleDir + '/favicon/favicon.png',
                dest: dest,

                // Icon Types
                android: false,
                apple: false,
                coast: false,
                favicons: true,
                firefox: false,
                windows: false,

                // Miscellaneous
                html: null,
                background: '#000000',
                tileBlackWhite: true,
                manifest: null,
                trueColor: false,
                logging: true,
                callback: null
            });

        }.bind(this, bundleName, bundleDir));

    }
);

// Global - Favicon
gulp.task('favicon',
    _.map(
        bundleNames,
        function(name) {return 'favicon:' + name;}
    )
);
