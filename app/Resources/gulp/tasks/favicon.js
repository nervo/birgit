var
    _           = require('lodash'),
    fs          = require('fs'),
    gulp        = require('gulp'),
    favicons    = require('favicons'),
    assetsNames = [];

var
    dest = 'web';

_.forEach(
    global.assets,
    function(assetsDir, assetsName) {

        if (!fs.existsSync(assetsDir + '/favicon/favicon.png')) {
            return;
        }

        assetsNames.push(assetsName);

        // Favicon
        gulp.task('favicon:' + assetsName, function(assetsName, assetsDir, callback) {

            favicons({
                // I/O
                source: assetsDir + '/favicon/favicon.png',
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

        }.bind(this, assetsName, assetsDir));

    }
);

// Global - Favicon
gulp.task('favicon',
    _.map(
        assetsNames,
        function(name) {return 'favicon:' + name;}
    )
);
