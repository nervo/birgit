var
    fs       = require('fs'),
    path     = require('path'),
    glob     = require('glob')
    gulpUtil = require('gulp-util');

// Assets
global.assets = glob.sync('src/**/*Bundle/Resources/assets');

// Dev
global.dev = gulpUtil.env.dev ? true : false;

// Tasks
fs.readdirSync(path.resolve(__dirname, 'tasks'))
    .forEach(function(task) {
        require('./tasks/' + task);
    });
