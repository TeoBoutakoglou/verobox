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
  $itemSize = $_FILES['itemToUpload']['size'];
  $itemTempName = $_FILES['itemToUpload']['tmp_name'];
  $itemExtension = get_item_extension($itemName);
  $itemType = get_item_type($itemExtension);
  $username = $_SESSION["username"];
  $userId = get_user_id_by_username($username);
  $itemPath = "./users_items/$username/$itemType/$itemName";

  if (!is_allowed_item_extension($itemExtension))
  {
    set_toast_message("uploadedItemStatusMessage", "These types of items is prohibited to upload.");
  }
  else if($itemSize > 89128960)
  {
    set_toast_message("uploadedItemStatusMessage", 'Item size must be excately 85 MB');
  }


  if(empty(get_toast_message('uploadedItemStatusMessage'))) //empty uploadedItemStatusMessage yet means no errors
  { //everything is OK, upload the item
    upload_item_in_db($userId, $itemName, $itemPath, $itemType);
    upload_item_in_filesystem($itemTempName, $itemPath);
    
    set_toast_message("uploadedItemStatusMessage", "$itemName was successfully uploaded");
  }
}
redirect_to("home.php"); //TODO: if i include this php script to home.php this line need to be removed

?>