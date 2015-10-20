<?php
/**
 * Plugin name: Enhance Performance
 * Plugin URI:
 * Description: A plugin under development
 * Version: 0.1
 * Author: Page-Carbajal
 * Author URI: http://pagecarbajal.com
 */

// No direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Composer implementation
require_once('vendor/autoload.php');

// Instance the Setup
new \EnhancePerformance\Setup();