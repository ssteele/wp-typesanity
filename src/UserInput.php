<?php

namespace SteveSteele\TypeSanity;

class UserInput
{
    /**
     * Sanitize user input: run through wp_kses at a minimum
     * @param  mixed        $input    Untrusted user input
     * @param  string|array $type     Type specification
     * @param  array        $allow    Allowed protocols: passed to wp_kses
     * @return string                 Sanitized output
     */
    public function sanitize($input, $type = null, $allow = [])
    {
        if (! is_null($type) && empty($allow)) {
            if (is_array($input) && is_array($type) && count($input) == count($type)) {
                // Sanitize array elements explicitly specifying a type for each
                $output = array();
                $i = 0;

                foreach ($input as $key => $val) {
                    $val = wp_kses($val, $allow);
                    $output[$key] = $this->sanitizeByType($val, $type[$i]);
                    $i++;
                }
            } elseif (is_array($input) && ! is_array($type)) {
                // Sanitize homogeneous (w/ respect to type) array
                $output = array();
                foreach ($input as $key => $val) {
                    $val = wp_kses($val, $allow);
                    $output[$key] = $this->sanitizeByType($val, $type);
                }
            } else {
                // Sanitize variables
                $input = wp_kses($input, $allow);
                $output = $this->sanitizeByType($input, $type);
            }
        } else {
            // Run through wp_kses only
            $output = wp_kses($input, $allow);
        }

        return $output;
    }


    /**
     * More robust (type specified) user input sanitation
     * @param  mixed $input          Untrusted user input
     * @param  string|array $type    Type specification
     * @return string                Sanitized output (or empty string)
     */
    private function sanitizeByType($input, $type)
    {
        $output = $input;

        switch ($type) {
            case 'string':
            case 'str':
            case 's':
                $output = filter_var($output, FILTER_SANITIZE_STRING);
                break;

            case 'integer':
            case 'int':
            case 'i':
                $output = intval($output);
                $output = filter_var($output, FILTER_SANITIZE_NUMBER_INT);

                // pass an empty string if output reports '0' unless input is zeroish
                if (preg_match('/^0/', $input)) {
                    $output = (string) round($output);
                } elseif ('0' === $output) {
                    $output = '';
                }
                break;

            case 'float':
            case 'f':
                $output = filter_var($output, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                break;

            default:
                // pass
        }

        return $output;
    }
}
