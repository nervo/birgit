// Gulp
var
    gulp = require('gulp'),
    gulpUtil = require('gulp-util'),
    gulpPlugins = require('gulp-load-plugins')();

// Webpack
var
    webpack = require('webpack'),
    webpackConfig = {
        cache: true,
        context: __dirname + '/src',
        entry: {
            project: './Birgit/Front/Bundle/Bundle/Resources/assets/js/project',
            task: './Birgit/Front/Bundle/Bundle/Resources/assets/js/task'
        },
        output: {
            path: __dirname + '/web/assets/js',
            publicPath: '/assets/js/',
            filename: '[name].js',
            chunkFilename: 'chunk.[id].js'
        },
        resolve: {
            modulesDirectories: [
                'node_modules',
                'bower_components'
            ],
            alias: {
                jquery:  'jquery/dist/jquery',
                angular: 'angular/angular',
                d3:      'd3/d3'
            }
        },
        module: {
            loaders: [
                // Exports Angular
                {test: /[\/]angular\.js$/, loader: 'exports?angular'}
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

gulp.task('css', function() {
    gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.css'
    ])
        .pipe(gulp.dest('web/assets/css'));
});

gulp.task('watch', function() {
    gulp.watch('src/**/*.js', ['webpack']);
});

gulp.task('default', ['css', 'webpack'], function() {
});
