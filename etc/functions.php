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
    header("Location: ./" . $target);
    die();
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
    create_folder("files");
    create_folder("photos");
    create_folder("videos");
}


set_is_online($username, $value)
{
    // $conn = connect_to_database();
    // $query = 'UPDATE users SET is_online = $value WHERE user_name = $username';
    // echo $query;
    // $result = mysqli_query($conn, $query);
    // mysqli_close($conn);
}


?>