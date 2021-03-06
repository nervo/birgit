// Js
global.js = {
    BirgitFront: {
        'front/front.js': {},
        'front/project/project.js': {},
        'front/task/task.js': {}
    }
};

// Gulp
var
    gulp    = require('gulp'),
    plugins = require('gulp-load-plugins')();

// Flags
plugins.util.env.dev = plugins.util.env.dev || false;
plugins.util.env.notify = plugins.util.env.notify || false;
plugins.util.env.verbose = plugins.util.env.verbose || false;

// Tasks
require('require-dir')('./app/Resources/gulp/tasks', {recurse: true});

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
            plugins.util.log('Exec', plugins.util.colors.green(command));
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


// Clean
gulp.task('clean', [
    'clean:images', 'clean:js', 'clean:sass'
]);

// Check
gulp.task('check', [
    'check:images', 'check:js', 'check:sass'
]);

// Lint
gulp.task('lint', [
    'lint:sass'
]);

// Build
gulp.task('build', [
    'build:images', 'build:js', 'build:sass'
]);

// Watch
gulp.task('watch', [
    'watch:images', 'watch:js', 'watch:sass'
]);

// Default
gulp.task('default', [
    'build', 'watch'
]);
