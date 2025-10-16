<?php

$title = "Home";
include 'includes/header.php';

?>

<h2 class="display-5 my-3">Welcome to the Happy Planet Index</h2>
<p class="lead mb-5">The Happy Planet Index is a measure of sustainable wellbeing, ranking countries by how efficiently they deliver long, happy lives using our limited environmental resources.</p>

<?php

$sql = "SELECT `rank`, `country` FROM happiness_index;";
$result = $connection->query($sql);

if ($connection->error) : ?>

<!-- If there's an error message, we'll display something to the user. -->
<p>Oh no! There was an issue retrieving the data.</p>

<?php elseif ($result->num_rows > 0) : ?>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th scope="col">HPI Rank</th>
            <th scope="col">Country Name</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
                // This method takes each element inside of our row and turns it into its own separate variable. The variable names will be the same as the column names.
                extract($row);

                echo "<tr> \n
                <td>$rank</td> \n
                <td>$country</td> \n
                <td><a href=\"country.php?rank=" . urlencode($rank) . "&country=" . urlencode($country) . "\" class=\"link-success\">View Stats</a></td> \n
                </tr> \n";
            }
        ?>
    </tbody>
</table>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>