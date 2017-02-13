##WP Sanitize

*A WordPress plugin that sanitizes user input*

###Description

Sanitize user input by calling a simple function:

    $_POST = [
        'name' => 'Steve Steele',
        'id'   => 1,
        'gpa'  => 3.9,
    ];
    $name = shsSanitize($_POST['name']);

Pass in optional parameter [s]tring, [i]nteger, or [f]loat to ensure proper data type:

    $name = shsSanitize($_POST['name'], 's');
    $id = shsSanitize($_POST['id'], 'i');
    $gpa = shsSanitize($_POST['gpa'], 'f');

Perhaps you'd like to inject the dependency instead of calling a global function:

    function someCallable($input, $sanitizer)
    {
        $name = $sanitizer::sanitize($input, 's');
        return $name;
    }
    $name = someCallable($_POST['name'], UserInput::class);
