<?php 

namespace Jeroen\Webserver;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVWA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Jeroen DVWA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/settings.php">Change Difficulty</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item d-flex me-3">
                    <p class="my-auto d-flex">
                        <?php
                        if (array_key_exists("username", $_SESSION)){
                            echo 'Current user ' . htmlentities($_SESSION["username"]);
                        } else{

                        }
                        ?>
                        </p>
                    </li>
                    
                    <li class="nav-item d-flex">
                        <p class="my-auto d-flex">
                        <?php   
                        if (array_key_exists("difficulty", $_SESSION)){
                            echo 'Difficulty: ' . htmlentities($_SESSION["difficulty"]);
                        } else {
                            echo 'No difficulty set';
                        }

                        ?>    
                        </p>
                    </li>
                    <li class="nav-item">
                    <?php
                        if (array_key_exists("username", $_SESSION)){ 
                            ?>
                            <a class="nav-link" href="/auth/logout.php">Logout</a>
                            <?php                           
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="w-100 p-3">
        <?php 
        print $content;

        ?>
    </div>
</body>
</html>
