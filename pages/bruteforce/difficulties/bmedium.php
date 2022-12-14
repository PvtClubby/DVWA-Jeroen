<?php
ob_start();
$username = "admin_medium";

if ($_SERVER["REQUEST_METHOD"] == "POST") { //If the server gets a POST request, do the following.

    $buser = $_POST['buser']; //take the html value's that are inserted and give them a name.
    $bpswd = $_POST['bpswd'];
    $username = $buser;

    $usersafe = mysqli_escape_string($conn, $buser); //ask the username credentials of the database.
    $pswdsafe = mysqli_escape_string($conn, $bpswd); //ask the password credentials of the database.
    $query = mysqli_query($conn, "SELECT * FROM users WHERE passwordhash = '" . $pswdsafe . "' AND username = '" . $usersafe . "' LIMIT 1");
    //Ask the following query from the database and return 1 user.
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        ?>
        <div class="alert alert-success" role="alert">
            Credentials are correct!
        </div>


        <?php 
    } else
    {  
        ?>
        <div class="alert alert-danger" role="alert">
            lol u bad
        </div>
        <?php
    }
}

?>

<div style="display:flex">

    <div class="loginpagina">
        <h1> Brute Force </h1>
        <p>Greetings, This is a login page to practise your Brute Forcing</p>
        <p>Goal: Force yourself into the user account by guessing/automating the username/password.</p>
        <p>Extra Description: You can type it for yourself but you can also use tools like: Burpsuite, OWASPZap, HYDRA</p>
        <div class="alert alert-warning" role="alert">
            Warning: There is a short cooldown for logging in.
        </div>
        <p></p>

        <form action="" method="post" class="center" id="bruteforce-form">
            <input type="text" placeholder="Username" name="buser" id="buser" class="form-control mb-2" value="<?php print htmlentities($username);?>"> 
            <input type="password" placeholder="Password" name="bpswd" id="bpswd" class="form-control">
            <p></p>
            <button type="submit" class="btn btn-primary mb-3 disabled" id="login-button">Login</button>
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
                            Try to bypass the cooldown.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion" id="accordionhint3">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingthree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="false" aria-controls="collapseOne">
                        Show Hint 2
                    </button>
                </h2>
                <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionhint3">
                    <div class="accordion-body">
                        <textarea class="form-control w-100" style="font-family: monospace; height:200px" cols="15" rows="30">
######  #######  #####  #    # #     # ####### #     # 
#     # #     # #     # #   #   #   #  #     # #     # 
#     # #     # #       #  #     # #   #     # #     # 
######  #     # #       ###       #    #     # #     # 
#   #   #     # #       #  #      #    #     # #     # 
#    #  #     # #     # #   #     #    #     # #     # 
#     # #######  #####  #    #    #    #######  #####  
                        </textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Take a look at the code
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="form-floating">
                            <textarea class="w-100 form-control" style="height:200px"><?php print htmlentities(file_get_contents(__FILE__)); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let button = document.getElementById("login-button"); //The login button get's a 5 second cooldown after loading the page.
            setTimeout(() => {
                button.classList.remove("disabled");
            }, 5000);
            
            let form = document.getElementById("bruteforce-form"); //if the login button is disabled, you can't do a post request.
            form.addEventListener("submit", (event) => {
                if(button.classList.contains("disabled")){
                    event.preventDefault();
                    return false;
                }
            })
        </script>
    </div>
</div>


<?php
$content = ob_get_contents();
ob_end_clean();
require_once("../../template.php");
