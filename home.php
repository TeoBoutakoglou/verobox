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
    
    //LOGOUT
    if(isset($_GET["_task"]))
    {
        if($_GET["_task"] == "logout")
        {
            session_unset();
            session_destroy();
            set_is_online($username, 0); //TODO: fix because clicking in logout execute this set_is_online and the one from the above else because the username index from $_SESSION exists
            session_start();
            $_SESSION["successfulLogoutMessage"] = $username . " you're successfully logout.";
            redirect_to('login.php');
        }
    }
    
    //GET INFORMATION MESSAGES
    if(isset($_SESSION["uploadedItemStatusMessage"]))
    {
        $uploadedItemStatusMessage = $_SESSION["uploadedItemStatusMessage"];
        unset($_SESSION['uploadedItemStatusMessage']);
        print_r($uploadedItemStatusMessage);
    }

    if(isset($_SESSION["deleteItemStatusMessage"]))
    {
        $deleteItemStatusMessage = $_SESSION["deleteItemStatusMessage"];
        unset($_SESSION['deleteItemStatusMessage']);
        print_r($deleteItemStatusMessage);
    }

    if(isset($_SESSION["downloadItemStatusMessage"]))
    {
        $downloadItemStatusMessage = $_SESSION["downloadItemStatusMessage"];
        unset($_SESSION['downloadItemStatusMessage']);
        print_r($downloadItemStatusMessage);
    }


    

?>

<!DOCTYPE HTML> 
<html>
    <head>
        <title><?php echo $username?> - Verobox</title>
        <link rel="stylesheet" type="text/css" href="styles/home/css/style.css">
    </head>


    <body>

    <p class="tmp">Welcome, <?php echo $username?></p>

    <form action="upload_item.php" method="POST" enctype="multipart/form-data">
        Select item to upload:
        <input type="file" name="itemToUpload" id="itemToUpload">
        <input type="submit" value="Upload" name="submit">
    </form>
    <?php
        //print all items from DB
        echo "<br>Your items<br>";
        $items = get_all_user_items($username); //each row of $items contains one item
        foreach ($items as $item)
        {
            $itemName = $item['item_name'];
            $itemPath = $item['item_path'];
            $itemType = $item['item_type'];
            $itemDateOfUpload = $item['date_of_upload'];
            $downloadItemLink = "<a href='" . "download_item.php?path=$itemPath" . "'>Download $itemType</a>";
            $deleteItemLink = "<a href='" . "delete_item.php?path=$itemPath" . "'>Delete $itemType</a>";
            echo "$itemType name: $itemName, Date of upload: $itemDateOfUpload  $downloadItemLink $deleteItemLink<br>";
        }

        
    ?>
    <br>
    <a href="home.php?_task=logout">logout</a>

    </body>
</html>