<?php

$title = "Deletion Confirmation";
$introduction = "";
include 'includes/header.php';

// Because we're using the GET method, remember that the user can muck around with the query string. To prevent any weirdness (i.e. unpredicted errors and behaviours), we'll check to make sure the city ID and the city name are valid.
$city_id = filter_input(INPUT_GET, 'city', FILTER_VALIDATE_INT);
$city_name = filter_input(INPUT_GET, 'city_name', FILTER_SANITIZE_SPECIAL_CHARS);

$message = "";

// If the primary key or city name is missing or invalid, we'll show an error message.
if (!$city_id || !$city_name) {
    $message = "<p>Please return to the delete page and select an option from the table.</p>";
}

// Handle the deletion process and confirmation.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hidden_id = filter_input(INPUT_POST, 'hidden_id', FILTER_VALIDATE_INT);
    $hidden_name = filter_input(INPUT_POST, 'hidden_name', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($hidden_id) {
        delete_city($hidden_id);
        $message = "<p>" . urldecode($hidden_name) . " was deleted from the database.</p>";

        // Here, we're setting the $city_id to NULL so that the form doesn't show up again.
        $city_id = NULL;
    }
}

if ($message != "") : ?>

<div class="alert alert-danger text-center" role="alert">
    <?= $message; ?>
</div>

<?php endif;

// If there is a city_id in the query string, we'll show the user the delete button (form).
if ($city_id) : ?>

<p class="text-danger lead mb-5">
    Are you sure that you want to delete <?= urldecode($city_name); ?>?
</p>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="text-center">
    <!-- We need to preserver the information in our query string in hidden values so they do not disappear after the user hits the delete button. -->
    <input type="hidden" name="hidden_id" id="hidden_id" value="<?= $city_id; ?>">
    <input type="hidden" name="hidden_name" id="hidden_name" value="<?= $city_name; ?>">

    <!-- Submit -->
    <input type="submit" name="confirm" id="confirm" value="Yes, I'm sure." class="btn btn-lg btn-danger">
</form>

<?php endif; ?>

<a href="delete.php" class="text-link my-5">Return to 'Delete a City' Page</a>

<?php include 'includes/footer.php'; ?>