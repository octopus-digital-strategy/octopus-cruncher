<?php
/**
 * Developer: Page Carbajal (https://github.com/Page-Carbajal)
 * Date: Octubre 21 2015, 1:42 PM
 */

namespace EnhancePerformance;


use WPExpress\Abstractions\SettingsPage;
use WPExpress\UI\HTML\Tags;


class OptionsPage extends SettingsPage
{

    public function __construct()
    {
        // Invoke the paren constructor
        parent::__construct( 'Performance Enhancements', 'manage_options' );

        $this->getNodeInformation();
        // plugin_basename(__FILE__)
        $this->setCustomTemplatePath( plugin_dir_path(__FILE__) . "../resources/templates" );

        $description = __('This plugin requires node installed on the server.', 'octopus');

        $this->registerPage()->setPageDescription($description)->registerCustomFields();

        // Customize context
        add_filter( 'wpExpressSettingsPageContext', array($this, 'customizeContext') );
    }


    private function getNodeInformation()
    {
        $this->nodePath = exec('node -v');

    }


    private function registerCustomFields()
    {
        // Custom Bundle Name
        $this->addMetaField(
            'nodePath',
            __( 'Bundle Name', 'octopus' ),
            'text', 'node-settings',
            array(
                'disabled' => true,
                'value' => 'css-bundle.min.css',
            ) );


        // Persist all the registerd styles
        // TODO: Run only once or on demand
        add_action('wp_head', array($this, 'persistRegisteredStyles'), 99);
        // Enqueue CSS Bundle
        if( $this->getCSSBundlePath() != false ){
            add_action( 'wp_head', array($this, 'enqueueCSSBundle'), 1 );
        }

        $WPStyles = new \WP_Styles();

        $styles = $this->getRegisteredStyles();

        foreach( $styles as $key => $style ){
            wp_dequeue_style( $key );
            $this->addMetaField( $key, "Style {$key}", 'checkbox', 'styles' );
        }


        return $this;
    }

    public function persistRegisteredStyles()
    {
        global $wp_styles;
        update_option( "{$this->settingsPrefix}registeredStyles", $wp_styles->registered );
    }

    public function getRegisteredStyles()
    {
        return get_option( "{$this->settingsPrefix}registeredStyles", array() );
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