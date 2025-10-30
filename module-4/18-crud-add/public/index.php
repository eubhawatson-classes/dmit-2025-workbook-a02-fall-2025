<?php

$title = "Weclome!";
$introduction = "Welcome to the Canadian Cities Online Database! All of the cities that we currently have listed in our system are down below. Click on any of the buttons above to get started on adding, editing, or deleting and of these entries.";
include 'includes/header.php';

echo "<h2 class=\"fw-light mb-3\">Current Cities in our Database</h2>";

generate_table();

include 'includes/footer.php';

?>