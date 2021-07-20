<?php

include_once './etc/functions.php';

if(!isset($_FILES['itemToUpload']))
{
  echo "Please select an item first";
} 
else
{ 
  $errors = array();
  $item_name = $_FILES['itemToUpload']['name'];
  $item_size = $_FILES['itemToUpload']['size'];
  $item_tmp_name = $_FILES['itemToUpload']['tmp_name'];
  $item_extension = get_item_extension($item_name);
  $item_type = get_item_type($item_extension);
  
  session_start();
  $username = $_SESSION["username"];

  if (!is_allowed_item_extension($item_extension))
  {
    $errors[] = "This item cannot allowed to be upload.";
  }

  if($item_size > 20971520)
  {
    $errors[] = 'Item size must be excately 20 MB';
  }


  if(!empty($errors))
  {
    print_r($errors);
  }
  else
  {
    move_uploaded_file($item_tmp_name,"./users_items/$username/$item_type/$item_name");
    $_SESSION['successfulUploadedItemMessage'] = "Your $item_type was successfully uploaded";
    redirect_to("home.php");
  }


}

?>