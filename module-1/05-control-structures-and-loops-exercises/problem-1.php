<?php

$title = "Value Checker";
include 'includes/header.php';

$number = (string) "a;sldkjf;asldkjf";

if (!is_numeric($number)) {
    echo "<p>$number is not a number.</p>";
} elseif ($number > 0) {
    echo "<p>$number is a positive number.</p>";    
} elseif ($number < 0) {
    echo "<p>$number is a negative number.</p>";
} elseif ($number === 0) {
    echo "<p>$number is a zero.</p>";
} else {
    echo "<p>$number is an unknown data type.</p>";
}

?>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contents</a>

<?php include 'includes/footer.php'; ?>