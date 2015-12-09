#Octopus Cruncher

A WordPress plugin to compress all CSS into a single bundle.

##How to start?

1. Install and activate the plugin
2. Run composer update commands if necessary
3. Visit your homepage
4. Open the option Settings/Octopus Cruncher
    - Identify the running this styles on your browser [JS Fiddle](http://jsfiddle.net/pagecarbajal/tm00avv2/)
5. Select the styles to be crunched


##Change Log

###Version 0.3

* Moved methods from OptionsPage to StylesManager
* Added StylesManager class
* Implemented Editable Labels
* Added JQuery UI Styles
* Implemented octopus Cruncher Admin Styles
* Implemented Sortable functionality for styles
* Added jQuery UI as a dependency
* Added the new Welcome Window
* Registered boostrap styles and scripts
* Added bootstrap to the bower_components directory

###Version 0.2

* Added the PROJECT.md file with the User Stories for this plugin
* Moved the wpexpress dependency from repository to package
* Added composer.lock to .gitignore
* Removed composer.lock from repo
* Fixed composer error

###Version 0.1

* Commented the register styles 
* Added mustache to the repo
* Changed the Namespace
* Reconfigured Composer Autoload
* Implemented Style cruncher
* Added CSSMinComposer required CSSMin
* Implemented the BareBones plugin