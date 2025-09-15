<?php

$title = "Odd or Even";
include 'includes/header.php';

/* 

When the user initially loads the page, there is no form data (i.e. they haven't submitted anything yet). We need to do an if/else to check the page's current state. 

If we use the following:

$number = $_POST['number'];

... we get an error when we load the page.

We could use this structure:

if (isset($_POST['number'])) {
    $number = $_POST['number'];
} else {
    $number = "";
}

... but it's very long. We'll use a ternary instead.

$variable = (condition) ? if TRUE : if FALSE ;
*/

$number = isset($_POST['number']) ? trim($_POST['number']) : "";
$message = "";

?>

<p class="lead mb-5">Enter a whole number below and hit "Submit" to see whether it is odd or even.</p>

<!-- 
    action: this is where the data goes (what will proccess it) when the user hits submit. Because our development environment may be different than the production server, we are using a $_SERVER value to say 'this page will handle the data'. 

    NOTE: We are using htmlspecialchars() to help prevent XSS attacks. This method strips out any characters that may be interpreted as scripting language (< > ; -) and turning them into harmless HTML character entities (ex. &gt; &lt; etc.).

    method: this tells the browser how to send the data (i.e. which protocol). We will use GET and POST this semester.
-->

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mb-5">
    <div class="mb-3">
        <label for="number" class="form-label"></label>
        <input type="number" id="number" name="number" step="1" class="form-control" value="<?= $number; ?>" required>
    </div>

    <input type="submit" id="submit" name="submit" value="Submit" class="btn btn-primary">
</form>

<?php

if (isset($_POST['submit'])) {
    // First, let's see if the user gave us anything.
    if ($number === "") {
        
        $message = "<p class=\"text-danger fs-2\">Please enter a value.</p>";

    } elseif (filter_var($number, FILTER_VALIDATE_INT)) { // is this an INT?
        
        // Before we do any math, we'll typecast the user's number into an integer. If we don't do this, cases like '0' won't work properly.
        $number = (int) $number;

        if ($number % 2 == 0) { // if the number is even
            $message = "<p class=\"text-success fs-2\">$number is an <strong>even</strong> number.</p>";
        } elseif ($number == 0) { // if the number is 0
            $message = "<p class=\"text-success fs-2\">$number is an <strong>even</strong> number.</p>";
        } else { // else, the number is odd
            $message = "<p class=\"text-success fs-2\">$number is an <strong>odd</strong> number.</p>";
        }

    } else { // if the number failed filter_var(), we'll give an error.
        $message = "<p class=\"text-danger fs-2\">Please enter a whole number.</p>";
    }

    echo $message;

} // end of 'if the user hit submit'

?>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contents</a>

<?php include 'includes/footer.php'; ?>