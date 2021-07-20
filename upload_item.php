<?php

include_once './etc/functions.php';


$target_item = basename($_FILES["itemToUpload"]["name"]);
echo "Name-> " . $target_item;
$itemExtension = get_item_extension($target_item);
echo "<br>Extension-> " . $itemExtension;


// Check item size (Bytes)
if ($_FILES["itemToUpload"]["size"] > 567645 ) {
    echo "<br>Sorry, your item is too large.";
}

// Allow certain item formats
if (!is_allowed_item_extension($itemExtension))
{
  echo "<br>Τhese types of items aren't allowed to upload";
}      

//TODO: να βάλω τα if statement σε δικές τους συναρτήσεις στο function.php    
//TODO: see the uploading file section on https://www.w3schools.com/php/php_file_upload.asp



?>