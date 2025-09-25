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
$loyalty = isset($_POST['loyalty']) ? $_POST['loyalty'] : '';
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

?>