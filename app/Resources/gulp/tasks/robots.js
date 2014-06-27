var
    _               = require('lodash'),
    gulp            = require('gulp'),
    robotsGenerator = require('robots-generator');

var
    dest = 'web';

gulp.task('robots', function() {
    robotsGenerator(
        _.extend({
            useragent: '*',
            allow: null,
            disallow: null,
            url: null,
            out: dest + '/robots.txt'
        }, global.robots)
    );
});
