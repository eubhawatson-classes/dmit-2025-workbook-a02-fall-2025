<?php

/*
    This script will use prepared statements, which adds a layer of abstraction between our user's (potentially dangerous) input and the SQL statements that we're executing. 

    NOTE: If we're only reading out data to the user and not accepting any input from something like a web form, we don't really need to use prepared statements because everything is procedural at that point; however, we're going to use this method for all of the other pages in our CRUD application, so we'll try to get in the habit of using it now (and set up this file for later additions). 

    Just like our simple MySQLi methods, using prepared statements for our queries means we need to follow a certain series of events. 

    1. Make sure we're connected to the database (this is in our included header.php file).
    2. Write the SQL query with placeholders (?) for each parameter.
    3. Prepare the query using $connection->prepare($query) while handling any errors if this fails.
    4. Bind the input values to the placeholders in the query using $statement->bind_param() and specify the data type of each parameter.
    5. Pass the variables or values as arguments to bind_param().
    6. Call $statement->execute() to execute the query with the bound parameters.
    7. For SELECT queries, retrieve the result set using $statement->get_result().
    8. Close the prepared statement after finished to free up server resources.
*/

/**
 * @param string $query  - The SQL query with placeholders (e.g. ?).
 * @param array $params  - The parameters to bind to the placeholders in the query.
 * @param string $types  - A string of data types for `bind_param` (e.g. 'ssid' ...).
 * @return mixed         - For SELECT queries, the result set; otherwise, TRUE/FALSE.
 */
function execute_prepared_statement($query, $params = [], $types = "") {
    global $connection;

    // Let's start by preparing our connection and making sure we're properly hooked up to the database.
    $statement = $connection->prepare($query);

    // If our preparation fail, we need to handle the error and quit this function.
    if (!$statement) {
        die("Preparation failed: " . $connection->error);
    }

    // If we need to bind any parameters (i.e. if we're adding, editing, or deleting), we'll do so here.
    if (!empty($params)) {
        $statement->bind_param($types, ...$params);
    }

    // This executes the statement right from within our IF condition, which makes our code a little more compact.
    if (!$statement->execute()) {
        die("Execution failed: " . $statement->error);
    }

    // If it's a SELECT query, we should return the results so that we can print them out for the user.
    if (str_starts_with(strtoupper($query), "SELECT")) {
        return $statement->get_result();
    }

    // If we successfully executed our prepared statement (and it's NOT a simple SELECT query), this whole function will return TRUE.
    return TRUE;
}

/**
 * This function retrieved all cities using a simple SELECT statement.
 * There are no user-provided values or ?s required here.
 */
function get_all_cities() {
    $query = "SELECT * FROM cities;";
    $result = execute_prepared_statement($query);

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * INSERT (i.e. create or add) a new city into the database; used in the Add page.
 * 
 * @param string $city_name
 * @param string|ENUM $province
 * @param int $population
 * @param int|BOOL $is_capital
 * @param string|NULL $trivia
 * 
 * @return BOOL - Whether or not the prepared statement was properly executed.
 */
function insert_city($city_name, $province, $population, $is_capital, $trivia) {
    // The trivia column is optional and may be left empty; if it is, we'll set it to NULL.
    if (empty($trivia)) {
        $trivia = NULL;
    }

    $query = "INSERT INTO cities (`city_name`, `province`, `population`, `is_capital`, `trivia`) VALUES (?, ?, ?, ?, ?);";

    return execute_prepared_statement($query, [$city_name, $province, $population, $is_capital, $trivia], "ssiis");
}


/**
 * DELETE a city using the city ID (the primarky key). Used in the delete-confirmation page.
 * 
 * @param int $cid - the primary key of the record.
 * 
 * @return bool|mysqli_result - TRUE or FALSE depending upon deletion success.
 */
function delete_city($cid) {
    $query = "DELETE FROM cities WHERE cid = ?;";
    return execute_prepared_statement($query, [$cid], "i");
}


/**
 * SELECT (retrieve) a specific city by ID; used in the Edit page.
 * 
 * @param int $cid - the primary key for the record.
 * 
 * @return mysqli_result|NULL - the record from the database.
 */
function select_city_by_id($cid) {
    $query = "SELECT * FROM cities WHERE cid = ?;";
    $result = execute_prepared_statement($query, [$cid], "i");

    return $result->fetch_assoc();
}


/**
 * UPDATE an existing city record; used in the Edit page.
 * 
 * @param string $city_name
 * @param string $province
 * @param int $population
 * @param int|null $is_capital
 * @param string|null $trivia
 * @param int $cid
 * @return bool|mysqli_result
 */
function update_city($city_name, $province, $population, $is_capital, $trivia, $cid) {
    $query = "UPDATE cities SET `city_name` = ?, `province` = ?, `population` = ?, `is_capital` = ?, `trivia` = ? WHERE `cid` = ?;";

    return execute_prepared_statement($query, [$city_name, $province, $population, $is_capital, $trivia, $cid], "ssiisi");
}
?>