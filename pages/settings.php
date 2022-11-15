<?php
require_once ("../connectdb.php");

if (!array_key_exists("username",$_SESSION)){
    die("What brings you here?");
} 


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $difficulty=$_POST['difficulty'];
    $alloweddifficulties = array('Easy', 'Medium', 'Hard');
    if (!in_array($difficulty , $alloweddifficulties)){
        die('That difficulty does not exist!');
    }

    $_SESSION["difficulty"] = $difficulty;
}

if (array_key_exists("difficulty",$_SESSION)){
    $difficulty = $_SESSION["difficulty"];  
} else {
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
