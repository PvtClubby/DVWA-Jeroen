<?php
require_once ("vendor/autoload.php");

$path = pathinfo($_SERVER["SCRIPT_FILENAME"]);
if ($path["extension"] == "phtml") {
    header("Content-Type: text/html");
    require_once $_SERVER["SCRIPT_FILENAME"];
}
else {
    return FALSE;
}