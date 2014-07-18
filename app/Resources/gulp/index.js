var
    _        = require('lodash'),
    fs       = require('fs'),
    path     = require('path'),
    glob     = require('glob'),
    gulpUtil = require('gulp-util');

// Assets
global.assets = function() {
    _.forEach(
        glob.sync('src/**/*Bundle/Resources/assets')
            .concat(glob.sync('app/Resources/assets')),
        function(dir) {
            name = dir
                .replace('src/', '')
                .replace('/Resources/assets', '')
                .replace(/Bundle/g, '')
                .replace(/\//g, '');
            global.assets[name] = dir;

            gulpUtil.log(
                'Found',
                "'" + gulpUtil.colors.cyan(name) + "'",
                'assets at',
                gulpUtil.colors.magenta(dir)
            );
        }
    );
};

// Dev
global.dev = gulpUtil.env.dev ? true : false;

// Tasks
/*
fs.readdirSync(path.resolve(__dirname, 'tasks'))
    .forEach(function(task) {
        require('./tasks/' + task);
    });
*/