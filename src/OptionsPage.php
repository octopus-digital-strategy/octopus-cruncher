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
        $this->registerPage();

        // Add fields
        $this->addOptionField( Tags::textField('test', array( 'id' => 'test', 'class' => 'form-control' ) )  )
            ->addOptionField(  Tags::textField('test', array( 'id' => 'test', 'class' => 'form-control' ) )  );

    }

}