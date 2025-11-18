<?php

// This must be included on every page that you wish to access $_SESSION variables from.
session_start();

require_once dirname(__DIR__, 3) . '/data/connect.php';
$connection = db_connect();

/**
 * Authenticates user based on username and password.
 */
function authenticate ($username, $password) {
    global $connection;

    $statement = $connection->prepare("SELECT `account_id`, `hashed_pass` FROM users WHERE `users` = ?;");

    if (!$statement) {
        die ("Prepare failed: " . $connection->error);
    }

    $statement->bind_param("s", $username);
    $statement->execute();

    /**
     * STASH THE RESULTS IN MEMORY WITH store_result();
     * 
     * By default, MySQLi streams results row by row.
     * 
     * store_result() pulls the entire result set from the database server and stores it in the MySQLI object's memory. 
     * 
     * This populates $statement->num_rows so we can quickly check whether we got a user back from the database and makes sure we don't lose the results we need if we do anything else with the data. 
     */
    $statement->store_result();

    if ($statement->num_rows > 0) {

        // VS Code will get angry here because we haven't defined these values in the script; instead, the values are coming from the database (specifically, the columns in the results that we stored in the previous step).
        $statement->bind_result($account_id, $hashed_pass);

        $statement->fetch();

        if (password_verify($password, $hashed_pass)) {

            /**
             * If we have a match, we'll log the user in by storing a bunch of data in the $_SESSION.
             * 
             * We'll start by regenerating the session ID. This helps prevent a session fixation attack. 
             */
            session_regenerate_id(TRUE);

            $_SESSION['user_id'] = $account_id; // this uniquely identifies the user in the database and is used for permission lookups. 
            $_SESSION['username'] = $username; // lets us greet the user or show their name without querying the database constantly. 
            $_SESSION['last_regeneration'] = time(); // this COULD BE used elsewhere to periodically rotate the session ID again for added security.

            return TRUE;
        }
    }

    // This is a catch-all for any failures above. If anything does not result in 'true', we will return 'false'.
    return FALSE;
}


/**
 * Checks to see if the user is currently logged in.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirects the user if they're not authenticated (logged in).
 */
function require_login() {
    if (!is_logged_in()) {
        // If the user is NOT logged in, we'll send them to the login page.
        header("Location: login.php");
        // This kills the rest of script and prevents anything from rendering client-side (no HTML output for a page the user shouldn't see).
        exit();
    }
}

/**
 * Logs the user out.
 */
function logout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

?>