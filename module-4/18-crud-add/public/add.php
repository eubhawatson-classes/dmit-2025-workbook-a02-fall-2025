<?php

$title = "Add a City";
$introduction = "To add a city to our database, simply fill out the form below and hit 'save'.";
include 'includes/header.php';

// If nothing is selected for whether or not the city is a capital, we'll default to 'No' (a value of 0).
$capital = isset($_POST['capital']) ? $_POST['capital'] : '0';

$message = "";
$alert_class = 'alert-danger';

if (isset($_POST['submit'])) {
    // We'll call our validation function here. Remember that the array with the provincial abbreviation is in the validation script.
    $validation_result = validate_city_input($_POST['city-name'], $_POST['province'], $_POST['population'], $capital, $_POST['trivia'], $provincial_abbr);

    if ($validation_result['is_valid']) {
        // If the data is valid, we can move onto inserting it.
        $data = $validation_result['data'];

        if (insert_city($data['city_name'], $data['province'], $data['population'], $data['capital'], $data['trivia'])) {
            $message = "City added successfully!";
            $alert_class = "alert-success";

            // If you want, you can clear the input values here to prevent the user from spam-adding the same city.
        } else {
            $message = "There was a problem adding the city: " . $connection->error;
        }

    } else {
        // If the data is invalid, we can show some errors.
        $message = implode("</p><p>", $validation_result['errors']);

    } // end of validation handling
} // end of 'if the user hit submit'

if ($message != "") : ?>

<div class="p-3 alert <?= $alert_class ?? 'alert-danger'; ?>" role="alert">
    <p><?= $message; ?></p>
</div>

<?php endif;

include 'includes/form.php';

include 'includes/footer.php';

?>