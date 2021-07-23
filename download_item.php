<?php

    if(!isset($_GET['path']))
    {
        echo "First select an item.";
    }
    else
    {
        $path = $_GET['path'];

        //Clear the cache
        clearstatcache();

        //Check the item path exists or not
        if(file_exists($path))
        {
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

            //Terminate from the script
            die();
        }
        else
        {
            echo "Item path does not exist.";
        }
    }

?>