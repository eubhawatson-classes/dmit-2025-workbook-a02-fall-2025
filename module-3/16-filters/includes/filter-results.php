<?php

$sql = "SELECT * FROM happiness_index WHERE 1 = 1";
$types = "";
$parameters = [];

foreach ($active_filters as $filter => $filter_values) {
    // Queries that use a range (i.e. looks for something BETWEEN two values) are handled differently than the condition to look at specific continents. We'll store all of them in their own little array. Again, we're using arrays so that we can use array methods and do not accidentally overwrite anything (things will authomatically be appended to the end of the array as we loop through the values).
    $range_queries = [];

    if (in_array($filter, ["life_expectancy", "wellbeing", "eco_footprint"])) {
        foreach ($filter_values as $value) {
            // This makes a list (a type of array) out of our range. It parses everything before the hyphen and after the hyphen to create a $min and $max value.
            list($min, $max) = explode("-", $value, 2);

            $range_queries[] = "$filter BETWEEN ? AND ?";
            $types .= "dd";
            $parameters[] = $min;
            $parameters[] = $max;
        }

        if (!empty($range_queries)) {
            $sql .= " AND (" . implode(" OR ", $range_queries) . ")";
        }
    } elseif (array_key_exists($filter, $filters)) {
        // Here, we'll handle any continent queries. We'll start by determining the number of ?s the user needs (i.e. how many continents they chose).
        $placeholders = str_repeat("?,", count($filter_values) - 1) . "?";
        $sql .= " AND $filter IN ($placeholders)";
        $types .= str_repeat("s", count($filter_values));
        $parameters = array_merge($parameters, $filter_values);
    }
}

if (!empty($active_filters)) {
    $statement = $connection->prepare($sql);
}

if ($statement == FALSE) {
    echo "<p>Error retrieving data. Please try again later.</p>";
    exit();
}

$statement->bind_param($types, ...$parameters);

if (!$statement->execute()) {
    echo "<p>Error binding parameters. Please clear your filters and try again later.</p>";
    exit();
}

// If everything was successful, we can grab the results from the database.
$result = $statement->get_result();

echo '<h2 class="display-4 mt-5 mb-4">Results</h2>';

// Now, let's generate our country cards.

if ($result->num_rows > 0) {
    // If we find anything, we'll add a leading paragraph and spit out the cards.
    echo '<p class="lead mb-5">Here is what we were able to find.</p>';

    echo '<div class="row">';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-6 col-xl-4 mb-4">';
        include 'includes/country-card.php';
        echo '</div>';
    }

    echo '</div>';
} else {
    // If we can't find anything, let's tell the user.
    echo '<p class="lead mb-5">We were not able to find anything matching your selected filters.</p>';
}


?>