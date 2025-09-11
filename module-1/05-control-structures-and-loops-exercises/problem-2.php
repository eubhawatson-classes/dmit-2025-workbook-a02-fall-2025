<?php

$title = "Times Tables";
include 'includes/header.php';

$number = 5;

?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Equation</th>
            <th>Product</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
            for ($i = 0; $i <= 10; $i++) {
                echo "<tr>";
                echo "<td>$number * $i</td>";
                echo "<td>" . ( $number * $i ) . "</td>";
                echo "</tr>";
            }

        ?>
    </tbody>
</table>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contentss</a>

<?php include 'includes/footer.php'; ?>