<?php

//echo "uploading the file....";
$target_item = basename($_FILES["itemToUpload"]["name"]);
echo "Item name-> " . $target_item;
$itemType = strtolower(pathinfo($target_item,PATHINFO_EXTENSION));
echo " Extension-> " . $itemType;


// Check item size (Bytes)
if ($_FILES["itemToUpload"]["size"] > 567645 ) {
    echo "<br>Sorry, your item is too large.";
}

// Allow certain item formats
if($itemType != "jpg" && $itemType != "mkv" && $itemType != "pdf") {
  echo "<br>Sorry, only JPG, MKV & PDF items are allowed.";
}       

//TODO: να βάλω τα if statement σε δικές τους συναρτήσεις στο function.php    
//TODO: see the uploading file section on https://www.w3schools.com/php/php_file_upload.asp



?>