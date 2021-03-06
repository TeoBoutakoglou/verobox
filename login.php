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
  <div class="login-toast hide" id="loginToastId">
    <i class="fas fa-check-circle"></i>
    <span class="login-toast-message"><?php echo get_toast_message('successfulLogoutMessage'); echo get_toast_message('successfulRegistrationMessage');?></span> 
  </div>
  
<?php
  //this 2 lines needs to be after login-toast div element
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/login/css/style.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
          
          <div class="input-box">
            <i class="fa fa-user"></i>
            <input type="text" id="username" name="loginUsername" placeholder="Enter your username" value= "<?php echo $givenUsername?>" required="username is required" autofocus>
          </div>
          
          <div class="input-box">
            <i class="fa fa-key"></i>
            <input type="password" id="password" name="loginPassword" placeholder="Enter your password"  required="password is required">
          </div>
          
          <input type="submit" value="Login">
        </form>

        <a href='./register.php'>?????? ?????????? ?????????????????????</a>

        <div class="input-error"><?php echo $usernameErr; echo $passwordErr;?></div>
    </div>




    <!--JAVASCRIPT-->
    <script>
      document.getElementById("body").onload = function() {login_toast("loginToastId")};
    </script>

  </body>
</html>