<?php

require_once '../private/authentication.php';

$title = "Login Page";
$introduction = "Please log in using your provided credentials to access your account. If you enter incorrect details, you will receive an error message. Once logged in, you'll be redirected to the admin area.";
include 'includes/header.php';

$error = "";

/*
    STEPS FOR LOGGING IN A USER:

    1. The user will log in with a form.
    2. Our script will search for the username in the database.
    3. If the username is found, our script will compare the submitted password with the stored hash in the database. 
    4. If the hashes match, then it sets a value in the session to the user ID / an authentication token and redirects to a post-login page (ex. profile).

*/

?>

<h2 class="fw-light my-3">Login Form</h2>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

    <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" id="username" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="text" name="password" id="password" class="form-control">
    </div>

    <input type="submit" id="submit" name="submit" value="Log In" class="btn btn-success my-3">
</form>

<?php include 'includes/footer.php'; ?>