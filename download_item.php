<?php
    include_once './etc/functions.php';

    session_start();

    if(!isset($_GET['path']))
    {
        $_SESSION['downloadItemStatusMessage'] = "First select an item.";
    }
    else
    {
        $path = $_GET['path'];

        //Clear the cache
        clearstatcache();

        //Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header('Content-Length: ' . filesize($path));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the item
        readfile($path,true);
        $_SESSION['downloadItemStatusMessage'] = "Your download will start shortly...";
    }
    redirect_to("home.php");

?>