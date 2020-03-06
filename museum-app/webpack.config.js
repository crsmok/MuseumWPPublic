"use strict";

//import * as process from "babel-core/lib/transformation/file/options/config";

const path = require("path");
const webpack = require("webpack");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const UglifyJSPlugin = require("uglifyjs-webpack-plugin");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
//const CopyWebpackPlugin= require('copy-webpack-plugin');

const devServer = {
  contentBase: path.resolve("dist"),
  hot: true,
  host: process.env.host || "localhost",
  port: process.env.PORT || 5000
};

const webpackConfig = (env) => {
  const config = {
    entry: {
      app: path.resolve("./src/core/bootstrap.js"),
    },
    output: {
      filename: "bundle.js",
      chunkFilename: "[name].[hash].js",
      path: path.join(__dirname, "dist"),
        publicPath: './'//env === 'build' ? './' : 'http://localhost:5000/',        //ENV === 'build'
       // publicPath: env === 'build' ? './' : 'http://localhost:5000/',        //ENV === 'build'
    },
      resolve: {
          alias: {
              images: path.resolve(__dirname, 'src/public/images/'),
          },
      },
    module: {
      rules: [
        // eslint
        {
          enforce: "pre",
          test: /\.js$/,
          exclude: /node_modules/,
          loader: "eslint-loader",
        },

        // babel
        {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: "babel-loader"
        },

        // html
        {
          test: /\.html$/,
          loader: "raw-loader",
          exclude: path.resolve("./src/index.html")
        },

        {
          test: /\.(jpg|png|svg)$/,
          loader: 'file-loader',
          options: {
            name: 'images/[name].[ext]'
          },
        },
        // css
        {
          test: /\.css$/,
          use: [{
            loader: "style-loader"
          }, {
            loader: "css-loader"
          }]
        },
        // scss
        /*{
          test: /\.(scss)$/,
          use: [
            {
              // Adds CSS to the DOM by injecting a `<style>` tag
              loader: 'style-loader'
            },
            {
              // Interprets `@import` and `url()` like `import/require()` and will resolve them
              loader: 'css-loader'
            },
            {
              // Loader for webpack to process CSS with PostCSS
              loader: 'postcss-loader',
              options: {
                plugins: function () {
                  return [
                    require('autoprefixer')
                  ];
                }
              }
            },
            {
              // Loads a SASS/SCSS file and compiles it to CSS
              loader: 'sass-loader'
            }
          ]
        }*/
          {
              test: /\.scss$/,
              use: ExtractTextPlugin.extract({
                  fallback: 'style-loader',
                  use: ['css-loader', 'sass-loader']
              })
          }
      ]
    },
    plugins: [
      new HtmlWebpackPlugin({
        filename: "index.html",
        template: path.resolve("./src/index.html")
      }),

        new ExtractTextPlugin('style.css'),

      new webpack.optimize.CommonsChunkPlugin({
        name: "common",
        filename: "common.js",
        minChunks: (module) => {
          // this assumes your vendor imports exist in the node_modules directory
          return module.context && module.context.indexOf("node_modules") !== -1;
        }
      }),

      new CleanWebpackPlugin(["dist"]),
    ]
  };

  if (env && env.dev) {
    config.devServer = devServer;
    config.plugins.push(
      new webpack.NamedModulesPlugin(),
      new webpack.HotModuleReplacementPlugin()
    );
  }

  if (env && env.production) {
    config.devtool = "source-map";
    config.plugins.push(
      new UglifyJSPlugin({
        uglifyOptions: {
          warnings: true
        },
        sourceMap: true
      }),
      new webpack.DefinePlugin({
        "process.env.NODE_ENV": JSON.stringify("production")
      })
    );
  }

  return config;
};

module.exports = webpackConfig;
