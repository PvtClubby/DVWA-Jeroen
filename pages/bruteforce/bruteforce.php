<?php
require_once("../../connectdb.php");

if (!array_key_exists("username",$_SESSION)){
    die("What brings you here?");
} 

if (array_key_exists("difficulty", $_SESSION)) {
    if ($_SESSION["difficulty"] == "Easy"){
        require_once("./difficulties/beasy.php");
    }

    if ($_SESSION["difficulty"] == "Medium"){
        require_once("./difficulties/bmedium.php");
    }

    if ($_SESSION["difficulty"] == "Hard"){
        require_once("./difficulties/bhard.php");
    } 
    
} else {
    print ("Please select your difficulty first! ");
    ?> 
    <a href="/pages/settings.php">Click here to set your difficulty.</a>
    <?php

}