<?php

// This must be included on every page that you wish to access $_SESSION variables from.
session_start();

require_once dirname(__DIR__, 3) . '/data/connect.php';
$connection = db_connect();

/**
 * Authenticates user based on username and password.
 */

/**
 * Checks to see if the user is currently logged in.
 */

/**
 * Redirects the user if they're not authenticated (logged in).
 */

/**
 * Logs the user out.
 */
?>