<?php 

namespace Jeroen\Webserver\pages;

?>
<?php
require_once ("../connectdb.php");

if (!array_key_exists("username",$_SESSION)){ //check if a database user is logged in
    die("What brings you here?");
} 


if($_SERVER["REQUEST_METHOD"] == "POST"){ //if the server gets a POST request do:
    
    $difficulty=$_POST['difficulty']; //the post request will be difficulty value
    $alloweddifficulties = array('Easy', 'Medium', 'Hard'); //these difficulties are allowed
    if (!in_array($difficulty , $alloweddifficulties)){ //check if the POST value fits into the allowed difficulties
        die('That difficulty does not exist!');
    }

    $_SESSION["difficulty"] = $difficulty; //make a session with the difficulty value
}

if (array_key_exists("difficulty",$_SESSION)){ //check if the difficulty value is set 
    $difficulty = $_SESSION["difficulty"];  
} else { //value is not set, so make it Easy
    $difficulty = 'Easy';
}

ob_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choice Menu</title>

</head>
<body>
    <h1>Difficulty settings</h1>
    
    <p>Select your difficulty</p>
    <form action="" method="post">
    <input type="radio" name="difficulty" value="Easy" <?php echo ($difficulty == 'Easy' ? 'checked' : '');?> > Easy
    <p></p>
    <input type="radio" name="difficulty" value="Medium" <?php echo ($difficulty == 'Medium' ? 'checked' : '');?>> Medium
    <p></p>
    <input type="radio" name="difficulty" value="Hard" <?php echo ($difficulty == 'Hard' ? 'checked' : '');?>> Hard
    <p></p>
    <input type="submit" name="save" value="Save">
    </form>
    <?php echo "The difficulty is " . htmlentities($difficulty) ?>
</body>
</html>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once("../template.php");
