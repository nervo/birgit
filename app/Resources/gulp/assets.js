var assets = null;

module.exports = {
    get: function () {
	
    	if (assets !== null) {
    		return assets;
    	}

    	assets = [];

    	var
    	    _        = require('lodash'),
    	    glob     = require('glob'),
            path     = require('path'),
    	    gulpUtil = require('gulp-util');

        _.forEach(
            glob.sync('src/**/*Bundle/Resources/assets')
                .concat(glob.sync('app/Resources/assets')),
            function(assetPath) {
                
                assetName = assetPath
                    .replace('src/', '')
                    .replace('/Resources/assets', '')
                    .replace(/Bundle/g, '')
                    .replace(/\//g, '');
                
                assets.push({
                    name: assetName,
                    path: path.resolve(assetPath)
                });

                gulpUtil.log(
                    'Found', "'" + gulpUtil.colors.cyan(assetName) + "'",
                    'assets at', gulpUtil.colors.magenta(assetPath)
                );
            }
        );

        return assets;
    },
    find: function(path) {
        var
            _ = require('lodash');

        return _.find(this.get(), function(asset) {
            return path.indexOf(asset.path) === 0;
        });
    }
}