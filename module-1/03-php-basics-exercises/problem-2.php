<?php

$title = "Pythagorean Theorum";
include 'includes/header.php';

$adjacent = 3;
$opposite = 7;

/**
 * When PHP is parsing an arithmetic expression, our order of operations applies:
 * B   - Brackets (also known as Parenthesis)
 * E   - Exponents
 * D/M - Division OR Multiplication (can happen in either order)
 * A/S - Addition OR Subtraction (can also happen in either order) 
**/ 

$hypotenuse = sqrt($adjacent ** 2 + $opposite ** 2);

/**
 * PHP will parse this as:
 * sqrt($adjacent ** 2 + $opposite ** 2)
 * sqrt(9 + 49)
 * sqrt(58)
 * ~ 7.62
 */

// The final number is very long! Let's round it for the user.
$hypotenuse = round($hypotenuse, 2);

echo "<p>The hypotenuse of a right traingle with an adjacent length of $adjacent and an opposite length of $opposite is $hypotenuse.</p>";

?>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contentss</a>

<?php include 'includes/footer.php'; ?>