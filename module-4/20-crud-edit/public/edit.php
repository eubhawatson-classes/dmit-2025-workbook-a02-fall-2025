<?php

$title = "Edit a City";
$introduction = "To edit a city in our database, click 'Edit' beside the city you would like to change. Next, add your updated values into the form and hit 'Save'.";
include 'includes/header.php';

// We need to initialise a bunch of variables because we're dealing with multiple sets of data. We'll start by checking to see if there' a primary key in the query string. 
$city_id = $_GET['city_id'] ?? $_POST['city-id'] ?? "";

// If there's a primary key (i.e. if the user has chosen a city to edit), we need to fetch the details for that record (i.e. the values that already exist in the database.)
$city = $city_id ? select_city_by_id($city_id) : NULL;

// Next, we'll define the variables for all of the pre-existing values for the city.
$exisiting_city_name = $city['city_name'] ?? "";
$exisiting_province = $city['province'] ?? "";
$exisiting_population = $city['population'] ?? "";
$exisiting_capital = $city['is_capital'] ?? '0';
$exisiting_trivia = $city['trivia'] ?? "";

// After, we'll initialise variables for all of the value from the user (i.e. whatever they give us in the form).
$user_city_name = $_POST['city-name'] ?? "";
$user_province = $_POST['province'] ?? "";
$user_population = $_POST['population'] ?? "";
$user_capital = isset($_POST['capital']) ? $_POST['capital'] : '0';
$user_trivia = $_POST['trivia'] ?? "";

// Finally, some variables for status messages and alert boxes.
$message = "";
$alert_class = "alert-danger";

// If the user has submitted their form, we'll need to validate the data.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validation_result = validate_city_input($user_city_name, $user_province, $user_population, $user_capital, $user_trivia, $provincial_abbr);

    if ($validation_result['is_valid']) {

        // If the user's data passes validation, we will try to update the values for that record in the database.
        if (update_city($user_city_name, $user_province, $user_population, $user_capital, $user_trivia, $city_id)) {
            $alert_class = "alert-success";
            $message = "{$user_city_name} was updated successfully.";

        } else {
            $message = "There was an error updating the city.";
        }

    } else {
        $message = implode("</p><p>", $validation_result['errors']);
    }
}


// This is our status message block.
if ($message != "") : ?>

<div class="alert <?= $alert_class; ?>" role="alert">
    <p><?= $message; ?></p>
</div>

<?php endif;

// If the city ID is set (i.e. if the user chose a city to edit), we'll show the user the form. This should be high up enough on the page for the user to see. 

if ($city_id) : ?>

<h2 class="fw-light mb-3">Editing <?= $exisiting_city_name; ?></h2>

<?php include 'includes/form.php'; ?>

<?php endif;

echo "<h2 class=\"fw-light mb-3 mt-5\">Current Cities in our Database</h2>";

generate_table(function($city) {
    // These variables will only have values assigned to them when the parent function, generate_table(), is called. This is beacause they are assigned by extracting each record in the foreach() loop.
    $cid = $city['cid'];

    return "<a href=\"edit.php?city_id=" . urlencode($cid) . "\" class=\"btn btn-warning\">Edit</a>";
});

include 'includes/footer.php';

?>