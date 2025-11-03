<?php

$title = "Edit a City";
$introduction = "To edit a city in our database, click 'Edit' beside the city you would like to change. Next, add your updated values into the form and hit 'Save'.";
include 'includes/header.php';

// We need to initialise a bunch of variables because we're dealing with multiple sets of data. We'll start by checking to see if there' a primary key in the query string. 
$city_id = $_GET['city_id'] ?? $_POST['city_id'] ?? "";

// If there's a primary key (i.e. if the user has chosen a city to edit), we need to fetch the details for that record (i.e. the values that already exist in the database.)
$city = $city_id ? select_city_by_id($city_id) : NULL;

// Next, we'll define the variables for all of the pre-existing values for the city.
$exisiting_city_name = $city['city_name'] ?? "";
$exisiting_province = $city['province'] ?? "";
$exisiting_population = $city['population'] ?? "";
$exisiting_capital = $city['is_capital'] ?? '0';
$exisiting_trivia = $city['trivia'] ?? "";

// After, we'll initialise variables for all of the value from the user (i.e. whatever they give us in the form).
$user_city_name = $_POST['city_name'] ?? "";
$user_province = $_POST['province'] ?? "";
$user_population = $_POST['population'] ?? "";
$user_capital = isset($_POST['is_capital']) ? $_POST['is_capital'] : '0';
$user_trivia = $_POST['trivia'] ?? "";

// Finally, some variables for status messages and alert boxes.
$message = "";
$alert_class = "alert-danger";

// TO DO: Process the form submission.


// TO DO: Message validation block.


// TO DO: Edit form.

echo "<h2 class=\"fw-light mb-3\">Current Cities in our Database</h2>";

generate_table(function($city) {
    // These variables will only have values assigned to them when the parent function, generate_table(), is called. This is beacause they are assigned by extracting each record in the foreach() loop.
    $cid = $city['cid'];

    return "<a href=\"edit.php?city_id=" . urlencode($cid) . "\" class=\"btn btn-warning\">Edit</a>";
});

include 'includes/footer.php';

?>