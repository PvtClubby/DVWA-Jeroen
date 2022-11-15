<?php
require_once("connectdb.php");

if (!array_key_exists("username", $_SESSION)) {
    header("Location: /auth/login.php");
    header("Cache-Control: no-store");
    die();
}

ob_start();

?>

    <h1>Welcome</h1>

    <p>Please use the <a href="/pages/exercises.php">choices</a> page for the attacks what you want to practice</p>
    <p>Select the <a href ="/pages/settings.php">difficulty</a> of the exercises.</p>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once("template.php");