<?php

$title = "Banana Oatmeal Muffins";
include 'includes/header.php';
include 'includes/conversions.php';

// Based upon what number the user gave us, we can now set our multipler or coefficient for our ingredient quantities. We'll use a filter here, which just double-checks to make sure that whatever number they gave us was an integer. This is an important step because the user can muck around with any values in the query string.
$recipe_yield = filter_input(
    INPUT_GET,
    'servings',
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'default'   => 12,
            'min_range' => 1,
        ]
    ]
);

// The base recipe is for 12 muffins, so we'll figure out out multiplier by dividing this by 12.
$multiplier = $recipe_yield / 12;

// Our oven temperature is either 325ºF or 165ºC, depending upon what the user selects. We'll use Celsius as our default.
$temperature_units = isset($_GET['temperature']) ? htmlspecialchars($_GET['temperature']) : 'C';
$oven_temperature = ($temperature_units == 'C') ? '165&deg;C' : '325&deg;F';

?>

<!-- Introduction, Form & Input -->
<section class="mb-5">
    <div class="card shadow-sm">
        <h2 class="card-header text-bg-dark fw-light">Recipe Settings</h2>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="p-5">
            <!-- Recipe Yield -->
             <div class="mb-3">
                <label for="servings" class="form-label">How many muffins would you like to make?</label>
                <input type="number" name="servings" id="servings" min="1" class="form-control" value="<?= htmlspecialchars($recipe_yield); ?>" required>
                <p class="form-text">The original recipe makes 12 muffins. Enter any positive number to adjust the yield.</p>
             </div>

            <!-- Temperature -->
             <fieldset class="mb-3">
                <legend class="fs-5">Temperature Units</legend>

                <input type="radio" class="btn-check" name="temperature" id="temperature-c" value="C" <?php if ($temperature_units == 'C') echo 'checked'; ?>>
                <label for="temperature-c" class="btn btn-sm btn-outline-primary">Celsius</label>

                <input type="radio" class="btn-check" name="temperature" id="temperature-f" value="F" <?php if ($temperature_units == 'F') echo 'checked'; ?>>
                <label for="temperature-f" class="btn btn-sm btn-outline-primary">Fahrenheit</label>
             </fieldset>

            <hr class="my-4">

            <!-- Submit -->
             <input type="submit" name="submit" id="submit" value="Save Settings" class="btn btn-primary">
        </form>
    </div>
</section>

<!-- Ingredients -->
<section class="mb-5">
    <h2 class="mb-3">Ingredients</h2>

    <ul class="list-group">
        <?php foreach ($ingredients as $ingredient): ?>
            <li class="list-group-item">
                <?= round($ingredient['base_quantity'] * $multiplier, 2); ?>
                <?= $ingredient['unit']; ?>
                <?= $ingredient['name']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- Directions -->
 <section class="mb-5">
    <h2 class="mb-3">Directions</h2>

    <ol class="list-group list-group-numbered">
        <li class="list-group-item">Preheat the oven to <strong><?= $oven_temperature; ?></strong>. Line <strong><?= 12 * $multiplier; ?></strong> muffin cups with papers liners.</li>

        <li class="list-group-item">Beat sugar and butter with an electric mixer in a large bowl until smooth and creamy. Beat first egg into butter mixture until completely blended; beat in vanilla extract with remaining egg.</li>

        <li class="list-group-item">Mix bananas, milk, and cinnamon together in a separate bowl; stir into creamed butter mixture. Whisk flour, baking powder, baking soda, and salt together in a separate bowl; slowly stir into banana-butter mixture until batter is just mixed. Fold oats and walnuts into batter.</li>

        <li class="list-group-item">Scoop batter into the muffin cups using a large ice-cream scoop.</li>

        <li class="list-group-item">Bake in the preheated oven until a toothpick inserted in the centers of the muffins comes out clean, 25 to 35 minutes.</li>
    </ol>

    <p class="my-3"><strong>Recipe Yield</strong>: <strong><?= 12 * $multiplier; ?></strong> muffins.</p>
 </section>

<?php include 'includes/footer.php'; ?>