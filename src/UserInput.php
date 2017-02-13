<?php

namespace SteveSteele\Sanitize;

class UserInput
{

    /**
     * Sanitize user input: run through wp_kses at a minimum
     * @param  mixed        $input    Untrusted user input
     * @param  string|array $type     Type specification
     * @param  array        $allow    Allowed protocols: passed to wp_kses
     * @return string                 Sanitized output
     */
    public static function sanitize($input, $type = null, $allow = [])
    {
        $input = wp_kses($input, $allow);

        if (! is_null($type) && empty($allow)) {
            if (is_array($input) && is_array($type) && count($input) == count($type)) {
                // Sanitize array elements explicitly specifying a type for each
                $output = array();
                $i = 0;

                foreach ($input as $key => $val) {
                    $output[$key] = self::sanitizeByType($val, $type[$i]);
                    $i++;
                }
            } elseif (is_array($input) && count($type) == 1) {
                // Sanitize homogeneous (w/ respect to type) array
                $output = array();
                foreach ($input as $key => $val) {
                    $output[$key] = self::sanitizeByType($val, $type);
                }
            } else {
                // Sanitize variables
                $output = self::sanitizeByType($input, $type);
            }
        } else {
            // Run through wp_kses only
            $output = $input;
        }

        return $output;
    }


    /**
     * More robust (type specified) user input sanitation
     * @param  mixed $input          Untrusted user input
     * @param  string|array $type    Type specification
     * @return string                Sanitized output (or empty string)
     */
    private static function sanitizeByType($input, $type)
    {
        $output = $input;

        switch ($type) {
            case 's':
                $output = filter_var($output, FILTER_SANITIZE_STRING);
                break;

            case 'i':
                $output = intval($output);
                $output = filter_var($output, FILTER_SANITIZE_NUMBER_INT);
                // only pass back '0' if input was 0
                $output = ('0' !== $output || 0 === $input) ? $output : '';
                break;

            case 'f':
                $output = filter_var($output, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                break;

            default:
                // pass
        }

        return $output;
    }
}
