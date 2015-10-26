<?php
/**
 * Plugin name: Octopus Crucher
 * Plugin URI:
 * Description: A plugin to Crunch CSS
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
new \OctopusCruncher\Setup();