<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Everything from $_POST is in an associative array. We'll map it to a simple indexed array instead, which will help us in a few of our steps below.
    $nums = array();

    for ($i = 1; $i <= $set_length; $i++) {
        $nums[] = $_POST["number-{$i}"];
    }

    // Sorts an array of numbers in ascending order.
    sort($nums);

    /* MEAN */

    // We could use $set_length to figure out how many items are in the data set, but we'll use count() instead.
    $count = count($nums);

    // Instead of looping through an array and adding each element to a running total, we can use this to calculate the sum of all elements in a given array. 
    $sum = array_sum($nums);

    $mean = round(($sum / $count), 2);


    /* MEDIAN 
    
        How we calculate the median depends upon whether the number of elements in the array is odd or even.

        If the array has an odd number of elements, then the median is simply the middle element. To calculate the index of the middle element, we first subtract 1 from the count to get the maximum index number, and then divide by 2 (and round down using floor()).

        On the other hand, if the array has an even number of elements, then the median is the average of the two middlemost elements. 
    */

        // floor(): rounds a number DOWN to the nearest whole number.
        $middle_index = floor(($count - 1) / 2);

        // Next, let's check to see if we have an odd or even number of things.
        if ($count % 2 == 0) { // even number of items
            // Here, we're adding the two middlemost items and dividing them by two for the mean.
            $median = ($nums[$middle_index] + $nums[$middle_index + 1]) / 2;
        } else { // odd number of items
            $median = $nums[$middle_index];
        }

    /* MODE */
    
    // This method take the array $nums and returns an associative array where the keys are the unique values from $nums, and the values are the count of how many times each value appears in the original array.
    $mode = array_count_values($nums);

    $mode = array_keys($mode, max($mode));

    // Because we cannot echo out an array, we'll implode (collapse) it into a string.
    $mode = implode(', ', $mode);

    /* FINAL OUTPUT FOR USER */
    
    echo "<div class=\"alert alert-info\" role=\"alert\"> \n
          <p>Your numbers were: " . implode(', ', $nums) . "</p> \n
          <p>Mean: {$mean}</p> \n
          <p>Median: {$median}</p> \n
          <p>Mode: {$mode}</p> \n
          </div>";
    

}

?>