import Webpack from 'webpack'
import path from 'path'
import ExtractTextPlugin from 'extract-text-webpack-plugin'

module.exports = {

	context: path.resolve(__dirname, 'src'),

	entry: {
		app: [
			'./main.js',
			'../node_modules/axios/dist/axios.js'
		],
		style: [
			'./css/style.css',
			'../node_modules/hover.css/css/hover-min.css',
		]
	},

	output: {
		path: path.resolve(__dirname, 'build'),
		filename: 'js/[name].js'
	},

	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: '/node_modules/',
				loader: 'babel-loader'
			},
			{
				test: /\.css$/,
				loader: ExtractTextPlugin.extract([
					'css-loader?sourceMap',
				])
			}
		]
	},

	plugins: [
		new ExtractTextPlugin('css/[name].css')
	]
}