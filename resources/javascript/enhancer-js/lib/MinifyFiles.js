import Uglify from 'uglify-js';
import exec from 'child_process';
import FS from 'fs';

class MinifyFiles
{

    minify(files, destination)
    {
        var bundle = '';
        for(var file of files){
            //console.log(file);
            //TODO: Notify file is being compressed
            bundle = bundle + Uglify.minify(file).code;
            //TODO: Notify file has been compressed
        }

        FS.writeFile(destination, bundle, function(err){
            if(err){
                //TODO: notify error!
            }
            // TODO: notify Done!
        });
        console.log('Done Baby!');
        //return bundle;
    }

}

export default new MinifyFiles();