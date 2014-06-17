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
            chunkFilename: 'chunk/[id].js'
        },
        resolve: {
            modulesDirectories: [
                'node_modules',
                'bower_components'
            ]
        },
        plugins: [
            new webpack.ResolverPlugin([
                new webpack.ResolverPlugin.DirectoryDescriptionFilePlugin('bower.json', ['main'])
            ])
        ],
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

gulp.task('reset', function(callback) {
    var
        execs = [];

    [
        ['doctrine:database:drop --force', false],
        ['doctrine:database:create', true],
        ['doctrine:schema:create --em=birgit', true],
        ['doctrine:schema:create --em=birgit_task', true],
        ['doctrine:schema:create --em=birgit_event', true],
        ['birgit:test:fixtures', true]
    ].forEach(function(parameters) {
        execs.push(function(command, failOnError, callback) {
            gulpUtil.log('Exec', gulpUtil.colors.green(command));
            require('child_process')
                .exec('bin/console ' + command + ' --ansi', function(error, stdout, stderr) {
                    console.log(stderr);
                    callback(failOnError ? error : null);
                });
        }.bind(this, parameters[0], parameters[1]));
    });

    require('async').series(execs);
})

gulp.task('service:web', function() {
    var
        service = new (require('forever-monitor').Monitor)(
            ['bin/console', 'server:run'], {
                max : 3,
                silent : false
        });

    service.on('exit', function() {
        console.log('Web service has exited after 3 restarts');
    });

    service.start();
});

gulp.task('service:websocket', function() {
    var
        service = new (require('forever-monitor').Monitor)(
            ['bin/console', 'birgit:websocket', '-vv'], {
                max : 3,
                silent : false
        });

    service.on('exit', function () {
        console.log('Websocket service has exited after 3 restarts');
    });

    service.start();
});

gulp.task('service:worker', function() {
    var
        service = new (require('forever-monitor').Monitor)(
            ['bin/console', 'birgit:worker', '-vv'], {
                max : 3,
                silent : false
        });

    service.on('exit', function () {
        console.log('Worker service has exited after 3 restarts');
    });

    service.start();
});

gulp.task('service', ['service:web', 'service:websocket', 'service:worker']);

gulp.task('default', ['css', 'webpack'], function() {
});
