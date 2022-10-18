<?php
require_once ("../connectdb.php");
session_start();

if (!array_key_exists("username",$_SESSION)){
    die("What brings you here?");
} 


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $difficulty=$_POST['difficulty'];

    $_SESSION["difficulty"] = $difficulty;
}

if (array_key_exists("difficulty",$_SESSION)){
    $difficulty = $_SESSION["difficulty"];  
} else {
    $difficulty = 'Easy';
}

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
    <h1>Choice Menu</h1>
    <p>What would you like to practice?</p>

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
    <?php echo "The difficulty is " . $difficulty ?>
</body>
</html>