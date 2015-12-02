<?php
/**
 * Developer: Page Carbajal (https://github.com/Page-Carbajal)
 * Date: October 20 2015
 */


namespace OctopusCruncher;


use OctopusCruncher\OptionsPage;


class Setup
{
    public function __construct()
    {
        $this->registerStylesAndScripts()->registerTextDomain();
        new OptionsPage();
    }

    public function registerStylesAndScripts()
    {
        // Load scripts for the front end
        if( is_admin() ){
            add_filter( 'admin_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ) );
            add_filter( 'admin_enqueue_scripts', array( __CLASS__, 'enqueueStyles' ) );
        }
        return $this;
    }

    public function registerTextDomain()
    {
        add_filter('plugins_loaded', array($this, 'registerPluginTextdomain') );
        return $this;
    }

    public function registerPluginTextDomain()
    {
        if( $path = self::getResourceURL('', 'languages') ){
            load_plugin_textdomain( 'my-plugin', false, $path );
        }
    }

    // Static methods
    public static function enqueueStyles()
    {
        // jQuery UI
        if( $jQueryUI = self::getResourceURL( 'jquery-ui.css', 'bower_components/jquery-ui/themes/vader' ) ){
            wp_enqueue_style( 'jquery-ui-css', $jQueryUI );
        }

        // Cruncher Admin
        if( $adminStyles = self::getResourceURL( 'cruncher-admin.css' ) ){
            wp_enqueue_style( 'octopus-cruncher-css', $adminStyles );
        }

        // Bootstrap
        if( $bootstrap = self::getResourceURL( 'bootstrap.min.css', 'bower_components/bootstrap/dist/css' ) ){
            wp_enqueue_style( 'bootstrap-css', $bootstrap );
        }
        // Bootstrap Theme
        if( $bootstrapTheme = self::getResourceURL( 'bootstrap-theme.min.css', 'bower_components/bootstrap/dist/css' ) ){
            wp_enqueue_style( 'bootstrap-theme-css', $bootstrapTheme );
        }
    }

    public static function enqueueScripts()
    {
        // Bootstrap
        if( $bootstrap = self::getResourceURL( 'bootstrap.min.js', 'bower_components/bootstrap/dist/js' ) ){
            wp_enqueue_script( 'bootstrap-js', $bootstrap, array( 'jquery', 'jquery-ui' ) );
        }
    }

    public static function getResourceDirectory($fileName, $subDirectory = 'css')
    {
        $filePath = plugin_dir_path(__FILE__) . "../resources/{$subDirectory}/{$fileName}";
        if( file_exists( $filePath ) ){
            return $filePath;
        }
        return false;
    }

    public static function getResourceURL($fileName, $subDirectory = 'css')
    {
        if( self::getResourceDirectory( $fileName, $subDirectory ) !== false ){
            return plugin_dir_url(__FILE__) . "../resources/{$subDirectory}/{$fileName}";
        }

        return false;
    }

}