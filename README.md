## WP Typesanity

*A WordPress plugin that sanitizes user input by unit type*

### Description

WP Typesanity delivers a consistent experience when dealing with the various base PHP unit types in the WordPress environment. All input is stringified and filtered through `wp_kses` to remove markup and "evil scripts". You can pass a second parameter to `sanitize` to specify an expected unit type. Strings, integers, and floats are verified and expected data is kept. Unexpected data is set to an empty string. Now you are free to develop as fast as you like knowing the unit types you're dealing with are what you expect. See table below for a breakdown of unit type expectations:

| input   | string   | integer | float   |
| ------- | -------- | ------- | ------- |
| 'foo'   | 'foo'    | ''      | ''      |
| '1'     | '1'      | '1'     | '1'     |
| '0'     | '0'      | '0'     | '0'     |
| '1.2'   | '1.2'    | '1'     | '1.2'   |
| '0.0'   | '0.0'    | '0'     | '0.0'   |
| 'true'  | 'true'   | ''      | ''      |
| 'false' | 'false'  | ''      | ''      |
| 1       | '1'      | '1'     | '1'     |
| 0       | '0'      | '0'     | '0'     |
| 1.2     | '1.2'    | '1'     | '1.2'   |
| 0.0     | '0.0'    | '0'     | '0.0'   |
| true    | 'true'   | ''      | ''      |
| false   | 'false'  | ''      | ''      |

### Setup

Navigate to your plugin via the terminal and issue:

`composer require ssteele/wp-typesanity`

### Documentation

Sanitize user input:

    $translator = new UserInput();
    $_POST = [
        'name' => 'Steve Steele',
        'id'   => 1,
        'gpa'  => 3.9,
    ];
    $name = $translator->sanitize($_POST['name']);          // sanitize name

Pass in optional parameter [s]tring, [i]nteger, or [f]loat to ensure proper data type:

    $name = $translator->sanitize($_POST['name'], 's');     // sanitize name as string
    $id = $translator->sanitize($_POST['id'], 'i');         // sanitize id as integer
    $gpa = $translator->sanitize($_POST['gpa'], 'f');       // sanitize gpa as float

Bulk sanitize an array of user input:

    $post = $translator->sanitize($_POST);                  // sanitize all post elements
    $post = $translator->sanitize($_POST, 'i');             // sanitize all post elements as integer
    $post = $translator->sanitize($_POST, ['s', 'i', 'f']); // sanitize all post elements (of known order) against respective types
