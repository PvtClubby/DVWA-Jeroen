<?php
require_once("../../connectdb.php");

if (!array_key_exists("username",$_SESSION)){
    die("What brings you here?");
} 

if (array_key_exists("difficulty", $_SESSION)) { //if the difficulty is easy, show fieasy.php
    if ($_SESSION["difficulty"] == "Easy"){
        require_once("./difficulties/fieasy.php");
    }

    if ($_SESSION["difficulty"] == "Medium"){ //if the difficulty is medium, show fimedium.php
        require_once("./difficulties/fimedium.php");
    }

    if ($_SESSION["difficulty"] == "Hard"){ //if the difficulty is hard, show fihard.php
        require_once("./difficulties/fihard.php");
    } 
    
} else {
    print ("Please select your difficulty first! ");
    ?> 
    <a href="/pages/settings.php">Click here to set your difficulty.</a>
    <?php

}