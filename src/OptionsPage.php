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

        // TODO: composer require natxet/cssmin - https://code.google.com/p/cssmin/
        // TODO: Persist the bundle
        // TODO: Add button generateBundle

    }


    private function registerCustomFields()
    {
        // Custom Bundle Name
        $this->registerMetaField(
            'nodePath',
            __( 'Bundle Name', 'octopus' ),
            'text', 'node-settings',
            array(
                'placeholder' => 'css-bundle.min.css',
            ) );


        // Persist all the registerd styles
        // TODO: Run only once or on demand
        add_action('wp_head', array($this, 'persistRegisteredStyles'), 99);
        // Enqueue CSS Bundle
        if( $this->getCSSBundlePath() != false ){
            add_action( 'wp_head', array($this, 'enqueueCSSBundle'), 1 );
        }

        $WPStyles = new \WP_Styles();

        $registeredStyles = get_option( "{$this->fieldPrefix}registeredStyles", array() );

        $this->registerMetaFieldsArray('styles', $registeredStyles, 'checkbox', 'styles');

//        foreach( $styles as $key => $style ){
////            wp_dequeue_style( $key );
//            $this->addMetaField( "styles", $key, 'checkbox', 'styles', array('value' => $key, 'array' => true) );
//        }


        return $this;
    }

    public function persistRegisteredStyles()
    {
        global $wp_styles;
        $styles = array();
        foreach( $wp_styles->registered as $key => $dependency ){
            $styles[$key] = $key;
        }
        update_option( "{$this->fieldPrefix}registeredStyles", $styles );

    }

    public function getRegisteredStyles()
    {
        return get_option( "{$this->fieldPrefix}registeredStyles", array() );
    }

    public function getCSSBundlePath()
    {
        $bundlePath = false;
        // TODO: get path to Bundle
        return $bundlePath;
    }

    public function enqueueCSSBundle()
    {
        global $wp_styles;

        // TODO: getCompressedStyles and dequeue them
        // TODO: enqueue CSS Bundle

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

        return $context;
    }

}