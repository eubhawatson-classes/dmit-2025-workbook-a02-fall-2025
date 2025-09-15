<?php

$title = "Temperature Converter";
include 'includes/header.php';

$temperature = isset($_POST['temperature']) ? trim($_POST['temperature']) : '';
$direction = isset($_POST['direction']) ? $_POST['direction'] : '';
$message = "";

?>

<p class="lead mb-5">Use the form below to convert temperature between Celsius and Fahrenheit.</p>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <!-- Temperature Value (Number) -->
     <div class="mb-4">
        <label for="temperature" class="form-label">Temperature:</label>
        <input type="number" id="temperature" name="temperature" value="<?= $temperature; ?>" required>
     </div>

    <!-- Direction (C to F || F to C) -->
     <fieldset class="mb-4">
        <legend>Conversion Type</legend>

        <div class="form-check">
            <input type="radio" id="c-to-f" name="direction" value="c-to-f" <?php echo $direction === 'c-to-f' ? 'checked' : ''; ?> class="form-check-input">
            <label for="c-to-f" class="form-check-label">Celsius to Fahrenheit</label>
        </div>

        <div class="form-check">
            <input type="radio" id="f-to-c" name="direction" value="f-to-c" <?php echo $direction === 'f-to-c' ? 'checked' : ''; ?> class="form-check-input">
            <label for="f-to-c" class="form-check-label">Fahrenheit to Celsius</label>
        </div>
     </fieldset>

    <!-- Submit -->
     <input type="submit" name="submit" id="submit" value="Convert" class="btn btn-primary mb-5">
</form>

<?php

if (isset($_POST['submit'])) {
    // We'll start with some super basic validation.
    if ($temperature === '') { // is $temperature present?
        $message = "<p class=\"text-danger fs-2\">Please enter a temperature value.</p>";
    } elseif (!is_numeric($temperature)) { // is $temperature a number?
        $message = "<p class=\"text-danger fs-2\">Please enter a valid number.</p>";
    } elseif (!in_array($direction, ['c-to-f', 'f-to-c'], TRUE)) { // is the radio button value valid?
        $message = "<p class=\"text-danger fs-2\">Please select a conversion type.</p>";
    } else { // if the user input passes validation
        $temperature = (float) $temperature;
        if ($direction === 'c-to-f') {
            $result = ($temperature * 9 / 5) + 32;
            $message = "<p class=\"text-success fs-2\">{$temperature}&deg;C is <strong>" . round($result, 2) . "&deg;F</strong>.</p>";
        } else {
            $result = ($temperature - 32) * 5 / 9;
            $message = "<p class=\"text-success fs-2\">{$temperature}&deg;F is <strong>" . round($result, 2) . "&deg;C</strong>.</p>";
        }
    }

    echo $message;

}

?>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contents</a>

<?php include 'includes/footer.php'; ?>