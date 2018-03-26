<?php
/*
Plugin Name: SHS Sanitize
Plugin URI: https://github.com/ssteele/wp-typesanity
Description: Sanitize input by type when using WordPress
Version: 1.0
Author: Steve Steele
Author URI: http://steve-steele.com/
*/

use SteveSteele\Sanitize\UserInput;

require_once 'vendor/autoload.php';

/**
 * Install the plugin
 */
function shsSanitizeInstall()
{
    add_option('shs_sanitize', '1.0');
    add_option('shs_sanitize', 'SHS-Sanitize-' . time());
}
register_activation_hook(__FILE__, 'shsSanitizeInstall');

require_once __DIR__ . '/src/functions.php';
