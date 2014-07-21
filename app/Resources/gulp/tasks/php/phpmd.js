var
    gulp = require('gulp');

gulp.task('phpmd', function(callback) {

    var
        spawn = require('child_process').spawn;

    spawn(
		'phpmd',
 		[
 			'src',
 			'text',
 			'app/Resources/phpmd.xml'
 		],
 		{stdio: 'inherit'}
 	).on('close', function(code, signal) {
    	callback();
    });

});
