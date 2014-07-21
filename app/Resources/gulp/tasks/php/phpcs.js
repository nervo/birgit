var
    gulp = require('gulp');

gulp.task('phpcs', function(callback) {

    var
        spawn = require('child_process').spawn;

    spawn(
		'phpcs',
 		[
 			'--report=full',
 			'--standard=PSR2',
 			'--extensions=php',
 			'--ignore=*Bundle/Resources/*',
 			'src'
 		],
 		{stdio: 'inherit'}
 	).on('close', function(code, signal) {
    	callback();
    });
});

