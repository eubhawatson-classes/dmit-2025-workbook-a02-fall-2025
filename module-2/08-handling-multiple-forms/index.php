<?php

// When you submit a form, you wipe out any data that was previously in $_GET or $_POST. One way to make sure you retain a value (like the number of terms in a data set) is to use a hidden input. We'll do this here – however, that also means the user's data set length can come from multiple locations.

switch (TRUE) {
    case isset($_GET['set-length']):
        $set_length = htmlspecialchars($_GET['set-length']);
        break;
    case isset($_POST['post-set-length']):
        $set_length = htmlspecialchars($_POST['post-set-length']);
        break;
    default:
        $set_length = '';
        break;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mean, Median, &amp; Mode Calculator</title>

    <!-- BS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <main class="container my-5">
        <section class="row justify-content-center">
            <h1 class="text-center mb-5">Mean, Median, &amp; Mode Calculator</h1>

            <div class="row">
                <!-- Introduction & Instructions -->
                <div class="col-md-6">
                    <aside class="card">
                        <div class="card-header bg-info">
                            <h2 class="card-title">What are Mean, Median, and Mode?</h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-4 text-body-secondary">The mean, median, and mode are different ways of figuring out the 'centre', or a 'typical' data point in a given set of numbers.</p>

                            <dl>
                                <dt>Mean</dt>
                                <dd>The 'average' number; found by adding all data points and dividing by the number of data points.</dd>

                                <dt>Median</dt>
                                <dd>The 'middle' number; found by ordering all data points and picking out the one in the middle.</dd>

                                <dt>Mode</dt>
                                <dd>The most frequent number, or the number that occurs the highest number of times in a given set.</dd>
                            </dl>
                        </div>
                    </aside>
                </div> <!-- end of .col -->

                <!-- $_GET Form -->
                <div class="col-md-6">

                <!-- We're including our processing logic here so that when it echos out all of the final calculations, the user will see them at the top. -->
                <?php include 'process.php';?>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="mb-5">
                        <div class="mb-3">
                            <label for="set-length" class="form-label">How many numbers are in your data set?</label>
                            <input type="number" name="set-length" id="set-length" class="form-control" value="<?= $set_length; ?>">
                        </div>

                        <input type="submit" name="submit-get" id="submit-get" class="btn btn-info" value="Generate Form">
                    </form>
                
                <?php if ($set_length != '') : ?>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                        <!-- Hidden Value -->
                         <input type="hidden" name="post-set-length" id="post-set-length" value="<?= $set_length; ?>">

                         <?php 
                         
                         // This loop will generate labels and inputs for each number in the user's data set.

                         for ($i = 1; $i <= $set_length; $i++) {
                            $value = isset($_POST["number-{$i}"]) ? htmlspecialchars($_POST["number-{$i}"]) : '';

                            echo "<div class=\"mb-3\"> \n";
                            echo "<label for=\"number-{$i}\" class=\"form-label\">Enter Number {$i}</label> \n";
                            echo "<input type=\"number\" id=\"number-{$i}\" name=\"number-{$i}\" value=\"{$value}\" class=\"form-control\"> \n";
                            echo "</div> \n";
                         } 
                         
                         ?>

                         <input type="submit" name="submit-post" id="submit-post" value="Calculate" class="btn btn-info my-4">
                    </form>

                <?php endif; ?>

                </div> <!-- end of .col -->
            </div>
        </section>
    </main>
  </body>
</html>