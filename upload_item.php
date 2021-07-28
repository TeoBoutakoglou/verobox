<?php

include_once './etc/php/functions.php';

session_start();
if(!isset($_FILES['itemToUpload']) || empty($_FILES['itemToUpload']['name']))
{
  $_SESSION['uploadedItemStatusMessage'] = "Please select an item first";
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
    $_SESSION['uploadedItemStatusMessage'] = "These types of items is prohibited to upload.";
  }
  else if($itemSize > 89128960)
  {
    $_SESSION['uploadedItemStatusMessage'] = 'Item size must be excately 85 MB';
  }


  if(empty($_SESSION['uploadedItemStatusMessage'])) //no errors
  { //everything is OK, upload the item
    upload_item_in_db($userId, $itemName, $itemPath, $itemType);
    upload_item_in_filesystem($itemTempName, $itemPath);
    
    $_SESSION['uploadedItemStatusMessage'] = "$itemName was successfully uploaded";
  }
}
redirect_to("home.php"); //TODO: if i include this php script to home.php this line need to be removed

?>