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
//        add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueStyles' ) );
//        add_filter( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueScripts' ) );
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
        if( is_admin() ){
            if( $stylePath = self::getResourceURL( 'admin-styles.css', 'css' ) ){
                wp_enqueue_style( 'your-plugin-name-admin-styles', $stylePath );
            }
        }

        if( $stylePath = self::getResourceURL( 'front-end.css', 'css' ) ){
            wp_enqueue_style( 'your-plugin-name-front-end-styles', $stylePath );
        }
    }

    public static function enqueueScripts()
    {
        if( is_admin() ){
            if( $scriptPath = self::getResourceURL( 'admin-script.js', 'javascript' ) ){
                wp_enqueue_script( 'your-plugin-name-admin-script', $scriptPath, array( 'jquery' ) );
            }
        }

        if( $scriptPath = self::getResourceURL( 'front-end.js', 'javascript' ) ){
            wp_enqueue_script( 'your-plugin-name-front-end-script', $scriptPath, array( 'jquery' ) );
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