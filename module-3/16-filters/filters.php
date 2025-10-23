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
    // This function starts by copying the existing filters into a new variable. This ensures that the original $filters remains unchanged while we modify the copy.
    $updated_filters = $filters;

    /**
     * DECIDE IF WE'RE REMOVING OR ADDING
     * 
     * If the category exists AND already contains this value, we're turning it OFF; otherwise, we're turning it ON.
     * 
     */

    if (isset($updated_filters[$filter]) && in_array($value, $updated_filters[$filter])) {
        
        // This compares two arrays and looks to see if there's any difference between them.
        $updated_filters[$filter] = array_diff($updated_filters[$filter], [$value]);

        // If there's no difference, this removes the value from the array.
        if (empty($updated_filters[$filter])) {
            unset($updated_filters[$filter]);
        } else {
            // If the filters does not already exists in our query string, we know it's a new value and we need to add it in.
            $updated_filters[$filter][] = $value;
        }
    }

    // This gives us the full href value for the link we'll be generating for the user.
    return $base_url . '?' . http_build_query($updated_filters);
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

    }

    echo '</div>';
}
 
?>

<?php include 'includes/footer.php'; ?>