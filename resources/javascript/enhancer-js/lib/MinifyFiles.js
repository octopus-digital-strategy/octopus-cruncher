import Uglify from 'uglify-js';
import exec from 'child_process';

class MinifyFiles
{
    //constructor(files)
    //{
    //    this.minify(files);
    //}

    minify(files, bundle)
    {
        var bundle = '';
        for(var file of files){
            //console.log(file);
            bundle = bundle + Uglify.minify(file).code;
        }
        return bundle;
    }
}

export default new MinifyFiles();