<?php
require_once('../connectdb.php');
require_once("../mfa/phpotp/code/rfc6238.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = $_POST['user'];
    $pswd = $_POST['pswd'];
    $mfa = $_POST['mfa'];
    $redirecturl = "/";

    $usersafe = mysqli_escape_string($conn, $user);
    $pswdsafe = mysqli_escape_string($conn, $pswd);

    $mfa = $_POST['mfa'];
    $mfaoptions = array('on', 'off');
    if (!in_array($mfa, $mfaoptions)) {
        die('Why are you playing with your safety?');
    }

    $mfasecret = base64_encode(openssl_random_pseudo_bytes(32));
    if ($mfa == 'on') {
        $mfainsert = "INSERT INTO users (username, passwordhash, otp_secret)
            VALUES ('$usersafe', '$pswdsafe', '$mfasecret')";
    } else {
        $mfainsert = "INSERT INTO users (username, passwordhash, otp_secret)
            VALUES ('$usersafe', '$pswdsafe', '')";
    }

    $query = mysqli_query($conn, $mfainsert);
    $_SESSION["username"] = $user;
    
    if ($mfa == 'on') {
    $secret = Base32Static::encode($mfasecret);
    print "<img src=\"" . TokenAuth6238::getBarCodeUrl($user, 'dvwa', $secret, '') . "\"/>";
    print "Scan & Save the code with Google Authenticator.";
    print " Click on the Logo to get redirected to the homepage.";
    }
    else {
        http_response_code(302);
        header("Location: " . $redirecturl);

    }

} else {


?>


    <form action="" method="post" class="column center">
        <input type="text" placeholder="Username" name="user" id="user" class="mb" pattern="^[a-z]+$">
        <input type="password" placeholder="Password" name="pswd" id="pswd" class="mb" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,32}$">
        <p></p>
        <input type="radio" name="mfa" value="on"> on
        <p></p>
        <input type="radio" name="mfa" value="off"> off

        <p></p>
        <button type="submit">Register</button>
    </form>

<?php
}
$content = ob_get_contents();
ob_end_clean();
require_once("../template.php");

//<input type="number" placeholder="OTP Code" name="otp" pattern="^[0-9]{6,6}$">