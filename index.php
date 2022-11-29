<?php
require_once("connectdb.php"); //Set connection with database.

if (!array_key_exists("username", $_SESSION)) { //if the username does not exist in database
    header("Location: /auth/login.php"); //readirect the user towards the login page.
    header("Cache-Control: no-store"); //The cache should not be stored or else the user will be redirected towards the login page.
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