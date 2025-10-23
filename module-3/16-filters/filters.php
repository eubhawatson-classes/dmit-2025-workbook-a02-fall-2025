<?php

$title = "Filter the Data";
include 'includes/header.php';

// We'll start by seeing if the user chose any filters (i.e. if any filters are active).
$active_filters = [];

foreach ($_GET as $filter => $values) {
    // If any of the values are not already arrays, let's convert them into one.
    $values = is_array($values) ? $values : [$values];

    // Now, let's sanitise the value.
    $active_filters[$filter] = array_map(fn($v) => htmlspecialchars($v, ENT_QUOTES | ENT_HTML5, 'UTF-8'), $values);
}

include 'includes/filter-results.php';

?>

<?php include 'includes/footer.php'; ?>