const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: process.env.NODE_ENV || 'development',
  entry: {
    app: './assets/js/app.js',
    styles: './assets/css/app.css',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist'),
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader, // Extract CSS to separate file
          'css-loader',                // Turn CSS into JS modules
          'postcss-loader',            // Process CSS with PostCSS
        ],
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader', // Transpile JS with Babel
        },
      },
      {
        test: /\.ts$/,
        exclude: /node_modules/,
        use: 'ts-loader', // Transpile TypeScript to JavaScript
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css', // Output CSS file
    }),
  ],
  resolve: {
    extensions: ['.ts', '.js'],
  },
  devServer: {
    static: path.join(__dirname, 'dist'),
    compress: true,
    port: 3000,
    proxy: {
      '/': 'http://localhost:10054',
    },
    hot: true,
    watchFiles: ['./**/*.php'], // Watch PHP files for changes
  },
};