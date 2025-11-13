<?php

require_once '../private/authentication.php';
// TO DO: Call login required function.

$title = "Private Page (Admin)";
$introduction = "Welcome to the admin area! This page is only accessible to authenticated users. If you've reached this page, you are successfully logged in. If you log out, you will be redirected to the home page.";
include 'includes/header.php';

include 'includes/footer.php';

?>