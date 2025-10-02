<?php

// Account Creation 
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$password_check = isset($_POST['password-check']) ? trim($_POST['password-check']) : '';

// Qualifications
$experience = isset($_POST['experience']) ? trim($_POST['experience']) : '';
$region = isset($_POST['region']) ? $_POST['region'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';
$training  = isset($_POST['training']) ? $_POST['training'] : []; // These are checkboxes, so this will be an array.
$loyalty = isset($_POST['loyalty']) ? $_POST['loyalty'] : 5;
$referral = isset($_POST['referral']) ? $_POST['referral'] : '';

// Long Answer Question
$evil_plan = isset($_POST['evil-plan']) ? trim($_POST['evil-plan']) : '';

// We'll initialise our messages now, too. We'll have a unique message for each input.
$message_name = '';
$message_email = '';
$message_phone = '';
$message_password = '';
$message_password_check = '';
$message_dob = '';

$message_experience = '';
$message_region = '';
$message_department = '';
$message_training = '';
$message_loyalty = '';
$message_referral = '';

$message_evil_plan = '';

// Test BOOL: this boolean will keep track od our validaiton process. It will initially be FALSE; however, when the user submits the form, if they pass validation, it will flip to TRUE and the user will be redirected to the thank-you page.
$form_good = isset($_POST['submit']) ? TRUE : FALSE;

// This is the start of our test 'gauntlet', where we perform multiple tests on each piece of data that the user gave us. 
if (isset($_POST['submit'])) {

/*
    VALIDATION FOR FULL NAME

    Generally, we should always start validation with a presence check (i.e., did the user fill our this field?).

    For a full name, we'll also make sure that the user gave us letters and that there's a space somewhere in there.
*/

if (is_blank($name)) {
    $message_name = "<p class=\"text-warning\">Please enter your name.</p>";
} elseif (!is_letters($name)) {
    $message_name = "<p class=\"text-warning\">Your name can only contain letters and spaces.</p>";
} elseif (no_spaces($name)) {
    $message_name = "<p class=\"text-warning\">Please enter both your first and last names.</p>";
} elseif ($name == FALSE) {
    $message_name = "<p class=\"text-warning\">Please enter a valid name.</p>";
}

// If there is an error message for the name, then we know it's failed at least one of the tests. We'll flip our test boolean here to prevent the user from submitting and continuing on to the thank-you page.
if ($message_name != "") {
    $form_good = FALSE;
}

/*
    VALIDATION FOR EMAIL

    filter_var() validates and sanitises our data based upon built-in PHP lists. Note that some of these lists are older and deprecated, so you may get a warning about it.
*/

if (is_blank($email)) {
    $message_email = "<p class=\"text-warning\">Please enter your email address.</p>";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message_email = "<p class=\"text-warning\">Please enter a valid email address.</p>";
}

if ($message_email != "") {
    $form_good = FALSE;
}

/*
    PHONE NUMBERS
*/

// This starts us off by stripping out any potential syntax.
$phone = valid_phone_format($phone);

if (is_blank($phone)) {
    $message_phone = "<p class=\"text-warning\">Please enter your phone number.</p>";
} elseif (!filter_var($phone, FiLTER_VALIDATE_INT)) {
    $message_phone = "<p class=\"text-warning\">Please enter a valid phone number, using numbers only.</p>";
} elseif (!is_numeric($phone)) {
    $message_phone = "<p class=\"text-warning\">Please enter a valid phone number, using numbers only.</p>";
} elseif (!has_length_exactly($phone, 10)) {
    $message_phone = "<p class=\"text-warning\">Please enter a 10-digit phone number.</p>";
}

if ($message_phone != "") {
    $form_good = FALSE;
}

/*
    DATES (DATE OF BIRTH)

    We can check to see if a provided values is a date by creating a DateTime object from it. 

    We won't use strtotime() here because it silently fixes invalid dates instead of rejecting them. 
*/

if (!empty($dob)) {
    // Here, we'll attempt to create a DateTime object from the user input.
    $dob_object = DateTime::createFromFormat('Y-m-d', $dob);

    // We'll check to see if we were able to do that and that it follows our provided format.
    if ($dob_object && $dob_object->format('Y-m-d') === $dob) {

        // If the date is valid, we'll check the user's age by comparing today's date and time to their birthday.
        $today = new DateTime();
        $minimum_age = $today->modify('-18 years'); // this subtracts 18 years from today's date

        if ($dob_object > $minimum_age) {
            $message_dob = "<p class=\"text-warning\">You must be at least 18 years old to apply.</p>";
        }

    } else { // if the $dob_object wasn't created or isn't the right format
        $message_dob = "<p class=\"text-warning\">Please enter a valid date.</p>";    
    }
} else { // if $dob is empty
    $message_dob = "<p class=\"text-warning\">Your date of birth is required.</p>";
}

if ($message_dob != "") {
    $form_good = FALSE;
}

/*
    PASSWORDS

    If we tell the user that we want certain things within a password, we should compare their input to a suitable regular expression. 

    We could check this all at once with a monstrously long RegEx, but if we do it piece-by-piece, we can give the user more explicit feedback on what exactly they're missing. 
*/

if (is_blank($password)) {
    $message_password = "<p class=\"text-warning\">Please provide a password.</p>";
} elseif (strlen($password) < 8) {
    $message_password = "<p class=\"text-warning\">Your password must be at least 8 characters long.</p>";
} elseif (!preg_match('/[A-Z]/', $password)) {
    $message_password = "<p class=\"text-warning\">Your password must have at least one uppercase letter.</p>";
} elseif (!preg_match('/[a-z]/', $password)) {
    $message_password = "<p class=\"text-warning\">Your password must have at least one lowercase letter.</p>";
} elseif (!preg_match('/[0-9]/', $password)) {
    $message_password = "<p class=\"text-warning\">Your password must have at least one number.</p>";
} elseif (!preg_match('/[\W_]/', $password)) {
    $message_password = "<p class=\"text-warning\">Your password must include at least one of the following special characters: !@#$%^&*.</p>";
}

if ($message_password != "") {
    $form_good = FALSE;
}

/*
    PASSWORD COMPARISON

    This is relatively straightforward. Here, we want to see if the value that the user typed in the first field matches (or is equal to) whatever they typed in the second field.
*/

if ($password != $password_check) {
    $message_password_check = "<p class=\"text-warning\">This password does not that the response above. Please try typing your password again.</p>";
    $form_good = FALSE;
}

/*
    NUMBERS (Years of Experience)

    For this particular field, we want to make sure: 

    1. It's a number
    2. It's a whole number (integer)
    3. It's within a reasonable range (0-60)

*/

// We can't use is_blank() because this is supposed to be a number, not a string.
if ($experience == "") {
    $message_experience = "<p class=\"text-warning\">Please enter your number of years of experience (even if it is 0).</p>";
} elseif (!is_numeric($experience)) {
    $message_experience = "<p class=\"text-warning\">Please enter a whole number.</p>";
} elseif (!ctype_digit($experience)) {
    // The method ctype_digit() makes sure that a value is numerical and a whole number. If there is a comma (for formatting) or a period (for a floating point, or decimal), it will return FALSE.
    $message_experience = "<p class=\"text-warning\">Please enter a whole number without any commas or full-stops.</p>";
} elseif ($experience < 0 || $experience > 60) {
    $message_experience = "<p class=\"text-warning\">Please enter a whole number between 0 and 60 years.</p>";
}

if ($message_experience != "") {
    $form_good = FALSE;
}

/*
    DATA LISTS

    For our 'Preferred Global Region for Assignments', we're going to:

        1. Make sure that the user typed something (presence check)
        2. Make sure their answer isn't too long.
        3. Ensure it only contains valid characters (letters, numbers, and a few punctuation marks).
*/

if (is_blank($region)) {
    $message_region = "<p class=\"text-warning\">Please enter your preferred region for assignments.</p>";
} elseif (strlen($region) > 128) {
    $message_region = "<p class=\"text-warning\">That region name is a bit too long. Try something shorter (128 characters or fewer).</p>";
} elseif (preg_match("/^[a-zA-Z0-9 .,'()&\-\/]+$/", $region)) {
    $message_region = "<p class=\"text-warning\">That region name contains invalid characters.</p>";
}

if ($message_region != "") {
    $form_good = FALSE;
}

}

?>