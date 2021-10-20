<?php


function connect_to_database()
{
    //Database information
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "verobox";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db_name);

    // Check connection
    if (!$conn) {
    die("Connection to database failed: " . mysqli_connect_error());
    }
    return $conn;
}


function create_new_user_in_db($givenFirstName, $givenLastName, $givenUsername, $givenPassword, $givenEmail, $givenGender, $dateOfBirth)
{
    $conn = connect_to_database();

    $query = 'INSERT INTO users (id, first_name, last_name, user_name, password, email, gender, date_of_birth, is_online)
              VALUES ("", "' . $givenFirstName .'","' . $givenLastName . '","' . $givenUsername . '","' . sha1($givenPassword) . '","' . $givenEmail . '","' . $givenGender . '","' . $dateOfBirth . '",' . 0 . ')';
    $result = mysqli_query($conn, $query);  
          
    mysqli_close($conn);
}


function user_exists ($username)
{
    $conn = connect_to_database();

    $query = 'SELECT user_name FROM users WHERE user_name = "' .$username. '"';
    $result = mysqli_query($conn, $query); 
    
    mysqli_close($conn);
    $countRows = mysqli_num_rows($result);
    
    if ($countRows > 0)
    {
       return true; 
    }
    else
    {
        return false; 
    }
}


function get_password_by_username($username)
{
    $conn = connect_to_database();
    $query = 'SELECT password FROM users WHERE user_name = "' .$username. '"';
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $password = $row['password'];

    return $password;
}

function redirect_to($target)
{
    if (!headers_sent())
    {
        exit(header("Location: ./" . $target));
    }
    else
    {
        echo "Cannot autoredirect Please go to <a href='" . $target . "'>$target</a>";
    }
}


function create_folder($folderName)
{
    if( is_dir($folderName) === false )
    {
        mkdir($folderName);
    }
}


function create_new_user_in_filesystem($username)
{
    chdir("users_items");
    create_folder($username);
    chdir($username);
    create_folder("file");
    create_folder("image");
    create_folder("video");
    create_folder("trash");
}


function set_is_online($username, $value)
{
    $conn = connect_to_database();
    $query = 'UPDATE users SET is_online = ' . $value . ' WHERE user_name = "' . $username . '"';
    //echo $query;
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
}


function get_item_name($itemName)
{
    return pathinfo($itemName)['filename'];
}


function get_item_extension($itemName)
{
    return strtolower(pathinfo($itemName,PATHINFO_EXTENSION));
}


function is_allowed_item_extension($itemExtension)
{
    $allowedExtensions = array("pdf", "doc", "log", "txt", //Files
                               "jpg", "png", //Images
                               "mkv", "mp4" //Videos
                              );
    return in_array($itemExtension, $allowedExtensions);
}


function is__file($itemExtension)
{
    $fileExtensions = array("pdf", "doc", "log", "txt");
    return in_array($itemExtension, $fileExtensions);
}


function is_image($itemExtension)
{
    $imageExtensions = array("jpg", "png");
    return in_array($itemExtension, $imageExtensions);
}


function is_video($itemExtension)
{
    $videoExtensions = array("mkv", "mp4");
    return in_array($itemExtension, $videoExtensions);
}


function get_item_type($itemExtension)
{
    if (is__file($itemExtension)) return 'file';
    else if (is_image ($itemExtension)) return 'image';
    else if (is_video($itemExtension)) return 'video';
}


function get_user_id_by_username($username)
{
    $conn = connect_to_database();
    $query = 'SELECT id FROM users WHERE user_name = "' .$username. '"';
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $userId = $row['id'];

    return $userId;
}

function upload_item_in_db($userId, $itemName, $itemPath, $itemSize, $itemType)
{
    $conn = connect_to_database();
    $query = 'INSERT INTO items (id, user_id, item_name, item_path, item_size, item_type, date_of_upload, sharable)
              VALUES("", ' . $userId . ', "' . $itemName . '", "' . $itemPath . '", "' . $itemSize . '", "' . $itemType . '", "' . date("Y/m/d") . '", 0)';
    $result = mysqli_query($conn, $query);  
    mysqli_close($conn);
}


function upload_item_in_filesystem($itemTempName, $itemPath)
{
    move_uploaded_file($itemTempName, $itemPath);
}


function delete_item_from_filesystem($path)
{
    // Use unlink() function to delete the item 
    if(!unlink($path))
    { 
        return false; 
    }
    else
        return true;
}


