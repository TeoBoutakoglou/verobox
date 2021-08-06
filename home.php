<?php
    include_once './etc/php/functions.php';

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
    
    //LOGOUT
    if(isset($_GET["_task"]))
    {
        if($_GET["_task"] == "logout")
        {
            session_unset();
            session_destroy();
            set_is_online($username, 0); //TODO: fix because clicking in logout execute this set_is_online and the one from the above else because the username index from $_SESSION exists
            session_start();
            set_toast_message('successfulLogoutMessage', $username . ", you're successfully logout.");
            redirect_to('login.php');
        }
    }

    //GET FLASH INFORMATION MESSAGES
    echo get_toast_message("uploadedItemStatusMessage");
    echo get_toast_message("deleteItemStatusMessage");
    echo get_toast_message("downloadItemStatusMessage");
    echo get_toast_message("searchItemStatusMessage");
?>

<!DOCTYPE HTML> 
<html>
    <head>
        <title><?php echo $username?> - Verobox</title>
        <link rel="stylesheet" type="text/css" href="styles/home/css/style.css">
    </head>


    <body>

    <!-- Search bar form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <input type="text" name="itemToSearch" placeholder="Search in Verobox">
        <input type="submit" value="Search" name="submit-search"><br>
        Search for: <input type="checkbox" name="searchOptions[]" value="searchExtension" <?php if(is_checked_checkbox("searchOptions","searchExtension")){  echo "checked";  } ?>>Extension
        <input type="checkbox" name="searchOptions[]" value="searchKeywords">Keywords
    </form>
    
    <!-- Upload form -->
    <form action="upload_item.php" method="POST" enctype="multipart/form-data">
        Select item to upload:
        <input type="file" name="itemToUpload" id="itemToUpload">
        <input type="submit" value="Upload" name="submit-upload">
    </form>
    <?php

        $itemToSearch = ""; //set to "" means no search (get all the values)
        
        //Search or get all items from DB
        if(empty($_POST['itemToSearch']))
        {
            set_toast_message('searchItemStatusMessage', "Type something to search");
        }
        else
        {
            $itemToSearch = $_POST['itemToSearch'];
        }
        
        $items = get_user_items($username, $itemToSearch); //each row of $items contains one item 
        
        //additional search options (filtering)
        if(is_checked_checkbox("searchOptions","searchExtension"))
        {
            $extension = $_POST['itemToSearch'];
            $items = filter_items_by_extension($items, $extension);
        }
        
        //Display items
        echo "<br>Your items<br>";
        display_items($items);

        
    ?>
    <br>
    <a href="home.php?_task=logout">logout</a>

    </body>
</html>