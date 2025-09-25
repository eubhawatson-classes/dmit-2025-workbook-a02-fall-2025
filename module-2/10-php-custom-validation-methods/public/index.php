<?php

require '../private/validation-functions.php';
require '../private/process-form.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Evil Corp.&trade; Henchmen Application</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- JS For Range Slider -->
    <script src="js/main.js" defer></script>
  </head>
  <body class="bg-black container px-3 py-5">
    <main class="row justify-content-center align-items-center min-vh-100">
        <section class="col-md-10 p-5 rounded border bg-dark border-secondary text-light">
            <h1 class="fw-light text-center">Evil Corp.&trade; Henchmen Application</h1>
            <p class="lead text-center">Welcome to Evil Corp.&trade;, where dastardly dreams meet career opportunities!</p>
            <p class="mb-5">We understand that being a henchperson is more than just a job - it's a calling. Whether you're a master of mischief, a pro at pushing big red buttons, or someone who just wants to look cool guarding a secret lair, we want you on our team.</p>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                
                <section class="my-5">
                    <h2 class="fw-light">Account Creation</h2>

                    <!-- Text Input (Name) -->
                    <div class="mb-4">
                        <!-- If there's an error message, we'll display right by the input the user needs to fix. -->
                         <?php if ($message_name != '') echo $message_name; ?>
                         
                    </div>

                    <!-- Email Input -->

                    <!-- Phone Input -->

                    <!-- Date Input (DOB) -->

                    <!-- Password Creation -->

                    <!-- Password Check -->
                </section>

                <section class="my-5">
                    <h2 class="fw-light">Qualifications</h2>

                    <!-- Number Input (Years of Experience) -->

                    <!-- Datalist (Location Preference) -->

                    <!-- Radio Buttons (Department) -->

                    <!-- Checkboxes (Training) -->

                    <!-- Range Slider (Likert) -->

                    <!-- Dropdown (How did you hear about us?) -->

                    <!-- Textarea (Long Answer Question) -->
                </section>

                <!-- Submission -->
                 <div class="my-4">
                    <input type="submit" id="submit" name="submit" value="Create Account &amp; Apply" class="btn btn-warning">
                 </div>

                <p class="form-text text-light">Evil Corp.&trade; prides itself on being an equal opportunity employer. All goons, mooks, minions, lackeys, grunts, and flunkies are encouraged to apply. Remember: just because we're evil doesn't mean we can't be equal.</p>
            </form>
        </section>
    </main>
  </body>
</html>