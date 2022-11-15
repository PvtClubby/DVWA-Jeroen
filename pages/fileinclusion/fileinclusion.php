<?php
require_once("../../connectdb.php");

if (!array_key_exists("username",$_SESSION)){
    die("What brings you here?");
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if(isset ($_FILES['file'])){
        $file = $_FILES['file'];

        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
    }


    if (array_key_exists("difficulty", $_SESSION)) {
        if ($_SESSION['difficulty'] == "Easy"){
            if ($file_size <= 2000000000){
                $file_destination = './uploads/' . $file_name;
                if (move_uploaded_file($file_tmp, $file_destination)){
                    echo htmlentities($file_name) . ' succesfully uploaded!';
                }
            } 
            else {
            echo 'The File is too big, please make it smaller than 2 GB.';
            }
        }

        if ($_SESSION['difficulty'] == "Medium"){
            if ($file_size <= 2000000000){
                
                $file_destination = './uploads/' . $file_name;
                if (move_uploaded_file($file_tmp, $file_destination)){
                    echo htmlentities($file_name) . ' succesfully uploaded!';
                }
            } 
            else {
            echo 'The File is too big, please make it smaller than 2 GB.';
            }  
        

        }

        if ($_SESSION['difficulty'] == "Hard"){

        }
    }
}
ob_start();



?>

<h1> File Inclusion </h1>

<p> test </p>
<p> test </p>

<form method="post" enctype="multipart/form-data">
    <input class="form-control" type="file" name="file">
    <input class="btn btn-primary" type="submit" value="upload" <>
</form>

<?php
$content = ob_get_contents();
ob_end_clean();
require_once("../../template.php");