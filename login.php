<!--check credentials for login--> 
<?php
  include_once './etc/functions.php';

  //error status variables
  $usernameErr = $passwordErr = "";
  $givenUsername =  $givenPassword = "";

  session_start();

  //Auto direct to home page if load login.php and already connected in local machine
  if(isset($_SESSION["username"]))
  {
    redirect_to("home.php");
  }

  //Get successful registration message
  if(isset($_SESSION['successfulRegistrationMessage']))
  {
    $successfulRegistrationMessage = $_SESSION['successfulRegistrationMessage'];
    unset($_SESSION['successfulRegistrationMessage']);
    echo $successfulRegistrationMessage;
  }


  //Get successful logout message
  if(isset($_SESSION['successfulLogoutMessage']))
  {
    $successfulLogoutMessage = $_SESSION['successfulLogoutMessage'];
    unset($_SESSION['successfulLogoutMessage']);
    echo $successfulLogoutMessage;
  }


  session_unset();
  session_destroy();

  //User authendication
  if(  isset($_POST['loginUsername']) && isset($_POST['loginPassword'])  ){

    //check username
    $givenUsername = $_POST['loginUsername'];
    if( user_exists($givenUsername) )
    {
      $usernameErr = '';

      //check password only if username exists
      $givenPassword = $_POST['loginPassword'];
      $dbPassword = get_password_by_username($givenUsername);
      
      if(sha1($givenPassword) != $dbPassword)
      {
        $passwordErr = 'wrong password';
      }
      else
      {
        //redirecting to home page
        session_start();
        $_SESSION["username"] = $givenUsername;
        redirect_to ('home.php');
      }
    }
    else
    {
      $usernameErr = 'no such username';
    }
  }

?>

<!DOCTYPE HTML> 
<html>
  <head>
    <title>Login - Verobox</title>
    <link rel="stylesheet" type="text/css" href="styles/login/css/style.css">
  </head>

  <body>

    <div class="login-box">
        
        <img src=".\styles\login\images\login-user-avatar-icon.png" class="login-avatar">
        <!--welcome to login page message-->
        <div class="welcome-message">Verobox</div>

        <!--login form-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <label for="lblLoginUsername">Username:</label>
          <input type="text" id="username" name="loginUsername" placeholder="Enter your username" value= "<?php echo $givenUsername?>" required="username is required" autofocus>
          <span class="error"><?php echo $usernameErr;?></span><br>
          <label for="lblLoginPassword">Password:</label>
          <input type="password" id="password" name="loginPassword" placeholder="Enter your password"  required="password is required">
          <span class="error"><?php echo $passwordErr;?></span><br>
          <input type="submit" value="Login">
        </form>

        <a href='./register.php'>Δεν έχεις λογαριασμό?</a>
    </div>


  </body>
</html>