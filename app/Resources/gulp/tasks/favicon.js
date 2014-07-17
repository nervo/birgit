var
    _             = require('lodash'),
    fs            = require('fs'),
    gulp          = require('gulp'),
    favicons      = require('favicons'),
    resourceNames = [];

var
    dest = 'web';

_.forEach(
    global.resources,
    function(resourceDir, resourceName) {

        if (!fs.existsSync(resourceDir + '/favicon/favicon.png')) {
            return;
        }

        resourceNames.push(resourceName);

        // Favicon
        gulp.task('favicon:' + resourceName, function(resourceName, resourceDir, callback) {

            favicons({
                // I/O
                source: resourceDir + '/favicon/favicon.png',
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

        }.bind(this, resourceName, resourceDir));

    }
);

// Global - Favicon
gulp.task('favicon',
    _.map(
        resourceNames,
        function(name) {return 'favicon:' + name;}
    )
);
