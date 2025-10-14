<?php

/*
    These two lines of code import our credentials (i.e., the things MySQLi needs to have in order to be authenticated and access the database) and create a connection handle. We use 'require' here rather than 'include' because if the file cannot be found or if PHP can't log into the database, the engine will throw a fatal error and the page won't load. 

    `__DIR__` gives use this script's current directory. The `2` then lets us jump two levels up. Finally, the appended path then brings us into the data/ directory, where our database connection information is.
*/

require_once dirname(__DIR__, 2) . '/data/connect.php';
$connection = db_connect();

$error_msg = "<p>No cities found.</p>";

?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Canadian Cities Queries</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    </head>

    <body class="container p-3">
        <header class="text-center row justify-content-center my-5">
            <section class="col col-md-10 col-xl-8">
                <h1 class="display-3">Canadian Cities Queries</h1>
                <p class="lead">The answers to all of the following questions are being pulled from the records we currently have stored in our database, one query at a time. This is done programatically, using MySQLi to fetch the records and PHP to display the results to the user. Every single time this page is loaded (or reloaded), the queries are run again.</p>
            </section>
        </header>

        <main class="row justify-content-center">
            <section class="col col-md-10 col-lg-8 col-xxl-6">
                <h2 class="display-4">Questions and Answers</h2>

                <h3 class="mt-4">Question 1: Which city has the highest population?</h3>

                <?php
                
                $sql = "SELECT city_name FROM cities ORDER BY population DESC LIMIT 1;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>The city with the highest population is " . $row['city_name'] . ".</p>";
                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 2: What are the names of all of the cities stored in our database, in alphabetical order?</h3>

                <?php
                
                $sql = "SELECT city_name FROM cities ORDER BY city_name ASC;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Our biggest challenge here is ... English. We need to present our results in a context or a way that makes sense to the user. In this case, we want to create a list of items where there's a comma (,) after each item -- except for the very last one.

                    // Let's initialise a simple indexed array.
                    $cities = array();

                    // We need to loop through each row that we just retrieved from the database to get all the names we need. 
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cities[] = $row['city_name'];
                    }

                    // Finally, we can output our results to the user. Here, we're using an array implosion method that takes all of the items in the $cities[] array that we just made and collapses them into a single string.
                    echo "<p>The following cities are currently stored in our database: " . implode(', ', $cities) . ".</p>";

                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 3: Which cities are located in the province of "QC" (Quebec)?</h3>

                <?php
                
                $sql = "SELECT city_name FROM cities WHERE province = 'QC';";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p>" . $row['city_name'] . "</p>";
                    } // endwhile
                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 4: Count the number of cities in each province.</h3>

                <?php
                
                $sql = "SELECT province, COUNT(*) AS city_count FROM cities GROUP BY province;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) : ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Province or Territory</th>
                            <th>Number of Cities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>

                            <tr>
                                <td><?= $row['province']; ?></td>
                                <td><?= $row['city_count']; ?></td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>

                <?php else: ?>
                    
                <?= $error_msg; ?>

                <?php endif; ?>

                <h3 class="mt-4">Question 5: Retrieve the city names and populations for cities with a population greater than 500,000.</h3>

                <?php
                
                $sql = "SELECT city_name, population FROM cities WHERE population > 500000;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p>" . $row['city_name'] . "'s population is " . number_format($row['population']) . ".</p>";
                    }
                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 6: Calculate the average population of all cities.</h3>

                <?php
                
                $sql = "SELECT AVG(population) AS average_population FROM cities;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>The average population of all cities in our database is " . number_format($row['average_population']) . ".</p>";
                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 7: Find the city with the smallest population.</h3>

                <?php
                
                $sql = "SELECT city_name, population FROM cities ORDER BY population ASC LIMIT 1;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>The city with the smallest population in our database is " . $row['city_name'] . ", with a population of " . number_format($row['population']) . ".</p>";
                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 8: List the cities located in provinces starting with the letter "N".</h3>

                <?php
                
                $sql = "SELECT city_name FROM cities WHERE province LIKE 'N%';";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $cities = [];
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cities[] = $row['city_name'];
                    }

                    // So far, this is just like the last time we imploded an array into a list of city names. This time, let's make it a bit trickier: let's make the last item have an ", and" before it.

                    // This grabs the last item in $cities, removes it from the array (pops it off) and assigns it to a string variable instead.
                    $last_city = array_pop($cities);
                    $city_list = implode(", ", $cities);

                    // There may be a case where there's only one city. This control structure accounts for that scenario.
                    if (!empty($city_list)) { // if there's multiple cities
                        echo "<p>" . $city_list . ", and " . $last_city . " are all cities in a province or territory starting with the letter 'N'.</p>";
                    } else { // else, if there's only one city
                        echo "<p>" . $last_city . " is in a province or territory starting with the letter 'N'.</p>";
                    }

                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 9: Retrieve the city names and populations for cities with populations between 100,000 and 500,000.</h3>

                <?php
                
                $sql = "SELECT city_name, population FROM cities WHERE population BETWEEN 100000 AND 500000;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p>" . $row['city_name'] . " has a population of " . number_format($row['population']) . ".</p>";
                    }
                } else {
                    echo $error_msg;
                }

                ?>

                <h3 class="mt-4">Question 10: Retrieve the total population for each province in the "cities" table.</h3>

                <?php
                
                $sql = "SELECT province, SUM(population) AS total_population FROM cities GROUP BY province;";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p>" . $row['province'] . "'s cities have a total population of " . number_format($row['total_population']) . ".</p>";
                    }
                } else {
                    echo $error_msg;
                }

                ?>

            </section>
        </main>
    </body>
</html>

<?php 

db_disconnect($connection); 

?>