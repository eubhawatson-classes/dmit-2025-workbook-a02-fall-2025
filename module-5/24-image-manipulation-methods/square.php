<?php

// We're creating an image object that is 512px by 512px large.
$image = imagecreate(512, 512);

// Creating the canvas is cool and all, but let's make a swatch to fill it with.
$green = imagecolorallocate($image, 2, 48, 32);

// When we created our canvas, it was completely empty. Here, we're filling it with our green, starting in the upper left-hand corner (the origin, 0, 0).
imagefill($image, 0, 0, $green);

// Now that we're done with our edits, let's output this! This tells the browser what MIME type we're dealing with. It says 'get ready for an image, not HTML'.
header("Content-type: image/png");

// This outputs our image in the form of a PNG file to the browser.
imagepng($image);

// Now that we have our output, we need to destroy the image object in order to free up resources for the server. 
imagedestroy($image);

?>