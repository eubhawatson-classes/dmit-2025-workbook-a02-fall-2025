<?php

$first_password = $_POST['first-password'] ?? "";
$second_password = $_POST['second-password'] ?? "";
$is_match = NULL;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here, we'll hash the first password (as we normally would when the user first registers for an account). The current default encryption algorithm for PHP is BCRYPT.
    $first_hash = password_hash($first_password, PASSWORD_DEFAULT);

    // While we don't need to hash the second password, we will anyway (just to show that different values result in different hashes, and that even the same values result in different hashes).
    $second_hash = password_hash($second_password, PASSWORD_DEFAULT);

    // This compares the second password (which is in plain text) with the hash generated from the first password. This method will return either TRUE (if it's a match) or FALSE (if it's not a match).
    $is_match = password_verify($second_password, $first_hash);
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Password Hashing Demo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class="container">
    <main class="row justify-content-center my-5">
        <section class="col col-md-10 col-lg-8">
            <h1 class="text-center display-6">How does password encryption work?</h1>
            <p class="lead">Enter a password below to see how hashing works. Then, enter another to see if it matches the first.</p>

            <?php if (!is_null($is_match)) : ?>
                <div class="text-center my-3">
                    <p class="fs-4">When compared, PHP determined that <?= $is_match ? "yes, these passwords match!" : "no, these passwords do not match."; ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <div class="mb-3">
                    <label for="first-password" class="form-label">First Password</label>
                    <input type="text" name="first-password" id="first-password" value="<?= $first_password; ?>" class="form-control">
                    <p class="form-text">Enter a string, password, or phrase you'd like to test.</p>

                    <?php if ($first_password != "") : ?>
                    <div class="border border-warning rounded p-3">
                        <p class="form-text">For the first password, you entered: <?= $first_password; ?></p>
                        <p class="form-text">When encrypted, it produced the following hash: <?= $first_hash; ?></p>
                        <p class="form-text">In the real world, this password would be the one provided by the user during their account registration. It would then go through an encryption algorithm and the resulting hash would be stored in a secure database.</p>
                    </div>
                    <?php endif; ?>

                </div>

                <div class="mb-3">
                    <label for="second-password" class="form-label">Second Password</label>
                    <input type="text" name="second-password" id="second-password" value="<?= $second_password; ?>" class="form-control">
                    <p class="form-text">Now, enter another. This one can be identical or different to the one above.</p>

                    <?php if ($second_password != "") : ?>
                    <div class="border border-warning rounded p-3">
                        <p class="form-text">For the second password, you entered: <?= $second_password; ?></p>
                        <p class="form-text">When encrypted, it produced the following hash: <?= $second_hash; ?></p>
                        <p class="form-text">In the real world, this password would be what a user types when trying to log in. The PHP engine would then compare it to the hash stored in the database to see if it's statistically likely that the passwords are identical.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <input type="submit" name="submit" id="submit" value="Hash & Compare" class="btn btn-primary">
            </form>
        </section>
    </main>
  </body>
</html>