<!DOCTYPE HTML> 
<?php
    include_once './etc/functions.php';


    session_start();
    if(!isset($_SESSION["username"])){
        //first login to your account
        redirect_to('login.php');
    }
    else
    {
        $username = $_SESSION["username"];
        echo "<p>Welcome, " . $username . "</p>";
    }

    // session_unset();
    // session_destroy();

    //set_is_online($username, True);
?>


<html>
    <head>
        <title><?php echo $username?> - Verobox</title>
        <link rel="stylesheet" href="style/home.css">
    </head>


    <body>

    <p class="tmp"> hello


    </body>
</html>