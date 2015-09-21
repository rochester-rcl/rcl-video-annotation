var webpack = require('webpack');
var path = require('path');
var ROOT_PATH = path.resolve(__dirname);


module.exports = {
  entry: path.resolve(ROOT_PATH, 'app/main'),
  output: {
    path: path.resolve(ROOT_PATH, 'build'),
    filename: 'bundle.js'
  },
  plugins: [
    new webpack.ProvidePlugin({
    $: "jquery",
    jQuery: "jquery",
    "window.jQuery": "jquery"
})
  ],
  resolve: {
    alias: {
      popcorn: "../resources/popcorn-js/popcorn.js",
      footnote: "../resources/popcorn-js/plugins/footnote/popcorn.footnote.js"
    }

  },
  module: {
    loaders: [
      {
        loaders: ['babel'],

        include: path.resolve[ROOT_PATH, 'app']

      }
    ]


  }
};
