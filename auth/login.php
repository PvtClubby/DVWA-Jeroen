<?php
require_once('../connectdb.php');
require_once("../mfa/phpotp/code/rfc6238.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_POST['user'];
    $pswd = $_POST['pswd'];
    $otp = $_POST['otp'];

    $usersafe = mysqli_escape_string($conn, $user);
    $pswdsafe = mysqli_escape_string($conn, $pswd);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE passwordhash = '" . $pswdsafe . "' AND username = '" . $usersafe . "' LIMIT 1");
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        $row = mysqli_fetch_array($query);
        $mfasecret = $row["otp_secret"];

        if ($mfasecret != ''){
            $secret = Base32Static::encode($mfasecret);
            
            if (!TokenAuth6238::verify($secret,$otp)) {
                echo "Invalid code\n";
                die($row['otp_secret']);
            } 
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
            <p>If you don't have an account yet, Click <a href ="/auth/register.php">here</a> to register.</p>
            <p> If you have MFA enabled, Please enter your OTP code. </p>
            <p> Otherwise, leave the OTP field empty. </p>

            <form action="" method="post" class="column center">
                <input type="text" placeholder="Username" name="user" id="user" class="mb">
                <input type="password" placeholder="Password" name="pswd" id="pswd" class="mb">
                <input type="number" placeholder="OTP Code" name="otp" pattern="^[0-9]{6,6}$">
                <p></p>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    require_once("../template.php");
}

//