<?php

require '../private/validation-functions.php';
require '../private/process-form.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Evil Corp.&trade; Henchmen Application</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- JS For Range Slider -->
    <script src="js/main.js" defer></script>
  </head>
  <body class="bg-black container px-3 py-5">
    <main class="row justify-content-center align-items-center min-vh-100">
        <section class="col-md-10 p-5 rounded border bg-dark border-secondary text-light">
            <h1 class="fw-light text-center">Evil Corp.&trade; Henchmen Application</h1>
            <p class="lead text-center">Welcome to Evil Corp.&trade;, where dastardly dreams meet career opportunities!</p>
            <p class="mb-5">We understand that being a henchperson is more than just a job - it's a calling. Whether you're a master of mischief, a pro at pushing big red buttons, or someone who just wants to look cool guarding a secret lair, we want you on our team.</p>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                
                <section class="my-5">
                    <h2 class="fw-light">Account Creation</h2>

                    <!-- Text Input (Name) -->
                    <div class="mb-4">
                        <!-- If there's an error message, we'll display right by the input the user needs to fix. -->
                         <?php if ($message_name != '') echo $message_name; ?>
                         <label for="name" class="form-label">Full Name:</label>
                         <input type="text" id="name" name="name" placeholder="Robin Banks" class="form-control" value="<?= $name; ?>">
                         <p class="form-text text-light">Enter your full name as it appears on your evil henchperson license or brith certificate. Pseudonyms (e.g. "The Crusher", "Brutal Brutus", or "Dave") can be added later.</p>
                    </div>

                    <!-- Email Input -->
                     <div class="mb-4">
                        <?php if ($message_email != '') echo $message_email; ?>
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="email" id="email" name="email" placeholder="example@evilcorp.com" value="<?= $email; ?>" class="form-control">
                        <p class="form-text text-light">Enter a valid email address that you check frequently - evil plans wait for no one.</p>
                     </div>

                    <!-- Phone Input -->
                     <div class="mb-4">
                        <?php if ($message_phone != '') echo $message_phone; ?>
                        <label for="phone" class="form-label">Phone Number:</label>
                        <input type="phone" name="phone" id="phone" placeholder="123 456 7890" class="form-control" value="<?= $phone; ?>">
                        <p class="form-text text-light">Provide a valid ten-digit number where we can reach you. Carrier pigeons are no longer accepted after the law suit.</p>
                     </div>

                    <!-- Date Input (DOB) -->
                     <div class="mb-4">
                        <?php if ($message_dob != '') echo $message_dob; ?>
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="form-control" value="<?= $dob; ?>" aria-describedby="dob-help">
                        <p class="form-text text-light" id="dob-help">Enter your date of birth. This helps us confirm you're old enough for hazardous henching.</p>
                     </div>

                    <!-- Password Creation -->
                     <div class="mb-4">
                        <?php if ($message_password != '') echo $message_password; ?>
                        <label for="password" class="form-label">Secret Password:</label>
                        <input type="text" id="password" name="password" class="form-control" value="<?= $password; ?>">
                        <p class="form-text text-light">Choose a strong password, with:</p>
                        <ul class="form-text text-light">
                            <li>a minimum of 8 characters</li>
                            <li>at least one lowercase letter</li>
                            <li>at least one uppercase letter</li>
                            <li>at least one number</li>
                            <li>at least one of the following characters: !@#$%^&*</li>
                        </ul>
                        <p class="form-text text-light">Avoid using easy-to-guess passwords, like "password123" or "evil4life".</p>
                     </div>

                    <!-- Password Check -->
                     <div class="mb-4">
                        <?php if ($message_password_check != '') echo $message_password_check; ?>
                        <label for="password-check" class="form-label">Secret Password (Again):</label>
                        <input type="text" id="password-check" name="password-check" class="form-control" value="<?= $password_check; ?>">
                        <p class="form-text text-light">Re-enter your password to confirm. Even the most diabolical minds make typos sometimes.</p>
                    </div>
                </section>

                <section class="my-5">
                    <h2 class="fw-light">Qualifications</h2>

                    <!-- Number Input (Years of Experience) -->
                     <div class="mb-4">
                        <?php if ($message_experience != "") echo $message_experience; ?>
                        <label for="experience" class="form-label">Years of Evil Experience:</label>
                        <input type="number" id="experience" name="experience" class="form-control" step="1" min="0" max="60" aria-describedby="experience-help" value="<?= $experience; ?>">
                        <p id="experience-help" class="form-text">Round to the nearest whole number between 0 and 60.</p>
                     </div>

                    <!-- 
                        Datalist (Location Preference) 
                     
                        a <datalist> is a great form control when we want to provide suggestions for the user without limiting their input. It behaves like a combination of a text field and a dropdown menu: users can either choose from a list of suggested values or type in something completely custom.

                        Because users can submit anything (not just values from the list), we should still validate their input the same way we would for a regular text input.
                     -->

                                         <div class="mb-4">
                        <?php if (!empty($message_region)) echo $message_region; ?>

                        <label for="region" class="form-label">Preferred Global Region for Assignments:</label>
                        <input list="region-options" id="region" name="region" class="form-control"
                            value="<?php echo htmlspecialchars($region ?? ''); ?>" aria-describedby="region-help">

                        <datalist id="region-options">
                            <option value="Subterranean Bunkers (Europe)">
                            <option value="Volcano Islands (Pacific)">
                            <option value="Abandoned Arctic Labs">
                            <option value="Urban Roofscapes (Night Only)">
                            <option value="Anywhere with Excellent Wi-Fi">
                        </datalist>

                        <p id="region-help" class="form-text text-light">Choose from our suggested evil deployment zones—or enter your own. We respect evil flexibility.</p>
                    </div>


                    <!-- Radio Buttons (Department) -->
                     <fieldset class="mb-4">
                        <legend class="fs-5">Which department are you applying for?</legend>

                        <?php if ($message_department != "") echo $message_department; ?>

                        <div class="form-check">
                            <input type="radio" id="traps" name="department" value="traps" class="form-check-input" <?php if (isset($department) && $department === "traps") echo "checked"; ?>>
                            <label for="traps" class="form-check-label">Trap Setting</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" id="doomsday" name="department" value="doomsday" class="form-check-input" <?php if (isset($department) && $department === "doomsday") echo "checked"; ?>>
                            <label for="doomsday" class="form-check-label">Doomsday Device Maintenance</label>
                        </div>
                        
                        <div class="form-check">
                            <input type="radio" id="monologue" name="department" value="monologue" class="form-check-input" <?php if (isset($department) && $department === "monologue") echo "checked"; ?>>
                            <label for="monologue" class="form-check-label">Hero Monologue Intrusion</label>
                        </div>
                        
                        <div class="form-check">
                            <input type="radio" id="it" name="department" value="it" class="form-check-input" <?php if (isset($department) && $department === "it") echo "checked"; ?>>
                            <label for="it" class="form-check-label">IT Help Desk</label>
                        </div>
                     </fieldset>

                    <!-- Checkboxes (Training) -->
                     <fieldset class="mb-4">
                        <legend class="fs-5">Occupational Hazard Training (Optional)</legend>
                        <p>Which of the following occupational hazard training courses have you completed?</p>

                        <?php if ($message_training != "") echo $message_training; ?>

                        <div class="form-check">
                            <input type="checkbox" id="lava" value="lava" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("lava", $training)) echo "checked"; ?>>
                            <label for="lava" class="form-check-label">Open Lava Pits and You</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="sharks" value="sharks" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("sharks", $training)) echo "checked"; ?>>
                            <label for="sharks" class="form-check-label">Shark Tank Etiquette</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="lifting" value="lifting" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("lifting", $training)) echo "checked"; ?>>
                            <label for="lifting" class="form-check-label">Advanced Hench-Lifting Techniques</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="buttons" value="buttons" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("buttons", $training)) echo "checked"; ?>>
                            <label for="buttons" class="form-check-label">The Art of Not Touching Big Red Buttons</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="hostages" value="hostages" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("hostages", $training)) echo "checked"; ?>>
                            <label for="hostages" class="form-check-label">Hostage Handling: Dos and Don'ts</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="evacuation" value="evacuation" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("evacuation", $training)) echo "checked"; ?>>
                            <label for="evacuation" class="form-check-label">Collapsing Lair Evacuation Plans</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="retention" value="retention" name="training[]" class="form-check-input" <?php if (!empty($training) && in_array("retention", $training)) echo "checked"; ?>>
                            <label for="retention" class="form-check-label">Employee Retention: Surviving the Villain's Wrath</label>
                        </div>
                     </fieldset>

                    <!-- Range Slider (Likert) -->
                    <fieldset class="mb-4">
                        <?php if ($message_loyalty != "") echo $message_loyalty; ?>

                        <label for="loyalty" class="form-label">On a scale of 0 through 10, how loyal are you to the current Evil Overlord?</label>
                        <input type="range" id="loyalty" name="loyalty" class="form-range" min="0" step="1" max="10" value=<?= $loyalty; ?>>

                        <!-- This will let the user know what number they are choosing. It will be dynamically updated by JS (or PHP). -->
                        <p id="loyalty-value" class="form-text text-light text-center">
                            <span><?php echo $loyalty; ?></span>
                        </p>

                    </fieldset>

                    <!-- Dropdown (How did you hear about us?) -->
                     <div class="mb-4">
                        <?php if ($message_referral != "") echo $message_referral; ?>

                        <label for="referral" class="form-label">How did you head about us?</label>
                        <select name="referral" id="referral" class="form-select">
                            <option value="">-- Please Select --</option>
                            <option value="classified-ad" <?php if (isset($referral) && $referral === "classified-ad") echo "selected"; ?>>Craigslist (Evil Jobs Section)</option>
                            <option value="social-media" <?php if (isset($referral) && $referral === "social-media") echo "selected"; ?>>Lava Pit Showcase on TikTok</option>
                            <option value="word-of-mouth" <?php if (isset($referral) && $referral === "word-of-mouth") echo "selected"; ?>>Referral From Another Henchperson</option>
                            <option value="mixer" <?php if (isset($referral) && $referral === "mixer") echo "selected"; ?>>Villain Networking Mixer</option>
                            <option value="kidnapping" <?php if (isset($referral) && $referral === "kidnapping") echo "selected"; ?>>Kidnapped By Your Recruitment Team</option>
                            <option value="family" <?php if (isset($referral) && $referral === "family") echo "selected"; ?>>Family Tradition</option>
                            <option value="announcement" <?php if (isset($referral) && $referral === "announcement") echo "selected"; ?>>Villain's Death Ray Announcement</option>
                        </select>
                     </div>
                </section>

                <section class="my-5">
                    <h2 class="fw-light">Long Answer Question</h2>
                    <p>At Evil Corp.&trade;, we're not just evil doers – we're evil dreamers, too.</p>

                    <!-- Textarea (Long Answer Question) -->
                    <div class="mb-4">
                        <label for="evil-plan" class="form-label">In 255 characters or fewer, describe your most diabolical plan to date:</label>
                        <textarea name="evil-plan" id="evil-plan" class="form-control" placeholder="e.g., sharks with frickin' laser beams attached to their heads ..."><?php if ($evil_plan != "") echo $evil_plan; ?></textarea>
                    </div>
                </section>

                <!-- Submission -->
                 <div class="my-4">
                    <input type="submit" id="submit" name="submit" value="Create Account &amp; Apply" class="btn btn-warning">
                 </div>

                <p class="form-text text-light">Evil Corp.&trade; prides itself on being an equal opportunity employer. All goons, mooks, minions, lackeys, grunts, and flunkies are encouraged to apply. Remember: just because we're evil doesn't mean we can't be equal.</p>
            </form>
        </section>
    </main>
  </body>
</html>