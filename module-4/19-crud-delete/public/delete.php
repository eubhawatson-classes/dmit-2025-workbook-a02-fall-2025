<?php

$title = "Delete a City";
$introduction = "To remove a city from our database, click 'Delete' beside the city you would like to remove. You will then be taken to a confirmation page where you can complete the deletion process.";
include 'includes/header.php';

echo "<h2 class=\"fw-light mb-3\">Current Cities in our Database</h2>";

generate_table(function($city) {
    // These variables will only have values assigned to them when the parent function, generate_table(), is called. This is beacause they are assigned by extracting each record in the foreach() loop.
    $cid = $city['cid'];
    $city_name = $city['city_name'];

    return "<a href=\"delete-confirmation.php?city=" . urlencode($cid) . "&city_name=" . urlencode($city_name) . "\" class=\"btn btn-danger\">Delete</a>";
});

include 'includes/footer.php';

?>