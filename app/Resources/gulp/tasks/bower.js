var
    gulp        = require('gulp'),
    gulpInstall = require('gulp-install');

// Global Install - Bower
gulp.task('install:bower', function() {
	return gulp.src(['./bower.json'])
  		.pipe(gulpInstall());
});
