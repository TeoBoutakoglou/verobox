<?php

include_once './etc/php/functions.php';

session_start();
if(!isset($_FILES['itemToUpload']) || empty($_FILES['itemToUpload']['name']))
{
  set_toast_message("uploadedItemStatusMessage", "Please select an item first");
} 
else
{ 
  $itemName = $_FILES['itemToUpload']['name'];
  // $itemSize = $_FILES['itemToUpload']['size'];
  $itemTempName = $_FILES['itemToUpload']['tmp_name'];
  $itemExtension = get_item_extension($itemName);
  $itemSize = $_FILES['itemToUpload']['size'];
  $itemType = get_item_type($itemExtension);
  $username = $_SESSION["username"];
  $userId = get_user_id_by_username($username);
  $itemPath = "./users_items/$username/$itemType/$itemName";
  $itemSize = corvert_item_size_unit($itemSize);
  // if(file_exists($itemPath))
  // {
  //   set_toast_message("uploadedItemStatusMessage", "This item already exists");
  // }
  }


  // if(empty(get_toast_message('uploadedItemStatusMessage'))) //empty uploadedItemStatusMessage yet means no errors
  // { //everything is OK, upload the item
    upload_item_in_db($userId, $itemName, $itemPath, $itemSize, $itemType);
    upload_item_in_filesystem($itemTempName, $itemPath);
    
//     set_toast_message("uploadedItemStatusMessage", "$itemName was successfully uploaded");
//   }
// }
// redirect_to("home.php");

?>