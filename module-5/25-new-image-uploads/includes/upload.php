<?php

$message = $message ?? "";
$img_title = $_POST['img-title'] ?? "";
$img_description = $_POST['img-description'] ?? "";

// BUG FIX: ['img-file]'] had a stray bracket.
if (isset($_POST['submit'], $_FILES['img-file']) && !empty($_FILES['img-file']['name'])) {

    $file_name = $_FILES['img-file']['name'];
    $file_temp_name = $_FILES['img-file']['tmp_name'];
    $file_size = $_FILES['img-file']['size'];

    // The $_FILES['img-file']['error'] value contains an error code indicating the status of the file upload. A value of 0 (which corresponds to the constant UPLOAD_ERR_OK) means that no errors occured.
    if ($_FILES['img-file']['error'] === 0) {

        // Next, let's grab the uploaded file's extension (ex. .jpg, .web ...).
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Here's an array with all of the allowed file types. 
        $allowed = array('avif', 'jpg', 'jpeg', 'png', 'webp');

        if (in_array($file_extension, $allowed)) {

            // This checks to see if the file size is below 2MB (converted to bytes for PHP).
            if ($file_size < 2000000) {

                // This function will generate a unique filename for us, based upon microseconds. This helps us avoid data collisions on larger applications. It's important we do this rather than just keep a file's original name because otherwise we might run into issues like one user uploading 'doggy.jpg' and another user uploading and overwriting that file with a different 'doggy.jpg' at a later date.
                // BUG FIX: $file_extension was missing an underscore.
                $file_name_new = uniqid('', TRUE) . ".$file_extension";
                $file_destination = "images/full/$file_name_new";

                // Let's make sure the necessary directories (i.e. where we are going to store our images) actually exist and that PHP has read/write permissions.
                if (!is_dir('images/full/')) {
                    mkdir('images/full/', 0777, TRUE);
                }
                if (!is_dir('images/thumbs/')) {
                    mkdir('images/thumbs/', 0777, TRUE);
                }

                // Move the uploaded file out of the temporary files and into the images/full directory now that we know it exists.
                move_uploaded_file($file_temp_name, $file_destination);

                // Great! We've handled all of the file and directory requirements. Now, let's start handling the image itself. The GD Image library uses different functions for different file types. Let's see what kind of file we're working with and create a working image resource from it.
                switch ($file_extension) {
                    case 'avif':
                        // requires PHP 8.1+ with GD built with AVIF support
                        $src_image = imagecreatefromavif($file_destination);
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $src_image = imagecreatefromjpeg($file_destination);
                        break;
                    case 'png':
                        $src_image = imagecreatefrompng($file_destination);
                        break;
                    case 'webp':
                        $src_image = imagecreatefromwebp($file_destination);
                        break;
                    default:
                        exit("Unsupported file type. Please upload a AVIF, JPG, JPEG, PNG, or WebP file.");
                }

                /*
                    For fun, let's see what this switch case looks like as a match expression:

                    $src_image = match ($file_extension) {
                        'jpg', 'jpeg' => imagecreatefromjpeg($file_destination),
                        'png'         => imagecreatefrompng($file_destination),
                        'webp'        => imagecreatefromwebp($file_destination),
                        'avif'        => imagecreatefromavif($file_destination), // PHP 8.1+ with GD‑AVIF
                        default       => exit("Unsupported file type. Please upload a JPG, JPEG, PNG, WebP or AVIF file."),
                    };
                    
                    She's gorgeous. (✿◡‿◡)
                */

                // Let's see what its dimensions are.
                list($width_orig, $height_orig) = getimagesize($file_destination);

                /* 
                    We'll start with our full-sized image, which will be 720p. This means our full-sized image will be one of the following dimensions: 

                    1. Landscape: 1280 x 720
                    2. Portrait: 720 x 1280
                    3. Square: 720 x 720
                */

                if ($width_orig > $height_orig) {
                    // Landscape
                    $target_width = 1280;
                    $target_height = 720;
                } elseif ($height_orig > $width_orig) {
                    // Portrait
                    $target_width = 720;
                    $target_height = 1280;
                } else {
                    // Square
                    $target_width = 720;
                    $target_height = 720;
                }

                // We want the image to cover the new target area. Let's calculate our scaling factors. 
                $scale_x = $target_width / $width_orig;
                $scale_y = $target_height / $height_orig;
                $scale = max($scale_x, $scale_y);

                // Now that we have the scaling factor, let's make sure the image we have will cover the image we are going to create. 
                $new_width = ceil($width_orig * $scale);
                $new_height = ceil($height_orig * $scale);

                // Resize the image (stretch or squish it to fill the 'canvas' properly), while maintaining the correct aspect ratio.
                $temp_image = imagecreatetruecolor($new_width, $new_height);

                // We've got all of our calculations and figured out how large our full-sized image will be and how to place it. So, let's make it.
                imagecopyresampled($temp_image, $src_image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);

                // The aspect ratio of the orginal image and the image we're creating may not match up. This means some cropping may occur. We're going to try to minimise the damage by centring the image.
                $x_offset = ($new_width - $target_width) / 2;
                $y_offset = ($new_height - $target_height) / 2;

                // FINALLY, we can create our 720p image. 
                $final_image = imagecreatetruecolor($target_width, $target_height);
                imagecopy($final_image, $temp_image, 0, 0, $x_offset, $y_offset, $target_width, $target_height);

                switch ($file_extension) {
                    case 'avif':
                        imageavif($final_image, $file_destination);
                        break;
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($final_image, $file_destination);
                        break;
                    case 'png':
                        imagepng($final_image, $file_destination);
                        break;
                    case 'webp':
                        imagewebp($final_image, $file_destination);
                        break;
                    default:
                        exit("Unsupported file type. Please upload a JPG, JPEG, PNG, WebP or AVIF file.");
                }

                // Now we can move on to creating the thumbnail image. 
                $thumb_size = 512;
                $thumb_img = imagecreatetruecolor($thumb_size, $thumb_size);
                $smaller_side = min($width_orig, $height_orig);
                $src_x = ($width_orig - $smaller_side) / 2;
                $src_y = ($height_orig - $smaller_side) / 2;
                imagecopyresampled($thumb_img, $src_image, 0, 0, $src_x, $src_y, $thumb_size, $thumb_size, $smaller_side, $smaller_side);

                // Let's tell PHP where our thumbnail should go.
                $thumb_path = "images/thumbs/$file_name_new";

                switch ($file_extension) {
                    case 'avif':
                        imageavif($thumb_img, $thumb_path);
                        break;
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($thumb_img, $thumb_path, 100);
                        break;
                    case 'png':
                        imagepng($thumb_img, $thumb_path);
                        break;
                    case 'webp':
                        imagewebp($thumb_img, $thumb_path);
                        break;
                    default:
                        exit("Unsupported file type. Please upload a JPG, JPEG, PNG, WebP or AVIF file.");
                }

                // As always, we need to free up our memory resources. We currently have four working image objects. 
                imagedestroy($src_image);
                imagedestroy($temp_image);
                imagedestroy($final_image);
                imagedestroy($thumb_img);

                // Finally, we need to insert all of our metadata into the database so that our gallery script can find everything that it needs to function.
                $sql = "INSERT INTO gallery_prep (`title`, `description`, `filename`, `uploaded_on`) VALUES (?, ?, ?, NOW());";
                $statement = $connection->prepare($sql);
                $statement->bind_param("sss", $img_title, $img_description, $file_name_new);
                $statement->execute();

                $message = "Your image was successfully uploaded!";

            } else {
                $message .= "The file size limit is 2MB. Please upload a smaller image file.";
            }

        } else {
            $message .= "Your image must be one of the following file types: AVIF, JPG, JPEG, PNG, or WebP.";
        }

    } else {
        $message .= "There was an error with your file. Please make sure it isn't corrupted and try uploading again later.";
    }

} elseif (isset($_POST['submit'])) {
    // If the form is submitted without a file chosen ...
    $message .= "Please choose an image file before uploading.";
}

?>