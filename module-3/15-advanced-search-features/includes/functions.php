<?php

/*
    This counts the number of records we currently have in our table (in case any have been added or removed).
*/
function count_records() {
    global $connection;
    $sql = "SELECT COUNT(*) FROM happiness_index;";
    $results = mysqli_query($connection, $sql);
    $row = mysqli_fetch_row($results);
    return $row[0];
}

/**
 * This function lets us grab only the records we need for one page of paginated results.
 * 
 * @param int $per_page
 * @param int $offset
 * @return bool|mysqli_result - the records retrieved for the page
 */

function find_records($per_page = 12, $offset = 0) {
    global $connection;

    $sql = "SELECT `rank`, `country` FROM happiness_index LIMIT ?"; // Make sure you don't terminate this statement!

    if ($offset > 0) {
        // If there is an offset, we'll add it too.
        $sql .= " OFFSET ?;";

        // In this case, we have two parameters (both integers).
        $statement = $connection->prepare($sql);
        $statement->bind_param("ii", $per_page, $offset);
    } else {
        // If there is no offset, we have just one parameter (the limit).
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $per_page);
    }

    $statement->execute();
    return $statement->get_result();
}

?>