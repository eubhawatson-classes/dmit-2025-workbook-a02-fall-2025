<?php

$title = "Old Norse Calendar";
include 'includes/header.php';

// No matter what timezone our server is currently set to, this will get our server to automatically convert any timedates into the timezone we specify.
date_default_timezone_set("America/Edmonton");

$day = date("l");

?>

<p>Today is <?= $day; ?>.</p>
<p>In the Old Norse calendar, today was named: 

<?php

switch ($day) {
    case "Monday":
        echo " Moon's Day (Mánadagr) - named after the god Máni.</p>";
        break;
    case "Tuesday":
        echo " Tyr's Day (Týsdagr) - named after the god Tyr.</p>";
        break;
    case "Wednesday":
        echo " Odin's Day (Óðinsdagr) - named after the god Odin.</p>";
        break;
    case "Thursday":
        echo " Thor's Day (Þórsdagr) - named after the god Thor.</p>";
        break;
    case "Friday":
        echo " Freyja's Day (Freyjudagr) - named after the goddess Freyja.</p>";
        break;
    case "Saturday":
        echo " Saturn's Day (Laugardagr) - named after the planet Saturn.</p>";
        break;
    case "Sunday":
        echo " Sun's Day (Sunnudagr) - named after the goddess Sunna.</p>";
        break;
    default:
        echo " ... actually, I'm not sure what day it is!</p>";
        break;
}

?>


<a href="index.php" class="btn btn-outline-primary">Return to Table of Contentss</a>

<?php include 'includes/footer.php'; ?>