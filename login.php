<!DOCTYPE HTML> 
<html>
  <head>
    <title>Login - Verobox</title>
    <link rel="stylesheet" href="styles/login/css/style.css">
  </head>

  <!--check credentials for login--> 
  <?php
    include_once './etc/functions.php';

    //error status variables
    $usernameErr = $passwordErr = "";
    $givenUsername =  $givenPassword = "";

    //messages variables
    $successfulRegistrationMessage = $successfulLogoutMessage = '';


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
      echo $successfulRegistrationMessage;
    }

    
    //Get successful logout message
    if(isset($_SESSION['successfulLogoutMessage']))
    {
      $successfulLogoutMessage = $_SESSION['successfulLogoutMessage'];
      echo $successfulLogoutMessage;
    }


    session_unset();
    session_destroy();





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


  <body>

    <!--welcome to login page message-->
    <h2>welcome to Verobox!</h2>

    <!--login form-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <label for="lblLoginUsername">Username:</label><br>
      <input type="text" id="username" name="loginUsername" placeholder="Enter your username" value= "<?php echo $givenUsername?>" required="username is required" autofocus>
      <span class="error"><?php echo $usernameErr;?></span><br>
      <label for="lblLoginPassword">Password:</label><br>
      <input type="password" id="password" name="loginPassword" placeholder="Enter your password"  required="password is required">
      <span class="error"><?php echo $passwordErr;?></span><br>
      <input type="submit" value="Login">
    </form>

    <br><a href='./register.php'>Δεν έχεις λογαριασμό?</a>



  </body>
</html>