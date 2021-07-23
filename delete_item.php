<?php
    include_once './etc/functions.php';

    if(!isset($_GET['path']))
    {
        echo "First select an item.";
        // session_start()
        // $_SESSION['deleteItemStatus'] = "First select an item.";
        // redirect_to("home.php");
    }
    else
    {
        $path = $_GET['path'];

        //delete the item first from filesystem and after from DB
        delete_item_from_filesystem($path);
        delete_item_from_db($path);

        //Return to home.php
        redirect_to("home.php");
    }


?>