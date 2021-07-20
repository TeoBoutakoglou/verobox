<!DOCTYPE HTML> 
<?php
    include_once './etc/functions.php';


    //messages variables
    $successfulUploadedItemMessage = '';

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
    
    if(isset($_SESSION["successfulUploadedItemMessage"]))
    {
        $successfulUploadedItemMessage = $_SESSION["successfulUploadedItemMessage"];
        echo "<br>" . $successfulUploadedItemMessage;
    }
    

?>


<html>
    <head>
        <title><?php echo $username?> - Verobox</title>
        <link rel="stylesheet" href="styles/home/css/style.css">
    </head>


    <body>

    <p class="tmp">Welcome, <?php echo $username?></p>

    <form action="upload_item.php" method="POST" enctype="multipart/form-data">
        Select item to upload:
        <input type="file" name="itemToUpload" id="itemToUpload">
        <input type="submit" value="Upload Item" name="submit">
    </form>




    <a href="home.php?_task=logout">logout</a>

    </body>
</html>