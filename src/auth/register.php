<?php 

namespace Jeroen\Webserver\auth;

use Jeroen\Webserver\mfa\phpotp\code\Base32Static;
use Jeroen\Webserver\mfa\phpotp\code\TokenAuth6238;

?>
<?php
require_once('../connectdb.php'); //Set connection with database.
require_once("../mfa/phpotp/code/rfc6238.php"); // use the mfa library to use the functionality.

if ($_SERVER["REQUEST_METHOD"] == "POST") { //If the server gets a POST request, do the following.

    $user = $_POST['user']; //take the html value's that are inserted and give them a name.
    $pswd = $_POST['pswd'];
    $mfa = $_POST['mfa'];
    $redirecturl = "/"; //Set homepage value.

    $usersafe = mysqli_escape_string($conn, $user); //ask the username credentials of the database.
    $pswdsafe = mysqli_escape_string($conn, $pswd); //ask the password credentials of the database.

    $mfaoptions = array('on', 'off'); //give the value 2 options.
    if (!in_array($mfa, $mfaoptions)) { //mfa value is NOT 'on' or 'off' do the following:
        die('Why are you playing with your safety?'); //end the session
    }

    $mfasecret = base64_encode(openssl_random_pseudo_bytes(32)); //generate random bytes
    if ($mfa == 'on') { //if the mfa value is 'on' add the username, password and the random bytes into the database:
        $mfainsert = "INSERT INTO users (username, passwordhash, otp_secret)
            VALUES ('$usersafe', '$pswdsafe', '$mfasecret')";
    } else { //if the mfa value is 'on' add the username, password and 'blank' into the database:
        $mfainsert = "INSERT INTO users (username, passwordhash, otp_secret)
            VALUES ('$usersafe', '$pswdsafe', '')";
    }

    $query = mysqli_query($conn, $mfainsert); //Let the user be logged in with mfa credentials.
    $_SESSION["username"] = $user; //Let the user be logged in after they registred account.
    
    if ($mfa == 'on') { //if mfa is 'on', encode the bytes and generate a qr code with the TokenAuth6238 class + getBarCodeUrl function from MFA library.
    $secret = Base32Static::encode($mfasecret);
    print "<img src=\"" . TokenAuth6238::getBarCodeUrl($user, 'dvwa', $secret, '') . "\"/>";
    print "Scan & Save the code with Google Authenticator.";
    print " Click on the Logo to get redirected to the homepage.";
    }
    else { //if mfa is 'off', return the user towards the home page.
        http_response_code(302);
        header("Location: " . $redirecturl);

    }

} else {


?>
    <form action="" method="post" class="column center">
        <p> Please enter your username & password.</p>
        <p> Username need to exist out of small characters and the maximal length is 15.</p>
        <p> Password need to exist out of 'Capslock letter' 'small characters' 'Number' 'Sign' and the minimal length is 8.</p>
        <p> It is recommanded to enable MFA.</p>

        <input type="text" placeholder="Username" name="user" id="user" class="mb" pattern="^[a-z]+$">
        <input type="password" placeholder="Password" name="pswd" id="pswd" class="mb" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,32}$">
        <p></p>
        <p> Settings MFA:</p>
        <input type="radio" name="mfa" value="on"> on
        <p></p>
        <input type="radio" name="mfa" value="off"> off

        <p></p>
        <button type="submit">Register</button>
    </form>
<?php
}
$content = ob_get_contents(); //get the content of the output buffer
ob_end_clean(); //clean the buffer
require_once("../template.php"); //use the css template
