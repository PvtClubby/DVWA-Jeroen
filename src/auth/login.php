<?php 

namespace Jeroen\Webserver\auth;

// use Jeroen\Webserver\mfa\phpotp\code\Base32Static;
// use Jeroen\Webserver\mfa\phpotp\code\TokenAuth6238;
use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;

?>
<?php
require_once('../connectdb.php'); //Set connection with database.
// require_once("../mfa/phpotp/code/rfc6238.php"); // use the mfa library to use the functionality.
if ($_SERVER["REQUEST_METHOD"] == "POST") { //If the server gets a POST request, do the following.

    $user = $_POST['user']; //take the html value's that are inserted and give them a name.
    $pswd = $_POST['pswd'];
    $otpCode = $_POST['otp'];

    $usersafe = mysqli_escape_string($conn, $user); //ask the username credentials of the database.
    $pswdsafe = mysqli_escape_string($conn, $pswd); //ask the password credentials of the database.
    $query = mysqli_query($conn, "SELECT * FROM users WHERE passwordhash = '" . $pswdsafe . "' AND username = '" . $usersafe . "' LIMIT 1");
    //Ask the following query from the database and return 1 user.
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        $row = mysqli_fetch_array($query);
        $mfasecret = $row["otp_secret"];

        if ($mfasecret != ''){ //If the MFA value in the database is filled in or is blank.
            $secret = trim(Base32::encodeUpper($mfasecret, '=')); //encode this filledin value
            
            $otp = TOTP::createFromSecret($secret);
            $otp->setPeriod(30);
            $otp->setDigits(6);
            //check if the value is the same based on the time & database.
            // if (!TokenAuth6238::verify($secret,$otp)) { //the value is not the same.
            //     echo "Invalid code\n"; //send message
            //     die($row['otp_secret']); //end session
            // } 
            if (!$otp->verify($otpCode)) { //the value is not the same.
                echo "Invalid otp code\n"; //send message
                die(); //end session
            }
        }

        $_SESSION['username'] = $user; //the html value will be the username session if the username is correct
        $redirecturl = "/"; //send the user to the home page

        http_response_code(302);
        header("Location: " . $redirecturl);

    } else { //username/password is not correct
        $error = "Username or Password is Invalid";
        print $error;
    }
    mysqli_close($conn); //close the connection
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
            <p> If you don't have an account yet, Click <a href ="/auth/register.php">here</a> to register.</p>
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
    $content = ob_get_contents(); //get the content of the output buffer
    ob_end_clean(); //clean the buffer
    require_once("../template.php"); //use the css template
}

//