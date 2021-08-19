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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles/home/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="./etc/js/functions.js"></script>
        <title><?php echo $username?> - Verobox</title>
        
    </head>


    <body>


    <!-- MENU BAR -->
    <div class="menu-bar">
        <div class="home-logo">
            <a href="home.php">Verobox</a>
        </div>
        <!-- SEARCH BAR -->
        <div class="search-bar">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="search_options_dropdown">
                    <div class="selected_search_options" onclick='show_search_options_dropdown_list("dropdown-list")'>Search options</div>
                    <ul class="dropdown-list">
                        <li><input type="checkbox" name="searchOptions[]" value="searchExtension" <?php if(is_checked_checkbox("searchOptions","searchExtension")){  echo "checked";  } ?>>Extension</li>
                        <li><input type="checkbox" name="searchOptions[]" value="searchFiles" <?php if(is_checked_checkbox("searchOptions","searchFiles")){  echo "checked";  } ?>>Files</li>
                        <li><input type="checkbox" name="searchOptions[]" value="searchImages" <?php if(is_checked_checkbox("searchOptions","searchImages")){  echo "checked";  } ?>>Images</li>
                        <li><input type="checkbox" name="searchOptions[]" value="searchVideos" <?php if(is_checked_checkbox("searchOptions","searchVideos")){  echo "checked";  } ?>>Videos</li>
                    </ul>
                </div>
                <div class="search_field">
                    <input type="text" name="itemToSearch" placeholder="Search in Verobox ..." value= "<?php if(!empty($_POST['itemToSearch']))echo $_POST['itemToSearch']?>">
                    <button type="submit"name="submit-search"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="logout">
            <a href="home.php?_task=logout"><i class="fas fa-power-off"></i></a>
        </div>
    </div>  
    

    <!-- SIDE BAR -->
    <div class="side-bar">
        
    </div>

    
    <!-- HOME CONTENT -->
    <div class="home-content">
        <!-- Upload form -->
        <form action="upload_item.php" method="POST" enctype="multipart/form-data">
            Select item to upload:
            <input type="file" name="itemToUpload" id="itemToUpload">
            <input type="submit" value="Upload" name="submit-upload">
        </form>
        <?php

            $itemToSearch = ""; //set to "" means no search (get all the values)
            $items = array();

            //Search or get all items from DB
            if(isset($_POST['submit-search']) && empty($_POST['itemToSearch']))
            {
                set_toast_message('searchItemStatusMessage', "Type something to search");
                redirect_to("home.php");
            }
            else if(isset($_POST['submit-search']) && !empty($_POST['itemToSearch']))
            {
                $itemToSearch = $_POST['itemToSearch'];
            }
            
            $allUserItems = get_user_items($username, $itemToSearch); //each row of $items contains one item 
            
            //additional search options (filtering)
            if(isset($_POST['searchOptions']))
            {
                if (is_checked_checkbox("searchOptions","searchExtension"))
                {
                    $extension = $_POST['itemToSearch'];
                    $searchItemsByExtension = filter_items_by_extension($allUserItems, $extension);
                    $items = array_merge($items, $searchItemsByExtension);
                }

                if (is_checked_checkbox("searchOptions","searchFiles"))
                {
                    $searchItemsByType = filter_items_by_type($allUserItems, "file");
                    $items  = array_merge($items, $searchItemsByType);
                }

                if (is_checked_checkbox("searchOptions","searchImages"))
                {
                    $searchItemsByType = filter_items_by_type($allUserItems, "image");
                    $items  = array_merge($items, $searchItemsByType);
                }

                if (is_checked_checkbox("searchOptions","searchVideos"))
                {
                    $searchItemsByType = filter_items_by_type($allUserItems, "video");
                    $items  = array_merge($items, $searchItemsByType);
                }
            }        
            else
            {
                $items = $allUserItems;
            } 

            
            //DISPLAY ITEMS    
            echo "Your items (" .  count($items) . " results)<br>";
            display_items($items);
        ?>
    </div>

    </body>
</html>