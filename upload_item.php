<?php

include_once './etc/functions.php';

if(!isset($_FILES['itemToUpload']))
{
  echo "Please select an item first";
} 
else
{ 
  $errors = array();
  $itemName = $_FILES['itemToUpload']['name'];
  $itemSize = $_FILES['itemToUpload']['size'];
  $itemTempName = $_FILES['itemToUpload']['tmp_name'];
  $itemExtension = get_item_extension($itemName);
  $itemType = get_item_type($itemExtension);
  
  session_start();
  $username = $_SESSION["username"];
  $itemPath = "./users_items/$username/$itemType/$itemName";

  if (!is_allowed_item_extension($itemExtension))
  {
    $errors[] = "This item cannot allowed to be upload.";
  }

  if($itemSize > 20971520)
  {
    $errors[] = 'Item size must be excately 20 MB';
  }


  if(!empty($errors))
  {
    print_r($errors);
  }
  else
  {
    //TODO: upload_item_in_db();
    //TODO: upload_item_in_filesystem();
    
    move_uploaded_file($itemTempName, $itemPath);
    $_SESSION['successfulUploadedItemMessage'] = "$itemName was successfully uploaded";
    redirect_to("home.php"); //TODO: if i include this php script to home.php this line need to be removed
  }


}

?>