## WP Typesanity

*A WordPress plugin that sanitizes user input by unit type*

### Description

Sanitize user input by calling a simple function:

    $_POST = [
        'name' => 'Steve Steele',
        'id'   => 1,
        'gpa'  => 3.9,
    ];
    $name = shsSanitize($_POST['name']);            // sanitize name

Pass in optional parameter [s]tring, [i]nteger, or [f]loat to ensure proper data type:

    $name = shsSanitize($_POST['name'], 's');       // sanitize name as string
    $id = shsSanitize($_POST['id'], 'i');           // sanitize id as integer
    $gpa = shsSanitize($_POST['gpa'], 'f');         // sanitize gpa as float

Bulk sanitize an array of user input:

    $post = shsSanitize($_POST);                    // sanitize all post elements
    $post = shsSanitize($_POST, 'i');               // sanitize all post elements as integer
    $post = shsSanitize($_POST, ['s', 'i', 'f']);   // sanitize all post elements against respective types

Perhaps you'd like to inject the dependency instead of calling a global function:

    function myFunction($input, UserInput $userInput)
    {
        return = $userInput->sanitize($input, 's'); // all options above are available
    }
    $name = myFunction($_POST['name'], new UserInput());
