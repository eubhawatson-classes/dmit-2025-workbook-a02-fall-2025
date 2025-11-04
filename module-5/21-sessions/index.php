<?php

// In order to start a browser session, we need to call this function. If there already is a session going and we want access to it, we need to call this function.
session_start();

if (isset($_POST['forget'])) {
    session_unset(); // removes $_SESSION variables
    session_destroy(); // closes the current $_SESSION
    header("Refresh:0");
}

if (isset($_POST['username'])) {
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bootstrap demo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="bg-secondary">
    <main class="row justify-content-center align-items-center min-vh-100 p-3">
        <section class="col bg-white rounded p-5">
            <?php if (!isset($_SESSION['username'])) : ?>
            <!-- Here, we'll present the form to the user if they haven't already given us their name. -->
            <h1 class="mb-3 fw-normal h3">This could be the start of something wonderful.</h1>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <div class="my-5">
                    <label for="username" class="form-label">What's your name?</label>
                    <input type="text" id="username" name="username" placeholder="Jack Pott" class="form-control" required>
                </div>

                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Let's do it!">
            </form>
            <?php else: ?>
                <!-- If the user has given us their name, we will greet them with it. -->
                <h1 class="mb-3 fw-normal h3">Hello, <?= $_SESSION['username']; ?>!</h1>
                <p class="lead text-muted">It's good to see you.</p>
                <p>It's currently <?= date("l"); ?> at <?= date("h:i:sa"); ?>.</p>
            <?php endif; 

                // If the user has visited the page before, we will echo out the last time they were here.
                if (isset($_SESSION['last-time'])) : ?>
                    <p>The last time we saw each other was <?= $_SESSION['last-time']; ?>.</p>
                <?php endif;
            
                // Let's go a bit further by storing some datetime information in the $_SESSION.
                $_SESSION['last-time'] = date("Y/m/d h:i:sa");

                // Finally, if the user has given us their name, how might they return to the beginning state? We'll give them the option to wipe their session and be 'forgotten'.
                if (isset($_SESSION['username'])) : ?>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <input type="submit" id="forget" name="forget" value="Forget me." class="btn btn-danger mt-5">
                    </form>

                <?php endif; ?>
        </section>
    </main>
  </body>
</html>