<!DOCTYPE HTML> 
<?php
    include_once './etc/functions.php';


    session_start();
        
    if(!isset($_SESSION["username"])){
        //first login to your account
        session_unset();
        session_destroy();
        redirect_to('login.php');
    }
    else
    {
        $username = $_SESSION["username"];
        set_is_online($username, 1);
    }
    
    if(isset($_GET["_task"]))
    {
        if($_GET["_task"] == "logout")
        {
            session_unset();
            session_destroy();
            set_is_online($username, 0);
            session_start();
            $_SESSION["successfulLogoutMessage"] = $username . " you're successfully logout.";
            redirect_to('login.php');
        }
    }
    
    
    

?>


<html>
    <head>
        <title><?php echo $username?> - Verobox</title>
        <link rel="stylesheet" href="styles/home/css/style.css">
    </head>


    <body>

    <p class="tmp">Welcome, <?php echo $username?></p>
    <a href="home.php?_task=logout"> logout</a>

    </body>
</html>