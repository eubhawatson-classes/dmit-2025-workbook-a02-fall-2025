<?php

$page_title = "Image Gallery";
$introduction = "Welcome to our gallery of images, uploaded by users just like you. To add more images to the gallery, click the link above to be taken to the home page.";
$active = "gallery";
include 'includes/header.php';

$query = "SELECT * FROM gallery_prep ORDER BY `uploaded_on` DESC;";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) : ?>

<section class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

<?php 

// Let's loop through all of the records we retrieved from the database.
while ($row = mysqli_fetch_array($result)) {
    $id = $row['image_id'];
    $title = $row['title'];
    $description = $row['description'];
    $filename = $row['filename'];
    $uploaded_on = $row['uploaded_on'];
?>

<!-- Thumbnail Card -->
<div class="col">
    <div class="card p-0 shadow-sm">
        <img src="images/thumbs/<?= $filename; ?>" alt="<?= $description; ?>" class="card-img-top">
        <div class="card-body">
            <h2 class="fs-5"><?= $title; ?></h2>
            <p class="card-text">Added on <?= $uploaded_on; ?></p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?= $id; ?>">View</button>
        </div> <!-- end of .card-body -->
    </div> <!-- end of .card -->
</div> <!-- end of .col -->

<!-- Modal Window -->
<div class="modal fade" id="modal-<?= $id; ?>" tabindex="-1" aria-hidden="true">
    <!-- We can use the .modal-lg or .modal-xl class here to make the window act a little more like a lightbox. -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title display-6"><?= $title; ?></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Full-Sized Image -->
        <div class="text-center">
            <img src="images/full/<?= $filename; ?>" alt="<?= $description; ?>" class="img-fluid">
        </div>
        <p class="my-5"><?= $description; ?></p>
        <p>Added on <?= $uploaded_on; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div> <!-- end of .modal-footer -->
    </div> <!-- end of .modal-content -->
  </div> <!-- end of .modal-dialog -->
</div> <!-- end of .modal -->

<?php 
    } // end of while loop 
?>

</section>

<?php else: ?>

<section class="row justify-content-center">
    <div class="col-md-6">
        <h2>Oops!</h2>
        <p>We weren't able to find any images in our gallery – but this is where you come in. Return to the <a href="index.php">upload page</a> to submit your own.</p>
    </div>
</section>

<?php 
    endif;

    include 'includes/footer.php';     
?>