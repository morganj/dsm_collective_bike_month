const webpack = require('webpack'),
    config = require('./webpack.config.js');

webpack(config, function(){
    console.log('Webpack complete.')
});
