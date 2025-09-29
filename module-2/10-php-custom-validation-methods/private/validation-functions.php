<?php
/**
 * This file contains a collection of reusable validation helper functions.
 * 
 * BLANKS / PRESENCE: Check whether or not a value is set or exists.
 * EXCLUSIONS / INCLUSIONS: Verify that a value is amongst a set of allowed values.
 * DATA TYPE: PHONE NUMBER: Normalise phone inputs by stripping syntax.
 * DATA TYPE: STRINGS: Validate string length and character constraints. 
 */

/**
 * Determines is a vlue is blank (unset or empty after trimming whitespace).
 * Uses === to avoid false positives (unlike empty(), which treats "0" as blank).
 * Note: trim() only works on strings (not arrays).
 * 
 * @param mixed $value - the value to check.
 * @return BOOL - TRUE if the value is not set or is an empty string after trim().
 */
function is_blank($value) {
    return !isset($value) || trim($value) === '';
}

/*
    EXCLUSIONS / INCLUSIONS
*/

/**
 * Checks if a given value exists in a set of allowed values. 
 * Useful for validating dropdowns, radio buttons, or any discrete list.
 * 
 * @param mixed $value - The needle (the thing we are looking for).
 * @param array $set - The haystack (the thing we are looking inside of).
 * @return BOOL - TRUE is $value is found in $set; FALSE if not. 
 */
function has_allowed_value($value, $set) {
    return in_array($value, $set);
}

/*
    DATA TYPE: PHONE NUMBERS
*/

/**
 * Normalises a phone number string by stripping out common formatting characters.
 * Removes: +, -, ., (, ), and spaces.
 * 
 * @param string $value - The raw phone number input.
 * @return string $value - The cleaned numeric phone string.
 */
function valid_phone_format($value) {
    // We want to remove: + - . ( )
    $value = str_replace("+", "", $value);
    $value = str_replace("-", "", $value);
    $value = str_replace(".", "", $value);
    $value = str_replace("(", "", $value);
    $value = str_replace(")", "", $value);
    $value = str_replace(" ", "", $value);

    return $value;
}

/*
    DATA TYPE: STRINGS
*/

/**
 * Check if the length of a string is less than a maximum value.
 * 
 * @param string $value - the string to measure.
 * @param int $max - The maximum length allowed.
 * @return BOOL - TRUE if the length is less than the maximum allowed; FALSE otherwise.
 */
function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
}

?>