<!--check credentials for login--> 
<?php
  include_once './etc/php/functions.php';

  //error status variables
  $usernameErr = $passwordErr = "";
  //given values variables
  $givenUsername =  $givenPassword = "";

  session_start();

  //Auto direct to home page if load login.php and already connected in local machine
  if(isset($_SESSION["username"]))
  {
    redirect_to("home.php");
  }
?>

  <!--Get successful logout and registration message in a toast-->
  <div class="toast hide" id="toastId">
    <span class="message"><?php echo get_flash_message('successfulLogoutMessage'); echo get_flash_message('successfulRegistrationMessage');?></span> 
  </div>
  
  
  
  <?php
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
        $passwordErr = "The password isn't correct";
      }
      else
      {
        //Credentials are OK. Redirecting to home page
        session_start();
        $_SESSION["username"] = $givenUsername;
        redirect_to ('home.php');
      }
    }
    else
    {
      $usernameErr = "$givenUsername doesn't exist";
    }
  }

?>

<!DOCTYPE HTML> 
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="styles/login/css/style.css">
    <script src="./etc/js/functions.js"></script>
    <title>Login - Verobox</title>
  </head>

  <body id="body">

    <div class="login-box">
        
        <img src=".\styles\login\images\login-user-avatar-icon.png" class="login-avatar">
        <!--welcome to login page message-->
        <div class="welcome-message">Verobox</div>

        <!--login form-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <input type="text" id="username" name="loginUsername" placeholder="Enter your username" value= "<?php echo $givenUsername?>" required="username is required" autofocus>
          <div class="error"><?php echo $usernameErr;?></div><br>
          <input type="password" id="password" name="loginPassword" placeholder="Enter your password"  required="password is required">
          <div class="error"><?php echo $passwordErr;?></div><br>
          <input type="submit" value="Login">
        </form>

        <a href='./register.php'>Δεν έχεις λογαριασμό?</a>
    </div>




    <!--JAVASCRIPT-->
    <script>
      document.getElementById("body").onload = function() {toast("toastId")};
    </script>

  </body>
</html>