var
    _            = require('lodash'),
    fs           = require('fs'),
    rimraf       = require('rimraf'),
    gulp         = require('gulp'),
    gulpUtil     = require('gulp-util'),
    gulpIf       = require('gulp-if'),
    gulpPlumber  = require('gulp-plumber'),
    gulpChanged  = require('gulp-changed'),
    gulpImagemin = require('gulp-imagemin'),
    gulpSize     = require('gulp-size'),
    gulpNotify   = require('gulp-notify'),
    assetsNames  = [];

gulp.task('phpunit', function(callback) {

    require('child_process')
        .exec(
        	'phpunit --configuration app/Resources/phpunit.xml',
        	function(error, stdout, stderr) {
        		console.log(stdout);
            	callback(error);
        	}
        );
})
