var
    plugins    = require('gulp-load-plugins')(),
    assets     = null,
    assetsName = null;

// Assets name from command line
assetsName = plugins.util.env.assets || null;

module.exports = {
    get: function (suffix) {

        var
            _ = require('lodash');
	
        // On first run, find assets
    	if (assets === null) {

        	assets = [];

        	var
        	    glob    = require('glob'),
                path    = require('path'),
                plugins = require('gulp-load-plugins')();

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

                    plugins.util.log(
                        'Found', "'" + plugins.util.colors.cyan(assetName) + "'",
                        'assets at', plugins.util.colors.magenta(assetPath)
                    );
                }
            );
        }

        // Results to return
        var
            results = assets;

        // Filter on assets Name
        if (assetsName) {
            results = _.filter(results, {name: assetsName});
        }

        // Suffix results
        if (suffix) {
            return _.map(results, function(asset) {
                return asset.path + suffix;
            });
        }

        return results;
    },
    setName: function(path) {
        assetsName = this.find(path).name;
    },
    find: function(path) {
        var
            _ = require('lodash');

        return _.find(assets, function(asset) {
            return path.indexOf(asset.path) === 0;
        });
    }
}