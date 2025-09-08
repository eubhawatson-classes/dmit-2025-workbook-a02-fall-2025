<?php

$title = "Swapping Variable Values";
include 'includes/header.php';

$number_1 = 3;
$number_2 = 7;

echo "<p>The first number is $number_1; the second number is $number_2.</p>";

$number_3 = $number_1;
$number_1 = $number_2;
$number_2 = $number_3;

echo "<p>The first number is $number_1; the second number is $number_2.</p>";

?>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contentss</a>

<?php include 'includes/footer.php'; ?>