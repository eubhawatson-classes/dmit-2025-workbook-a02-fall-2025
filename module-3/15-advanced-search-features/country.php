<?php

// Let's start by grabbing our values from the query string and sanitising them.
$rank = isset($_GET['rank']) ? urldecode($_GET['rank']) : "";
$rank = htmlspecialchars($rank, ENT_QUOTES, 'UTF-8');

$country = isset($_GET['country']) ? urldecode($_GET['country']) : "";
$country = htmlspecialchars($country, ENT_QUOTES, 'UTF-8');

$title = "Home";
include 'includes/header.php';

// If we're missing a value from the query string, we'll display an error message.
if ($rank == "" || $country == "") {
    echo "<h2 class=\"display-5\">Oh no!</h2>";
    echo "<p class=\"lead\">We couldn't find the country you were looking for.</p>";
} else {

    /*
        SQL INJECTIONS

        Due to the way that SQL is structure, it's easy for users to slip in an arbitrary statement with their inputs (including query strings). This is why we need to use prepared statements and sanitise our values.

        Let's say we have a sign up / registration form. For the name, our user gives us the following:

            Valerie'); DROP TABLE customers; --

        If we don't use prepared statements, the application's query might look like:

            INSERT INTO customers (name, email, username, password) VALUES ('Valerie'); DROP TABLE customers; --
    */

    // This is a prepared statement. It's a template for the kind of query we're going to be using on this page. It uses a ? (a placeholder) value instead of the raw value (ex. $rank). This gives us an additional layer of security (via levels of abstraction) and makes us substantially less vulnerable to attacks like SQL injections.
    $query = "SELECT * FROM happiness_index WHERE `rank` = ?;";

    // Next, we need to check to see if the connection is good and the syntax is correct.
    if ($statement = $connection->prepare($query)) {
        // Next, we need to tell MySQL what data type (integer, in this case) we are using and which parameter (value) to bind to our earlier 'template'.
        $statement->bind_param("i", $rank);

        // Now, we get to actually run it ...
        $statement->execute();

        // ... and fetch the results. 
        $result = $statement->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<h2 class=\"display-4 mb-3\">" . $row['country'] . " Statistics</h2>";
            include 'includes/country-card.php';
        } else {
            echo "<p>No data found for the selected country.</p>";
        }
    } else {
        die("Query preparation failed: " . $connection->error);
    }
}

?>

<!-- Let's give the user a pathway back to the index. -->
<a href="index.php" class="btn btn-dark mt-4">Return to Index</a>

<?php include 'includes/footer.php'; ?>