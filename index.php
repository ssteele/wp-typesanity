<?php
/*
Plugin Name: SHS Sanitize
Plugin URI: https://github.com/ssteele/wp-sanitize
Description: Sanitize user input for WordPress sites
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


/*
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    WORDPRESS FUNCTIONALITY
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
*/


/**
 * Sanitize user input (wrapper)
 * @param  mixed        $input    Untrusted user input
 * @param  string|array $type     Type specification
 * @param  array        $allow    Allowed protocols: passed to wp_kses
 * @return string                 Sanitized output
 */
function shsSanitize($input, $type = null, $allow = [])
{
    return UserInput::sanitize($input, $type, $allow);
}
