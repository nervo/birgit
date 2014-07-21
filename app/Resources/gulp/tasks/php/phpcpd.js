var
    gulp = require('gulp');

gulp.task('phpcpd', function(callback) {

    var
        spawn = require('child_process').spawn;

    spawn(
		'phpcpd',
 		[
 			'--exclude=*Bundle/Resources/*',
 			'--ansi',
 			'src'
 		],
 		{stdio: 'inherit'}
 	).on('close', function(code, signal) {
    	callback();
    });

});
