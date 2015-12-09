<?php


namespace OctopusCruncher;


use OctopusCruncher\UI\OptionsPage;

class StylesManager
{

    private $bundlePath;
    private $options;

    public function __construct( $options = null )
    {
        if( $options instanceof OptionsPage ){
            $this->options = $options;
        } else {
            $this->options = new OptionsPage();
        }

        // Persist all the registerd styles
        if(!is_admin()){
            add_action('wp_head', array($this, 'persistRegisteredStyles'), 99);
            // Enqueue CSS Bundle
            if( $this->getCSSBundlePath() != false ){
                add_action( 'wp_head', array($this, 'enqueueCSSBundle'), 1 );
            }
        }

        add_action( 'wpExpressSettingsPageAfterSave', array(&$this, 'generateCSSBundle' ), 2 );

    }


    public function persistRegisteredStyles()
    {
        global $wp_styles;

        $fieldPrefix = $this->options->getFieldPrefix();

        $propertyName = "{$fieldPrefix}registeredStyles";
        $styles = get_option($propertyName);

        if( empty($styles) ){
            global $wp_styles;
            $styles = array();
            foreach( $wp_styles->registered as $key => $dependency ){
                $source = ABSPATH;//get_home_path();
                if( is_string( $dependency->src ) ){
                    if( strpos($dependency->src, $wp_styles->base_url) !== false ){
                        $start = strlen($wp_styles->base_url);
                        $source .= substr($dependency->src, $start, strlen($dependency->src) - $start );
                    } else {
                        $source .= $dependency->src;
                    }
                    if( file_exists( $source ) ){
                        $styles[$key] = $source;
                    }
                }
            }
            update_option( $propertyName, $styles );
        }
    }


    public function getRegisteredStyles()
    {
        $fieldPrefix = $this->options->getFieldPrefix();
        return get_option( "{$fieldPrefix}registeredStyles", array() );
    }

    public function getCSSBundlePath()
    {
        $fieldPrefix = $this->options->getFieldPrefix();
        $bundlePath = get_option( "{$fieldPrefix}CSSBundle", false );;
        return $bundlePath;
    }


    public function enqueueCSSBundle()
    {
        global $wp_styles;
        $fieldPrefix = $this->options->getFieldPrefix();

        $styles = $this->options->getValue('styles');
        foreach( $styles as $style ){
            wp_dequeue_style( $style );
        }

        $bundleURL = get_option( "{$fieldPrefix}CSSBundle" );

        wp_enqueue_style( 'octopus-cruncher-bundle-css', $bundleURL );
    }


    private function saveFile($fileName, $fileContents)
    {
        $bytes = false;
        $fieldPrefix = $this->options->getFieldPrefix();
        $uploadsPath = wp_upload_dir();
        $filePath = trailingslashit($uploadsPath['basedir']) . "cruncher/$fileName.min.css";

        if( wp_mkdir_p( trailingslashit($uploadsPath['basedir']).'cruncher' ) ){
            if( $bytes = file_put_contents( $filePath, $fileContents ) !== false ){
                $bundleURL = trailingslashit( content_url( 'uploads/cruncher' ) ) . "{$fileName}.min.css";
                update_option("{$fieldPrefix}CSSBundle", $bundleURL);
            }

        }
        return ( $bytes !== false );
    }

    public function generateCSSBundle($currentOptions, $postObject)
    {
        global $wp_styles;

        $fieldPrefix = $this->options->getFieldPrefix();
        // Destroy the bundle
        delete_option( "{$fieldPrefix}CSSBundle" );
        $cssBundle = '';

        $registeredStyles = get_option("{$fieldPrefix}registeredStyles");
        $selectedStyles = $currentOptions->getValue('styles');
        foreach( $registeredStyles as $key => $source ){
            if( in_array( $key, $selectedStyles ) ){
                $cssBundle .= \CssMin::minify( file_get_contents($source) );
            }
        }

        if( !empty($cssBundle) ){
            $this->saveFile('cruncher-css-bundle', $cssBundle);
        }

    }

}