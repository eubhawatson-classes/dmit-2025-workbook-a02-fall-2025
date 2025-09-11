<!doctype html>
<html lang="en">

<head>
  <!-- Required Meta Tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Comparison Operators, Logical Operators, Control Structures, & Loops</title>

  <!-- BS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body class="container text-center">
  <section class="row justify-content-center">
    <div class="col-lg-8">
      <h1 class="display-5 my-5">Comparison Operators, Logical Operators, Control Structures, & Loops</h1>

      <h2 class="display-6 my-5">Comparison Operators</h2>
      <p class="lead">Used to compare two values (e.g., <code>==</code>, <code>!=</code>, <code>&lt;</code>, <code>&gt;</code>), returning <code>true</code> or <code>false</code>.</p>

      <?php
        // This is an assignment statement; we're giving a variable a value.
        $x = 6;

        // With an IF statement, we can check to see if an expression is evaluated as TRUE; if it is, we can execute some code inside of a block. If not, that code will be ignored.
        if ($x == 6) {
          echo "<p>X is 6.</p>";
        }

        // This checks to see if these two things have the same values AND the same data type. It is stricter, but can help prevent weird data typing errors.
        if ($x === 6) {
          echo "<p>X has the same value and data type as 6.</p>";
        } 

        // We can also check to see if two values are NOT equal with the negation operator.
        if ($x != 5) {
          echo "<p>X is not equal to 5.</p>";
        }

        // In PHP, != can also be written as: <> 
        if ($x <> 4) {
          echo "<p>X is not equal to 4.</p>";
        }

        // Let's try a comparison operator! This is 'greater than'.
        if ($x > 5) {
          echo "<p>X is greater than 5.</p>";
        }

        // We can also see if a value is greater than or equal to another.
        if ($x >= 6) {
          echo "<p>X is greater than or equal to 6.</p>";
        }

        // Let's try 'less than' next!
        if ($x < 10) {
          echo "<p>X is less than 10.</p>";
        }

        // Now, 'less than or equal to'.
        if ($x <= 7) {
          echo "<p>X is less than or equal to 7.</p>";
        }
      ?>

      <h2 class="display-6 my-5">Logical Operators</h2>
      <p class="lead">Combine multiple conditions using <code>&amp;&amp;</code> (AND), <code>||</code> (OR), and <code>!</code> (NOT).</p>

      <?php
      
        // With the AND operator, all part of the statement must be TRUE.
        if ($x > 2 && $x < 10) {
          echo "<p>X is greater than 2 <strong>AND</strong> less than 10; both parts of this statement must be TRUE.</p>";
        }

        // With the OR operator, at least one part of the statement must be TRUE.
        if ($x > 2 || $x < 4) {
          echo "<p>X is greater than 2 <strong>OR</strong> less than 4; at least one part of this statement must be TRUE,</p>";
        }

        // With XOR (exclusive OR), exactly one part of the statement must be TRUE.
        if ($x > 2 XOR $x < 10) {
          echo "<p>X is either greater than 2 <strong>OR</strong> less than 10; only one of these statements is allowed to be true.</p>";
        }

      ?>

      <h2 class="display-6 my-5">Control Structures</h2>
      <p class="lead">Direct the flow of your program based on conditions.</p>

      <h3 class="my-3">Nested If/Else Block</h3>
      <p class="lead">An <code>if</code> or <code>else</code> statement placed inside another to check multiple layers of conditions.</p>

      <?php
      
        $x = (string) "This variable is a string now.";

        // If we want to use a string variable later but do not have an initial value for it, we can initialise it as an empty string with empty double quotes.
        // $message = "";

        if (is_numeric($x)) {      
          if ($x === 5) { // This should be FALSE.
            $message = "<p>X is 5.</p>";
          } elseif ($x === 6) { // This should be FALSE.
            $message = "<p>X is 6.</p>";
          // } elseif (is_numeric($x)) { // This should be FALSE.
          //   // is_numeric() -> This method returns TRUE or FALSE depending upon whether the argument passed into it is a number or not a number.
          //   $message = "<p>X is a number.</p>";
          } elseif ($x < 10 || $x > 12) {
            // If I wanted to check to see within a single condition if this value is numeric and is less than 10 or greater than 12, I could write: elseif ( is_numeric($x) && ($x < 10 || $x > 12) )
            $message = "<p>X is less than 10 or greater than 12.</p>";
          } 
          else {
            $message = "<p>X is not equal to 5, equal to 6, or a number.</p>";
          }
      } else {
        $message = "<p>X is not numeric.</p>";
      }

        // isset() -> This method checks to see if a variable exists, is initialised, or assigned a value. It returns TRUE or FALSE.
        if (isset($message)) {
          echo $message;
        }
      
      ?>

      <h3 class="my-3">Switch Statement</h3>
      <p class="lead">A cleaner way to check a single variable against many possible values using <code>switch</code> and <code>case</code>.</p>

      <?php

        // With switch statements, we start with some sort of condition that we're checking.
        switch (TRUE) {

          // Next, we present a case (i.e. a condition that we're checking).
          case $x === 5:
            $message = "<p>X is 5.</p>";
            // If the condition is met, we need to 'break' in order to exit the structure. If we do not break, then we do not exit the switch statement when we should and we keep evaluating subsequent cases.
            break;

          case $x === 5:
            $message = "<p>X is 6.</p>";
            break;

          // Up above, we used an OR logical operator to check two conditions. We'll use a 'fall0-through' case to evaluate multiple things at once.
          case $x < 10:
          case $x > 12:
            // This message will be used for either of our two possibilities. 
            $message = "<p>X is less than 10 or greater than 12.</p>";
            break;

          // If none of our cases are TRUE, we need a default case (equivalent to ELSE).
          default: 
            $message = "<p>X is not equal to 5, equal to 6, or a number.</p>";
            break;
        }

        echo $message;
      
      ?>

      <h3 class="my-3">PHP 8+ Alternative: <code>match</code> Expression</h3>
      <p class="lead">A more concise and safer alternative to <code>switch</code>, introduced in PHP&nbsp;8, using the <code>match</code> expression.</p>

      <?php
      
        /**
         * This is a match expression. It return a value, uses strict comparisons, and has concise syntax; however, it is functionally the same as our IF/ELSEIF/ELSE structures and switch statements.
         * 
         * Whater you put in the parenthesis is the thing you're 'matching' against each arm. It could be a variable, the literal TRUE, or even a function call.
         * 
         * Each line inside of the curly braces is called an arm. An arm has two part, separated by the arrow => :
         * 
         * 1. condition (or pattern) on the left
         * 2. result expression on the right
         * 
         * As soon as PHP finds the first arm whose condition "matches", it returns that arm's result and exits the structure.
         */

        $message = match (TRUE) {
          $x === 5           => "<p>X is 5.</p>",
          $x === 6           => "<p>X is 6.</p>",
          $x < 10, $x > 12   => "<p>X is less than 10 or greater than 12.</p>",
          default            => "<p>X is not equal to 5, equal to 6, or a number.</p>",
        };

        echo $message;

      ?>

      <h2 class="display-6 my-5">Loops</h2>
      <p class="lead">Repeat blocks of code while a condition is <code>true</code>.</p>

      <h3 class="my-3">While Loop</h3>
      <p class="lead">Repeats code as long as a condition stays <code>true</code>, checking the condition <em>before</em> each run.</p>

      <?php
      
        /**
         * Loops need at least three things to work properly (and not get stuck in an infinite loop):
         * 
         * 1. An initial value; this usually starts the counter for how  many times we've gone through a loop.
         * 
         * 2. Some sort of exit condition; if this condition is met, the interpreter will exit the loop.
         * 
         * 3. Some sort of change where the condition can approach FALSE; this is usually an increment (++) or a decrement (--).
         */


        $input = 1;

        // A while loop is a test-first (or pre-test) loop. This means we check the condition before hopping the loop itself.

        while ($input <= 5) {
          echo "<p>Times through the loop: $input</p>";
          $input++;
        }

      ?>

      <h3 class="my-3">Do/While Loop</h3>
      <p class="lead">Runs code <em>at least once</em>, then keeps looping if the condition is still <code>true</code>.</p>

      <?php
      
        // This is a test-last (or post-test) loop. This means that if we check the condition last, the loop will always execute at least once. 

        do {
          echo "<p>Times through the loop: $input</p>";
          $input++;
        } while ($input <= 10);

      ?>

      <h3 class="my-3">For Loop</h3>
      <p class="lead">Repeats code a specific number of times using a counter: <code>for (start; condition; update)</code>.</p>

      <?php
      
        // This is also a test-first (pre-test) loop. All three of our requirements for a loop are declared on the first line.

        for ($i = 0; $i < 10; $i++) {
          echo "<p>Current counter value: $i</p>";
        }

      ?>

      <h3 class="my-3">For Each Loop</h3>
      <p class="lead">Loops through each item in an array using <code>foreach ($array as $item)</code>.</p>

      <?php
      
        // For Each loops are special: They're made to work specifically with arrays. We'll use a superglobal array for this demo ($_SERVER). This array keeps tonnes of information about the server, its state, and other things related to PHP. 

        // NOTE: Do not do this in production; it may contain sensitive data you do not want to expose to the user. 

        foreach ($_SERVER as $key => $value) {
          echo "<p>$key : $value</p>";
        }

      ?>
    </div>
  </section>
</body>

</html>