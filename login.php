<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $user=$_POST['user'];
    $pswd=$_POST['pswd'];
    require_once('connectdb.php');
    $usersafe = mysqli_escape_string($conn, $user);
    $pswdsafe = mysqli_escape_string($conn, $pswd);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE passwordhash = '".$pswdsafe."' AND username = '".$usersafe."' LIMIT 1");
    $rows = mysqli_num_rows($query);
    if($rows == 1){
        session_start();
        $_SESSION['username'] = $user;
        $redirecturl="/";
        
        http_response_code(302);
        header("Location: " . $redirecturl);
    }
    else
    {
        $error = "Username or Password is Invalid";
        print $error;
    }
    mysqli_close($conn);


}else {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login page</title>
        <style>
            .center{
                display:flex;
                margin-left:auto;
                margin-right:auto;
            }
            .column{
                flex-direction:column;
            }

            .mb{
                margin-bottom:1rem;
            }

        </style>
    </head>
    <body style="display:flex">

        <div class="loginpagina center column">
            <h1 class="center">Login</h1>
            <p class="center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum hic officiis amet odio, cum dignissimos aliquam quasi magni impedit ratione unde aut, veniam at eaque quibusdam harum earum, minus error!</p>
            <form action="" method="post" class="column center">
                <input type="text" placeholder="Username" name="user" id="user" class="mb">
                
                <input type="password" placeholder="Password" name="pswd" id="pswd" class="mb">
                <button type="submit">Login</button>
            </form>
        </div>
        

    </body>
    </html>
    <?php
}
?>