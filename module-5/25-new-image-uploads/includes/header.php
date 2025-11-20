<?php
// Establish a connection to the database.
require_once dirname(__DIR__, 3) . '/data/connect.php';
$connection = db_connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title; ?></title>

    <!-- BS Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex min-vh-100 flex-column justify-content-center">
    <main class="container">
        <section class="row justify-content-center my-5">
            <div class="col-md-6">
                <!-- Page Navigation -->
                 <nav class="my-5 pb-5 border-bottom">
                    <ul class="nav nav-pills">
                        <!-- Index Link -->
                        <li class="nav-item">
                            <?php if ($active == "index") : ?>
                                <a href="#" class="nav-link active" aria-current="page">Upload Image Files</a>
                            <?php else: ?>
                                <a href="index.php" class="nav-link">Upload Image Files</a>
                            <?php endif; ?>
                        </li>
                        <!-- Gallery Link -->
                        <li class="nav-item">
                            <?php if ($active == "gallery") : ?>
                                <a href="#" class="nav-link active" aria-current="page">View Gallery Page</a>
                            <?php else: ?>
                                <a href="gallery.php" class="nav-link">View Gallery Page</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                 </nav>

                 <h1 class="display-4"><?= $page_title; ?></h1>
                 <p class="lead mb-5"><?= $introduction; ?></p>
            </div>
        </section>