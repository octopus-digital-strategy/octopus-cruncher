<?php
/**
 * Plugin name: Bare Bones WordPress Plugin
 * Plugin URI: https://github.com/octopus-digital-strategy/barebones-wp-plugin
 * Description: The most essential components for a WordPress plugin
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