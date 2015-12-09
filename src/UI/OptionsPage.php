<?php
/**
 * Developer: Page Carbajal (https://github.com/Page-Carbajal)
 * Date: October 21 2015, 1:42 PM
 */

namespace OctopusCruncher\UI;


use OctopusCruncher\StylesManager;
use WPExpress\Abstractions\SettingsPage;


class OptionsPage extends SettingsPage
{

    private $bundlePath;

    public function __construct()
    {
        // Invoke the paren constructor
        parent::__construct( 'Octopus Cruncher', 'manage_options' );
        // plugin_basename(__FILE__)
        $this->setCustomTemplatePath( plugin_dir_path(__FILE__) . "../../resources/templates" );
        $description = __('CSS Cruncher', 'octopus');
        $this->registerPage()->setPageDescription($description)->registerCustomFields();

        new StylesManager($this);

        add_filter( 'wpExpressSettingsPageContext', array($this, 'customizeContext') );
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


        $styles = get_option("{$this->fieldPrefix}registeredStyles");
        $this->registerMetaFieldsArray('styles', $styles, 'checkbox', 'styles');

        return $this;
    }

    public function customizeContext($context)
    {
        $context['styles'] = array();

        foreach( $context['fields'] as $index => $field ){

            if( isset( $field->properties['group'] ) && $field->properties['group'] == 'styles' ){
                unset($context['fields'][$index]);
//                if( (strpos( $field->properties['value'], 'wp_' ) === false) && (strpos( $field->properties['value'], 'wp-' ) === false) ){
                    $context['styles'][] = $field;
//                }
            }
        }

        if( count( $context['styles'] ) == 0 ){
            $context['welcome'] = array(
                'title' => __( 'Almost Ready!', 'octopus' ),
                'message' => __( '<p>Please click the button below. This will open your homepage to load the styles available on WordPress to the list.</p>', 'octopus' ),
                'homeURL' => home_url(),
                'homeLink' => __( 'Open Homepage', 'octopus' ),
            );
        }

        if(!empty( $this->getValue('styles') )){
            $context['styles-bundle'] = true;
        }

        return $context;
    }

    public function getFieldPrefix()
    {
        return $this->fieldPrefix;
    }

}