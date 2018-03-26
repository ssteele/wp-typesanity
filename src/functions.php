<?php

use SteveSteele\Sanitize\UserInput;

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
    $userInput = new UserInput();
    return $userInput->sanitize($input, $type, $allow);
}
