<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = array('phtml');

        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 200000000) {
                    $file_destination = './uploads/' . $file_name;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        echo htmlentities($file_name) . ' succesfully uploaded!';
                    }
                } else {
                    die("The File is too big, please make it smaller than 200 MB.");
                }
            } else {
                die("There was a problem with uploading your file, please try again.");
            }
        } else {
            die("Sorry but you can not upload these kind of files!");
        }
    }
}
ob_start();

?>

<div style="display:flex">

    <div class="loginpagina">
        <h1> File Inclusion </h1>

        <p> This is a webpage where you can upload your files. </p>
        <p> Upload a file to make changes into the webserver. </p>
        <p> Goodluck with finding your extension ;)</p>

        <form method="post" enctype="multipart/form-data">
            <input class="form-control" type="file" name="file">
            <input class="btn btn-primary mb-3" type="submit" value="upload">
        </form>
        <div class="accordion" id="accordionhint2">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingtwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="false" aria-controls="collapseOne">
                        Show Hint 1
                    </button>
                </h2>
                <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionhint2">
                    <div class="accordion-body">
                        <div class="form-floating">
                            YWJjZGVmZ2hpamtsbW5vUHFyc3R1dnd4eXo=
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once("../../template.php");
