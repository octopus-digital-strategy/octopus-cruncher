require('babel/register'); // tranform with babel

var Files = require('./lib/MinifyFiles.js');

console.log( 'This is the CLI' );

var path = '/Users/jebediahpage/Sites/iam_clientes/octopus/www/wp-content/';

var files =[
    path + 'themes/untitled/js/bootstrap.min.js',
    path + 'themes/untitled/js/instafeed.min.js',
    path + 'themes/untitled-child/js/zn_script.js',
    path + 'themes/untitled-child/zn_script_child.js'
];

console.log('Bundle: ', Files.minify(files) );

