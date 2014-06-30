var
    _               = require('lodash'),
    gulp            = require('gulp'),
    gulpRimraf      = require('gulp-rimraf'),
    robotsGenerator = require('robots-generator');

var
    dest = 'web';

// Global Clean - Robots
gulp.task('clean:robots', function() {
    return gulp.src(dest + '/robots.txt', {read: false})
        .pipe(gulpRimraf());
});

// Global Build - Robots
gulp.task('build:robots', ['clean:robots'], function(callback) {
    robotsGenerator(
        _.extend({
            useragent: '*',
            allow: null,
            disallow: null,
            url: null,
            out: dest + '/robots.txt',
            callback: callback
        }, global.robots)
    );
});
