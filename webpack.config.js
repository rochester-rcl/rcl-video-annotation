var path = require('path');

var ROOT_PATH = path.resolve(__dirname);

module.exports = {
  entry: path.resolve(ROOT_PATH, 'app/main'),
  output: {
    path: path.resolve(ROOT_PATH, 'build'),
    filename: 'bundle.js'
  },
  module: {
    loaders: [
      {
        loaders: ['babel'],
        include: path.resolve[ROOT_PATH, 'app'],
      }
    ]
    
  }
};
