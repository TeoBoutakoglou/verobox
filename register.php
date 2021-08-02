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
      set_toast_message('successfulRegistrationMessage', $givenUsername . ', your account was successfully created, please login to start');
      redirect_to('login.php');
    }
?>

<!DOCTYPE HTML> 
<html>
  <head>
  	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="styles/register/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="./etc/js/functions.js"></script>
    <title>Register - Verobox</title>
  </head>


  <body>

	<div class="register-box">
		
		<img src=".\styles\register\images\register-user-avatar-icon.png" class="register-avatar">
		<!--register page message-->
		<div class="register-message">Register</div>

		<!--register form-->
	 	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

          <div class="left-components">
                <div class="input-box">
                  <input type="text" id="firstName" name="registerFirstName" placeholder="Enter your first name" value= "<?php echo $givenFirstName?>" autofocus>
                </div>

                <div class="input-box">
                  <input type="text" id="lastName" name="registerLastName" placeholder="Enter your last name" value= "<?php echo $givenLastName?>">
                </div>

                <div class="input-box">
                  <input type="text" id="username" name="registerUsername" placeholder="Enter your username" value= "<?php echo $givenUsername?>" required="username is required">
                  <span class="input-error">* <?php echo $usernameErr;?></span>
                </div>

                <div class="input-box">
                  <input type="password" id="password" name="registerPassword" placeholder="Enter your password"  required="password is required">
                  <span class="input-error">* <?php echo $passwordErr;?></span>
                </div>
          </div>

          <div class="right-components">
                <div class="input-box">
                  <input type="text" id="email" name="registerEmail" placeholder="Enter your email" value= "<?php echo $givenEmail?>"  required="email is required">
                  <span class="input-error">* <?php echo $emailErr;?></span>
                </div>

                <div class="input-box">
                  <input type="text" id="day" name="dayOfBirth" placeholder="Day" value= "<?php echo $givenDayOfBirth?>">
                  <input type="text" id="month" name="monthOfBirth" placeholder="Month" value= "<?php echo $givenMonthOfBirth?>">
                  <input type="text" id="year" name="yearOfBirth" placeholder="Year" value= "<?php echo $givenYearOfBirth?>">
                </div>

                
                  <input type="radio" id="maleGender" name="gender" value="Male" <?php if ($givenGender == 'Male') { echo 'checked'; } ?>>
                  <label for="maleGender">Male</label>
                  <input type="radio" id="femaleGender" name="gender" value="Female" <?php if ($givenGender == 'Female') { echo 'checked'; } ?>>
                  <label for="femaleGender">Female</label>
          </div>
			    
          <input type="submit" value="Register">
		</form>

		<span class="input-error">* field is Required</span><br>
		<a href='./login.php'>Έχεις ήδη λογαριασμό?</a>
	</div>
  </body>
</html>