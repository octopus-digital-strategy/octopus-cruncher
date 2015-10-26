<?php
/**
 * Developer: Page Carbajal (https://github.com/Page-Carbajal)
 * Date: October 21 2015, 1:42 PM
 */

namespace EnhancePerformance;


use WPExpress\Abstractions\SettingsPage;


class OptionsPage extends SettingsPage
{

    private $bundlePath;

    public function __construct()
    {
        // Invoke the paren constructor
        parent::__construct( 'Performance Enhancements', 'manage_options' );

        // plugin_basename(__FILE__)
        $this->setCustomTemplatePath( plugin_dir_path(__FILE__) . "../resources/templates" );

        $description = __('This plugin requires node installed on the server.', 'octopus');

        $this->registerPage()->setPageDescription($description)->registerCustomFields();

        // Customize context
        add_filter( 'wpExpressSettingsPageContext', array($this, 'customizeContext') );

        add_action( 'wpExpressSettingsPageAfterSave', array($this, 'generateCSSBundle' ), 2 );
    }


    private function registerCustomFields()
    {
        // Custom Bundle Name
        $this->registerMetaField(
            'CSSBundle',
            __( 'Bundle Path', 'octopus' ),
            'text', 'node-settings',
            array(
                'readonly' => true,
                'style' => 'min-width: 600px;',
            ) );

        // Persist all the registerd styles
        if(!is_admin()){
            add_action('wp_head', array($this, 'persistRegisteredStyles'), 99);
            // Enqueue CSS Bundle
            if( $this->getCSSBundlePath() != false ){
                add_action( 'wp_head', array($this, 'enqueueCSSBundle'), 1 );
            }
        }

//        $WPStyles = new \WP_Styles();
//

        $styles = get_option("{$this->fieldPrefix}registeredStyles");
        $this->registerMetaFieldsArray('styles', $styles, 'checkbox', 'styles');

        return $this;
    }

    public function persistRegisteredStyles()
    {
        $propertyName = "{$this->fieldPrefix}registeredStyles";
        $styles = get_option($propertyName);
        if( empty($styles) ){
            global $wp_styles;
            $styles = array();
            foreach( $wp_styles->registered as $key => $dependency ){
                if( is_string( $dependency->src ) ){
                    $styles[$key] = $key;
                }
            }
            update_option( $propertyName, $styles );
        }
    }

    public function getRegisteredStyles()
    {
        return get_option( "{$this->fieldPrefix}registeredStyles", array() );
    }

    public function getCSSBundlePath()
    {
        $bundlePath = get_option( "{$this->fieldPrefix}CSSBundle", false );;
        return $bundlePath;
    }

    public function enqueueCSSBundle()
    {
        global $wp_styles;

        $styles = $this->getValue('styles');
        foreach( $styles as $style ){
            wp_dequeue_style( $style );
        }

        $bundleURL = get_option( "{$this->fieldPrefix}CSSBundle" );

        wp_enqueue_style( 'octopus-cruncher-css', $bundleURL );
    }

    public function customizeContext($context)
    {
        $context['styles'] = array();

        foreach( $context['fields'] as $index => $field ){

            if( isset( $field->properties['group'] ) && $field->properties['group'] == 'styles' ){
                unset($context['fields'][$index]);
                $context['styles'][] = $field;
            }
        }

        if(!empty( $this->getValue('styles') )){
            $context['styles-bundle'] = true;
        }

        return $context;
    }

    private function saveFile($fileName, $fileContents)
    {
        $bytes = false;
        $uploadsPath = wp_upload_dir();
        $filePath = trailingslashit($uploadsPath['basedir']) . "cruncher/$fileName.min.css";

        if( wp_mkdir_p( trailingslashit($uploadsPath['basedir']).'cruncher' ) ){
            if( $bytes = file_put_contents( $filePath, $fileContents ) !== false ){
                $bundleURL = trailingslashit( content_url( 'uploads/cruncher' ) ) . "{$fileName}.min.css";
                update_option("{$this->fieldPrefix}CSSBundle", $bundleURL);
            }

        }
        return ( $bytes !== false );
    }

    public function generateCSSBundle($currentOptions, $postObject)
    {
        global $wp_styles;

        // Destroy the bundle
        delete_option( "{$this->fieldPrefix}CSSBundle" );
        $cssBundle = '';

        $styles = $currentOptions->getValue('styles');

        foreach( $wp_styles->registered as $key => $dependency ){
            $filePath = $wp_styles->base_url; //untrailingslashit( get_home_path() );
            if( in_array( $key, $styles ) ){
                if( is_string( $dependency->src ) ){
                    if( strpos($dependency->src, $wp_styles->base_url) !== false ){
                        $start = strlen($wp_styles->base_url);
                        $filePath .= substr($dependency->src, $start, strlen($dependency->src) - $start );
                    } else {
                        $filePath .= $dependency->src;
                    }
                    if( file_exists( $filePath ) ){
                        $cssBundle .= \CssMin::minify( file_get_contents( $filePath ) );
                    }
                }
            }
        }

        if( !empty($cssBundle) ){
            $this->saveFile('cruncher-css-bundle', $cssBundle);
        }

    }

}