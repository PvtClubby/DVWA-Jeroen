<?php
require_once("connectdb.php");

if (!array_key_exists("username", $_SESSION)) {
    header("Location: /login.php");
    header("Cache-Control: no-store");
    die();
}

ob_start();

?>

    <h1>Welcome</h1>

    <p>Please use the <a href="/pages/choices.php">Choices</a> page for the attacks what you want to practice</p>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once("template.php");