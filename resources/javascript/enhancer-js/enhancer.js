//import Demo from './lib/UglifyHandler.js';
require('babel/register'); // tranform with babel
var Demo = require('./lib/UglifyHandler.js');

console.log( 'This is the CLI' );
var minified = Demo.minify('./dist/UglifyHandler.js');
console.log('Minified: ', minified);