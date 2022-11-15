<?php
require_once("../../connectdb.php");

if (!array_key_exists("username",$_SESSION)){
    die("What brings you here?");
} 



if (array_key_exists("difficulty", $_SESSION)) {
    if ($_SESSION == "Easy"){

    }

    if ($_SESSION == "Medium"){

    }

    if ($_SESSION == "Hard"){

    }
}

ob_start();

?>

<h1> Brute Force </h1>

<p> test </p>
<p> test </p>


<?php
$content = ob_get_contents();
ob_end_clean();
require_once("../../template.php");