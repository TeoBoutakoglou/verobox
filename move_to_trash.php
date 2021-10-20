<?php
    include_once './etc/php/functions.php';
    
    session_start();
    
    if(!isset($_GET['path']))
    {
        set_toast_message('deleteItemStatusMessage', "First select an item for delete.");
    }
    else
    {
        $path = $_GET['path'];
        $username = $_SESSION['username'];

        $moveToTrashOK = move_to_trash($path, $username);

        if($moveToTrashOK)
            set_toast_message('deleteItemStatusMessage', basename($path) . " has moved to trash");
        else
            set_toast_message('deleteItemStatusMessage', "Error: cannot delete. Maybe " . basename($path) . " does not existed");
    }
    //Return to home.php
    redirect_to("home.php");

?>