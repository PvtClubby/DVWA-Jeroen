<?php
require_once("../connectdb.php");

if (!array_key_exists("username", $_SESSION)) {
    header("Location: /auth/login.php");
    header("Cache-Control: no-store");
    die();
}

ob_start();

?>

<h1> Exercises </h1>

<p> Hello, Great that you would like to improve your attacking skils! </p>
<p> Please select one of the attacks you would like to practice: </p>

<p><a href ="/pages/bruteforce/bruteforce.php">Brute Forcing</a>.</p>
<p><a href ="/pages/fileinclusion/fileinclusion.php">File Inclusion</a>.</p>

<?php
$content = ob_get_contents();
ob_end_clean();
require_once("../template.php");