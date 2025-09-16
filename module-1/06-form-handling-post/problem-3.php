<?php

$title = "Vowel Counter";
include 'includes/header.php';

/*
Write a program that takes a string input from the user and counts the number of vowels (a, e, i, o, u) in it.

Bonus Question:

    Some English words do not have any of the standard vowels (a, e, i, o, u), but do have a 'y' (ex. any, why, my, sky ...).

    Extend your program so that it looks for each word that contains no standard vowel, counts every 'y' in that word, and prints the total number vowels with 'y' words added. 
*/

$user_text = isset($_POST['user-text']) ? $_POST['user-text'] : '';
$standard_count = 0;
$y_count = 0;

// This is an alternative to `isset($_POST['submit'])`.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Our first step is normalisation. We'll convert everything to lowercase so that out script doesn't discriminates between cases (ex. e and E, or a and A).
    $text = mb_strtolower(trim($user_text), 'UTF-8');

    // str_split() -> converts each character in a string to an item within a simple indexed array. We will then take this array and loop through it, checking to see if each character is a vowel.
    $char_array = str_split($text);

    $vowels = ['a', 'e', 'i', 'o', 'u'];

    foreach ($char_array as $char) {

        if (in_array($char, $vowels, TRUE)) {
            // If the character in question is a vowel, we'll increase our vowel counter.
            $standard_count++;
        }
    }

    // str_word_count() -> This can do a couple of things, including taking a string and returning the number of words in it ($text, 0) or taking a string and returning an array where each item is a word ($text, 1). We are doing the latter.
    $words = str_word_count($text, 1);

    /**
     * Now, we've got to check two things: 
     * 
     * 1. Is there a standard vowel in each word?
     * 2. If there isn't, is there a 'y'? 
     */

    // This loops through our array of words and lets us examine one word at a time.
    foreach ($words as $word) {
        // Let's start by defining a boolean to act as a switch for us.
        $has_vowel = FALSE;

        // Now, let's look at each individual character inside of our word.
        foreach ($vowels as $vowel) {
            // This looks for a vowel in our word.
            if (strpos($word, $vowel) !== FALSE) {
                // If a vowel is found, we flip our switch, exit this inner loop (looking at each individual character in a given word) and move onto the next word.
                $has_vowel = TRUE;
                break;
            }
        }

        // If there is no vowel found in our word ...
        if (!$has_vowel) {
            // ... we will increment our 'y-word' counter.
            $y_count++;
        }

    }
}

?>

<p class="lead mb-5">Enter a word, phrase, or block of text below to count how many vowels appear in it.</p>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mb-5">
    <div class="mb-3">
        <label for="user-text" class="form-label">Your text:</label>
        <textarea name="user-text" id="user-text" class="form-control"><?php echo $user_text; ?></textarea>
    </div>

    <div class="mb-3">
        <input type="submit" name="submit" id="submit" value="Check Vowel Count" class="btn btn-primary">
    </div>
</form>

<!-- This is alternative syntax. It opens an 'if' block, then lets us dive into another programming language. -->
<?php if ($user_text != '') : ?>

    <div class="row row-cols-2 mb-5">
        <!-- Standard Vowel Count -->
         <div class="alert alert-success col" role="alert">
            <p class="mb-0"><strong>Standard Vowels:</strong> <?= $standard_count; ?></p>
         </div>

        <!-- Y-Words Count -->
         <div class="alert alert-warning col" role="alert">
            <p class="mb-0"><strong>Y-words:</strong> <?= $y_count; ?></p>
         </div>
    </div>

<!-- With alternative syntax, we must always end the if block by hopping back into PHP. -->
<?php endif; ?>

<a href="index.php" class="btn btn-outline-primary">Return to Table of Contents</a>

<?php include 'includes/footer.php'; ?>