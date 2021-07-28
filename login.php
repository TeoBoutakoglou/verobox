<!--check credentials for login--> 
<?php
  include_once './etc/php/functions.php';

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
  echo get_flash_message('successfulRegistrationMessage');

  //Get successful logout message
  ?>

  
  <div class="toast-logout hide">
    <span class="message"> logout success. replace with php message. </span> <?php// echo get_flash_message('successfulLogoutMessage');?>
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
        $passwordErr = 'wrong password';
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
      $usernameErr = 'no such username';
    }
  }

?>

<!DOCTYPE HTML> 
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="styles/login/css/style.css">
    <title>Login - Verobox</title>
  </head>

  <body id="myDIV">

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




    <!--JAVASCRIPT-->
    <script>
    document.getElementById("myDIV").onload = function() {myFunction()};
    function myFunction(){
      var element = document.getElementById("myDIV");
      element.classList.add("show");
      element.classList.add("alert");
      element.classList.remove("hide");
      //$('.toast-logout').addClass("show");
      //$('.toast-logout').addClass("alert");
      //$('.toast-logout').removeClass("hide");
      setTimeout(function(){
        element.classList.remove("show");
        element.classList.add("hide");
        // $('.toast-logout').removeClass("show");
        // $('.toast-logout').addClass("hide");
      }, 5000);
    }
  </script>

  </body>
</html>