function delete_item_from_db($path)
{
    $conn = connect_to_database();
    $query = 'DELETE FROM items WHERE item_path = "' . $path . '"';
    
    if (!mysqli_query($conn, $query))
    {
        $result = false;
    }
    else
        $result = true;
     
    mysqli_close($conn);
    return $result;
}


function get_toast_message($sessionIndexName)
{
    if(isset($_SESSION[$sessionIndexName]))
    {
        $message = $_SESSION[$sessionIndexName];
        unset($_SESSION[$sessionIndexName]);
        return $message;
    }
}


function set_toast_message($sessionIndexName, $message)
{
    $_SESSION[$sessionIndexName] = $message;
}


function get_user_items($username, $itemToSearch)
{
    $userId = get_user_id_by_username($username);
    $conn = connect_to_database();
    $query = 'SELECT item_name, item_path, item_size, item_type, date_of_upload FROM items WHERE user_id = ' . $userId . ' AND item_name LIKE ' . "'%". $itemToSearch . "%'";
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);

    $rows = array();
    if (mysqli_num_rows($result) > 0)
    {
        
        while($row = mysqli_fetch_assoc($result))
        {
            $rows[] = $row; //$row contains the properties of an item
        }
    }
    return $rows; //contains all items (array of arrays form)
}


function display_items($items)
{
    foreach ($items as $item)
    {
        $itemName = $item['item_name'];
        $itemPath = $item['item_path'];
        $itemSize = $item['item_size'];
        $itemType = $item['item_type'];
        $itemDateOfUpload = $item['date_of_upload'];
        $downloadItemLink = "<a href='" . "download_item.php?path=$itemPath" . "'><i class='fas fa-download'></i></a>";
        $deleteItemLink = "<a href='" . "move_to_trash.php?path=$itemPath" . "'><i class='fas fa-trash-alt'></i></a>";
        
        if(strlen(get_item_name($itemName)) > 17)
        {
            $displayedItemName = substr($itemName, 0, 16) . "..." . get_item_extension($itemName);
        }
        else
        {
            $displayedItemName = $itemName;
        }

        echo "<div class='grid-item'>
                <div class='item-header'>
                    <div class='delete-item'>$deleteItemLink</div>";
                    if($itemType == 'image') echo "<img src='$itemPath'>";
                    else echo "<div class='icon'><i class='fas fa-$itemType'></i></div>";
                    
                echo "</div>
                <div class='item-information'>
                    <div class='item-name'>
                        $displayedItemName";
                        if(strlen(get_item_name($itemName)) > 17)
                            echo "<span class='full-item-name-tooltip'>$itemName</span>";
              echo "</div>
                    <div class='item-date-and-size'>$itemDateOfUpload | $itemSize</div>
                    <div class='download-item'>$downloadItemLink</div>
                </div>
              </div>";
    }
}


//validate whether a specific checkbox from a checkbox group is checked
function is_checked_checkbox($checkboxName,$value)
{
    if(isset($_POST[$checkboxName]))
    {  
        if(in_array($value, $_POST[$checkboxName]))
            return true;
        else
            return false;
    } 
}


function filter_items_by_extension($items, $extension)
{
    $itemsAfterFiltering = array();
    foreach ($items as $item)
    {
        $itemName = $item['item_name'];
        $itemExtension = get_item_extension($itemName);
        if($itemExtension == $extension)
        {
            $itemsAfterFiltering[] = $item;
        }
    }
    return $itemsAfterFiltering;
}


function filter_items_by_type($items, $selectedItemType)
{
    $itemsAfterFiltering = array();
    foreach ($items as $item)
    {
        $itemType = $item['item_type'];
        
        if($itemType == $selectedItemType)
        {
            $itemsAfterFiltering[] = $item;
        }
    }
    return $itemsAfterFiltering;
}


function corvert_item_size_unit($sizeInBytes)
{
    $convertedSize = "-1";
    if ($sizeInBytes < 1024) $convertedSize = strval($sizeInBytes) . " B";
    else if ($sizeInBytes < 1048576) $convertedSize = strval(round(($sizeInBytes/1024) ,2)) . " KB";
    else if ($sizeInBytes < 1073741824) $convertedSize = strval(round(($sizeInBytes/1048576) ,2)) . " MB";
    else $convertedSize = strval(round(($sizeInBytes/1073741824) ,2)) . " GB";
    return $convertedSize;
}


function move_to_trash($itemPath, $username)
{
    //TODO move the item in filesystem (in trash folder)
    $source_path = $itemPath;// get item path from DB
    $destination_path = "users_items/$username/trash/";
    if (rename($source_path, $destination_path . pathinfo($source_path, PATHINFO_BASENAME))) return true;
    else return false;

    //TODO: make the changes to DB
}

?>