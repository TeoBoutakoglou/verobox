<!DOCTYPE HTML> 
<html>
  <head>
    <title>Register - Verobox</title>
    <link rel="stylesheet" type="text/css" href="styles/register/css/style.css">
  </head>

  <?php
    include_once './etc/php/functions.php';

    $givenFirstName = $givenLastName = $givenUsername = $givenPassword = $givenEmail = $givenDayOfBirth = $givenMonthOfBirth = $givenYearOfBirth = $givenGender = null;
    $usernameErr = $passwordErr = $emailErr = '';
    


    // Get all the post values
    if( isset($_POST['registerFirstName']) )
    {
      $givenFirstName = $_POST['registerFirstName'];
    }

    if( isset($_POST['registerLastName']) )
    {
      $givenLastName = $_POST['registerLastName'];
    }

    if( isset($_POST['registerUsername']) )
    {
      $givenUsername = $_POST['registerUsername'];
    }

    if( isset($_POST['registerPassword']) )
    {
      $givenPassword = $_POST['registerPassword'];
    }

    if( isset($_POST['registerEmail']) )
    {
      $givenEmail = $_POST['registerEmail'];
    }

    if( isset($_POST['dayOfBirth']) && isset($_POST['monthOfBirth']) && isset($_POST['yearOfBirth']))
    {
      $givenDayOfBirth = $_POST['dayOfBirth'];
      $givenMonthOfBirth = $_POST['monthOfBirth'];
      $givenYearOfBirth = $_POST['yearOfBirth'];
      $dateOfBirth = $givenYearOfBirth . '-' . $givenMonthOfBirth . '-' .  $givenDayOfBirth;
    }

    if ( isset($_POST['gender']) )
    {
    $givenGender = $_POST['gender'];
    }


    
    if ($givenUsername == null)
    {
      //username is null at the first load of the page and create an error, by doing this php doesn't pop up the error
    }
    else if (user_exists($givenUsername))
    {
      $usernameErr = 'User ' . $givenUsername . ' already exists';
    }
    else
    { 
      //create new user in DB and file system
      create_new_user_in_db($givenFirstName, $givenLastName, $givenUsername, $givenPassword, $givenEmail, $givenGender, $dateOfBirth);
      create_new_user_in_filesystem($givenUsername);

      //redirect to login page after registration
      session_start();
      set_flash_message('successfulRegistrationMessage', $givenUsername . ', your account was successfully created, please login to start');
      redirect_to('login.php');
    }
  
    



  ?>




  <body>


    <!--register page message-->
    <h2>Register</h2>



    <!--register form-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

      <label for="lblRegisterFirstName">First name:</label><br>
      <input type="text" id="firstName" name="registerFirstName" placeholder="Enter your first name" value= "<?php echo $givenFirstName?>" autofocus><br>
      
      <label for="lblRegisterLastName">Last name:</label><br>
      <input type="text" id="lastName" name="registerLastName" placeholder="Enter your last name" value= "<?php echo $givenLastName?>"><br>

      <label for="lblRegisterUsername">Username:</label><br>
      <input type="text" id="username" name="registerUsername" placeholder="Enter your username" value= "<?php echo $givenUsername?>" required="username is required">
      <span class="error">* <?php echo $usernameErr;?></span><br>

      <label for="lblRegisterPassword">Password:</label><br>
      <input type="password" id="password" name="registerPassword" placeholder="Enter your password"  required="password is required">
      <span class="error">* <?php echo $passwordErr;?></span><br>

      <label for="lblRegisterEmail">E-mail:</label><br>
      <input type="text" id="email" name="registerEmail" placeholder="Enter your email" value= "<?php echo $givenEmail?>"  required="email is required">
      <span class="error">* <?php echo $emailErr;?></span><br>

      <label for="dateSelectRegisterDateOfBirth">Date of birth:</label><br>
      <input type="text" id="day" name="dayOfBirth" placeholder="Day" value= "<?php echo $givenDayOfBirth?>">
      <input type="text" id="month" name="monthOfBirth" placeholder="Month" value= "<?php echo $givenMonthOfBirth?>">
      <input type="text" id="year" name="yearOfBirth" placeholder="Year" value= "<?php echo $givenYearOfBirth?>"><br>

      <label for="radioButtonRegisterGender">Gender:</label><br>
      <input type="radio" id="maleGender" name="gender" value="Male" <?php if ($givenGender == 'Male') { echo 'checked'; } ?>>
      <label for="maleGender">Male</label>
      <input type="radio" id="femaleGender" name="gender" value="Female" <?php if ($givenGender == 'Female') { echo 'checked'; } ?>>
      <label for="femaleGender">Female</label><br>

      <input type="submit" value="Register">
    </form>

    <br><span class="error">* field is Required</span><br>
    <br><a href='./login.php'>Έχεις ήδη λογαριασμό?</a>

  </body>
</html>