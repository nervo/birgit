// Js
global.js = {
    BirgitFront: {
        'front/front.js': {},
        'front/project/project.js': {},
        'front/task/task.js': {}
    }
};

// Robots
global.robots = {
    useragent: '*',
    url      : 'http://birgit.dev/'
};

// Tasks
require('./app/Resources/gulp');

// Gulp
var
    gulp = require('gulp'),
    gulpUtil = require('gulp-util');

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


gulp.task('clean', ['clean:images', 'clean:js', 'clean:sass']);

gulp.task('check', ['check:images', 'check:js', 'check:sass']);

gulp.task('build', ['robots', 'build:images', 'build:js', 'build:sass']);

gulp.task('watch', ['watch:images', 'watch:js', 'watch:sass']);

gulp.task('default', ['build', 'watch']);
