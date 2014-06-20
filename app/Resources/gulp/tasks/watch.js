var
    _    = require('lodash'),
	gulp = require('gulp');

// Watch
gulp.task('watch', function() {

    gulp.watch(
        _.map(
            global.assets,
            function(asset) {return asset + '/js/*.js';}
        ),
        ['js']
    );

	gulp.watch(
        _.map(
            global.assets,
            function(asset) {return asset + '/images/**';}
        ),
        ['images']
    );

});
