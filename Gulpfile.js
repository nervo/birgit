var
    gulp = require('gulp'),
    gulpUtil = require('gulp-util'),
    gulpPlugins = require('gulp-load-plugins')(),
    webpack = require('webpack'),
    webpackConfig = {
        cache: true,
        context: __dirname + '/src',
        entry: {
            task: './Birgit/Front/Bundle/Bundle/Resources/assets/js/task'
        },
        output: {
            path: __dirname + '/web/assets/js',
            publicPath: '/assets/js/',
            filename: '[name].js'
        },
        resolve: {
            modulesDirectories: [
                'node_modules',
                'bower_components'
            ]
        }
    };

gulp.task('webpack', function() {
    webpack(webpackConfig)
        .run(function(error, stats) {
            if (error) {
                throw new gutil.PluginError('webpack:build-dev', error);
            }
            gulpPlugins.util.log('[webpack]', stats.toString({
                colors: true
            }));
        });
});

gulp.task('default', function() {
});
