<?php
require_once('../connectdb.php');
?>

<?php
session_destroy();
$redirecturl = "/";
http_response_code(302);
header("Location: " . $redirecturl);

