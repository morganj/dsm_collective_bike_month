var webpack = require('webpack'),
    ExtractTextPlugin = require('extract-text-webpack-plugin'),
    path = require('path'),
    autoprefixer = require('autoprefixer');

module.exports = {
    devtool: 'inline-source-map',
    resolve: {
        extensions: ['', '.jsx', '.scss', '.js', '.json']
    },
    entry: {
        'index': './src/index.js'
    },
    output: {
        libraryTarget: 'var',
        filename: './app.js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                loader: 'babel-loader',
                query: {
                    "presets": ["es2015", "stage-0", "react"]
                }
            },
            {
                test: /(\.scss|\.css)$/,
                loaders: [
                    require.resolve('style-loader'),
                    require.resolve('css-loader') + '?sourceMap&modules&importLoaders=1&localIdentName=[name]__[local]___[hash:base64:5]',
                    require.resolve('sass-loader') + '?sourceMap'
                ]
            }
        ]
    },
    toolbox: {
        theme: path.join(__dirname, 'app/toolbox-theme.scss')
    },
    postcss: [autoprefixer],
    plugins: [
        new ExtractTextPlugin('react-toolbox.css', {allChunks: true}),
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin(),
        new webpack.optimize.DedupePlugin()
    ],
    externals: [],
    bail: true
};
