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

        //delete the item first from filesystem and after from DB
        $deleteFromFilesystemOK = delete_item_from_filesystem($path);
        $deleteFromDBOK = delete_item_from_db($path);

        if($deleteFromFilesystemOK && $deleteFromDBOK)
            set_toast_message('deleteItemStatusMessage', basename($path) . " has been deleted");
        else
            set_toast_message('deleteItemStatusMessage', "Error: cannot delete. Maybe " . basename($path) . " does not existed");
    }

    //Return to home.php
    redirect_to("home.php");

?>