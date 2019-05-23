const path = require('path');

module.exports = {
    mode: 'development',
    entry: {
        app: './src/app.js',
        maps: './src/maps.js',
        admin: './src/admin.js',
        autocomplete_algolia: './src/autocomplete-algolia.js',
        autocomplete_google: './src/autocomplete-google.js',
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist/js')
    },
    module: {
        rules: [{
            test: /\.(js|jsx)$/,
            exclude: /node_modules/,
            use: {
                loader: 'babel-loader'
            }
        },{
            test: /\.css$/,
            use: ['style-loader','css-loader']
        },{
            test: /\.scss$/,
            use: ["style-loader", "css-loader", "sass-loader"]
        },{
            test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
            use: [{
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]',
                    outputPath: 'fonts/'
                }
            }]
        }]
    },
    externals: function (context, request, callback) {
        if (/xlsx|canvg|pdfmake/.test(request)) {
            return callback(null, "commonjs " + request);
        }
        callback();
    }
};