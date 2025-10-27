<?php

$title = "Filter the Data";
include 'includes/header.php';

/**
 * This function builds a query string for us that helps us retain the currently selected values when the user clicks on an additional filter.
 * 
 * $base_url - the page you're linking to (filters.php)
 * $filters - the CURRENT filters already in the URL (an associative array)
 * $filter - the CATEGORY you're toggling (e.g. continent, wellbeing ...)
 * $value - the specific VALUE you're toggling (e.g. europe, 6-8 ...)
 */
function build_query_url($base_url, $filters, $filter, $value) {
    // Grab the current list for this filter and immediately convert everything to strings so comparisons are the same.
    $values = array_map('strval', $filters[$filter] ?? []);

    // Same treatment for the incoming value: it's a string from here on out.
    $string_value = (string) $value;

    // Let's do a strict search inside of our array to make sure we only match the thing we expect. The result will be TRUE or FALSE.
    $position = array_search($string_value, $values, TRUE);

    if ($position !== FALSE) {
        // If we found our value in our current query string, this means the user is clicking it for a second time and need to toggle it OFF.
        unset($values[$position]);

        // Reindex so we don't end up with scruffy array keys in the query string. 
        $values = array_values($values);
    } else {
        // In our else case, the value is not present yet (i.e. not yet in the query string). We will toggle it ON by appending it to the array.
        $values[] = $string_value;
    }

    // After toggling our single value, if the list for that filter is empty, we need to delete the filter key entirely. This will keep the URL tidy, our state accurate, and our later checks straightforward.
    if (!empty($values)) { // If the list for this filter still has at least one item ...
        $filters[$filter] = $values;
    } else { // ... else, if the list is now empty because we toggled the last item off ...
        unset($filters[$filter]);
    }

    // Turn the filters back into a neat little query string and hand back the full URL.
    return $base_url . '?' . http_build_query($filters);
}

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

<h2 class="display-5">Filter the Data</h2>
<p class="lead mb-5">Select any combination of the buttons below to filter the data.</p>

<?php

// Because we're using a 2D array to generate our buttons, we need two loops (an outer and inner loop).
foreach ($filters as $filter => $options) {
    // We'll start by taking the category names and 'translating' them into headings for each category. 
    $heading = ucwords(str_replace("_", " ", $filter));
    echo '<h3 class="fw-light mt-5">' . $heading . '</h3>';
    
    // Now, let's generate all of the buttons (options) for each category.
    echo '<div class="btn-group mb-3" role="group" aria-label="' . $heading . ' Filter Group">';

    foreach ($options as $value => $label) {
        // Is the option that we're currently generating already active (i.e. has the user previously clicked on it)?
        $is_active = in_array($value, $active_filters[$filter] ?? []);

        // Let's use the custom function from earlier to build a unique href value (incl. query string) for the button we're making.
        $url = build_query_url($_SERVER['PHP_SELF'], $active_filters, $filter, $value);

        echo '<a href="' . $url . '" class="btn ' . ($is_active ? 'btn-success' : 'btn-outline-success') . '" aria-pressed="' . ($is_active ? 'true' : 'false') . '">' . $label .'</a>';
    }

    echo '</div>';
}  

// If there are active filters, we'll also give the user a 'clear filters' button. This literally just links to the same page but without a query string.
if (!empty($active_filters)) {
    echo '<div class="my-5">
          <a href="filters.php" class="btn btn-danger">Clear Filters</a>
          </div>';

    
}
 
?>

<?php include 'includes/footer.php'; ?>