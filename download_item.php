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
        //the item start to download and after the status message shows up //$_SESSION['downloadItemStatusMessage'] = "Your download will start shortly..."; //TODO: issue. does not show this message in home.php probably because the home.php not refreshed or not leaving the home.php at all
    }
    redirect_to("home.php");

?>