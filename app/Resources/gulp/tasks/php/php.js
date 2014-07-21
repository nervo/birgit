var
    gulp = require('gulp');

gulp.task('lint:php', function(callback) {
    var
        _            = require('lodash'),
        glob         = require('glob'),
        childProcess = require('child_process'),
        async        = require('async');

    async.eachSeries(
    	glob.sync('src/**/*.php'),
    	function(file, cb) {
            childProcess.exec('php -l ' + file, function(error, stdout, stderr) {
                if (error) {
                	console.log(stderr.trim());
            	}
                cb(error);
            });
    	},
    	function() {
    		callback();
    	}
    );
});

