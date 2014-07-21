var
    gulp = require('gulp'),
    dest = 'web/assets/css';

gulp.task('sass', function() {
    var
        _       = require('lodash'),
        plugins = require('gulp-load-plugins')(),
        assets  = require('../../assets');

    return gulp
        .src(assets.get('/sass/**/!(_)*.scss'))
        .pipe(plugins.plumber())
        .pipe(plugins.sass({
            errLogToConsole: true,
            includePaths: [
                'bower_components'
            ],
            outputStyle: plugins.util.env.dev ? 'nested' : 'compressed',
            precision: 10,
            sourceComments: plugins.util.env.dev ? 'map' : 'none',
            sourceMap: 'sass' // See : https://github.com/dlmanning/gulp-sass/issues/57
        }))
        .pipe(plugins.size({showFiles: true}))
        .pipe(gulp.dest(dest))
        .pipe(plugins.if(
            plugins.util.env.notify,
            plugins.notify({
                title   : 'Gulp - Success',
                message : "\n" + 'sass',
                onLast  : true
            })
        ));
});

// Watch
gulp.task('watch:sass', function() {
    var
        _       = require('lodash'),
        plugins = require('gulp-load-plugins')(),
        assets  = require('../../assets');

    return gulp
        .watch(assets.get('/sass/**'), ['sass'])
        .on('change', function(event) {
            // Set assets name
            assets.setName(event.path);
            // Log
            plugins.util.log(
                'Watched', "'" + plugins.util.colors.cyan(event.path) + "'",
                'has', plugins.util.colors.magenta(event.type)
            );
        });
});

// Lint
gulp.task('lint:sass', function() {
    var
        _       = require('lodash'),
        plugins = require('gulp-load-plugins')(),
        assets  = require('../../assets');

    return gulp
        .src(assets.get('/sass/**/!(_)*.scss'))
        .pipe(plugins.scssLint({
            config: 'app/Resources/scss-lint.yml'
        }));
});

// Clean
gulp.task('clean:sass', function(callback) {
    var
        rimraf = require('rimraf');

    rimraf(dest, callback);
});
