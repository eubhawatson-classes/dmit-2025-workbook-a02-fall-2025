<?php

$title = "Table of Contents";
/**
 * This is another way of writing an inclusion statement (with a formal method):
 * include('includes/header.php'); 
 **/ 
include 'includes/header.php';

?>

<ul class="nav flex-column">
    <!-- li.nav-item*3>a.nav-link -->
     <li class="nav-item">
        <a href="problem-1.php" class="nav-link">Problem 1</a>
    </li>
     <li class="nav-item">
        <a href="problem-2.php" class="nav-link">Problem 2</a>
    </li>
     <li class="nav-item">
        <a href="problem-3.php" class="nav-link">Problem 3</a>
    </li>
</ul>

<?php

include 'includes/footer.php';

?>