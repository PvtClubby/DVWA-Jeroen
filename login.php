<?php
require_once('connectdb.php');
require_once("mfa/phpotp/code/rfc6238.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_POST['user'];
    $pswd = $_POST['pswd'];

    $usersafe = mysqli_escape_string($conn, $user);
    $pswdsafe = mysqli_escape_string($conn, $pswd);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE passwordhash = '" . $pswdsafe . "' AND username = '" . $usersafe . "' LIMIT 1");
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        $row = mysqli_fetch_array($query);
        
        $secret = Base32Static::encode($row["otp_secret"]);

        if (!TokenAuth6238::verify($secret,$_POST["otp"])) {
            echo "Invalid code\n";
            die();
        } 
        
        $_SESSION['username'] = $user;
        $redirecturl = "/";

        http_response_code(302);
        header("Location: " . $redirecturl);
    } else {
        $error = "Username or Password is Invalid";
        print $error;
    }
    mysqli_close($conn);
    } else {
    ?>
    
    <?php
    ob_start();

    ?>

    <style>
        .center {
            display: flex;
            margin-left: auto;
            margin-right: auto;
        }

        .column {
            flex-direction: column;
        }

        .mb {
            margin-bottom: 1rem;
        }
    </style>

    <div style="display:flex">

        <div class="loginpagina center column">
            <h1 class="center">Login</h1>
            <p class="center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum hic officiis amet odio, cum dignissimos aliquam quasi magni impedit ratione unde aut, veniam at eaque quibusdam harum earum, minus error!</p>
            <form action="" method="post" class="column center">
                <input type="text" placeholder="Username" name="user" id="user" class="mb">

                <input type="password" placeholder="Password" name="pswd" id="pswd" class="mb">
                <input type="number" placeholder="OTP Code" name="otp">
                <button type="submit">Login</button>             
                <?php 
                $secret = Base32Static::encode("tafeltennistafeltennis");
                print "<img src=\"". TokenAuth6238::getBarCodeUrl('jeroen','dvwa',$secret, '') . "\"/>";
                ?>
            </form>
        </div>
    </div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    require_once("template.php");
}
