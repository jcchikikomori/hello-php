/*eslint-env node */
'use strict'
const path = require('path')
const webpack = require('webpack')
const PATHS = {
  index: path.join(__dirname, './assets/_js/')
}

module.exports = {
  entry: {
    index: './assets/_js/index.js'
  },
  resolve: {
    extensions: ['', '.js', '.jsx']
  },
  output: {
    path: __dirname,
    filename: './assets/js/[name].js'
  },
  externals: {
    "jquery": "$"
  },
  plugins: [
    new webpack.DefinePlugin({
    'process.env': {
      'NODE_ENV': JSON.stringify('production')
      }
    }),
    new webpack.DefinePlugin({ 'PROD_ENV': true }),
    new webpack.optimize.DedupePlugin(),
    new webpack.optimize.OccurenceOrderPlugin(),
    new webpack.optimize.UglifyJsPlugin({
       compressor: { warnings: false }
    }),
    new webpack.NoErrorsPlugin()
  ],
  stats: { colors: true }
}