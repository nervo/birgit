var
	_           = require('lodash'),
	gulp        = require('gulp'),
	gulpPlugins = require('gulp-load-plugins')(),
    browserify  = require('browserify'),
    debowerify  = require('debowerify'),
    source      = require('vinyl-source-stream');

// Js
gulp.task('js', function() {

	var
		dest = 'web/assets/js';

    return browserify('./src/Birgit/Front/Bundle/Bundle/Resources/assets/js/task.js')
        .transform(debowerify)
        .bundle()
        .pipe(source('task.js'))
        .pipe(gulpPlugins.if(
            !global.dev,
            gulpPlugins.streamify(gulpPlugins.uglify())
        ))
        .pipe(gulp.dest(dest));
});
