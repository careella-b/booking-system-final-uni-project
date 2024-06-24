<?php
// Session variables are stored in a folder specified below

//Care's sessionData path
//ini_set( "session.save_path", "/home/unn_w19015711/sessionData" );

//Tahmidha's sessionData path
ini_set( "session.save_path", "/home/unn_w17017369/public_html/sessionData" );

// Create a new session with a session ID
session_start();

<<<<<<< HEAD:form-submitted.php
//Form validation script 
include( 'contacr-us-validation.php' );

=======
>>>>>>> origin/main:registrationProcess.php
?>

<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Custom styles for this website -->
<link href="loginProcess.css" rel="stylesheet">

<!-- Font Awesome Kit --> 
<script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script> 

<!-- Favicon for iOS Safari, Android Chrome, Windows 8 and 10, Mac OS El Capitan Safari, Classic, desktop browsers and Manifest -->
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#573c79">
<meta name="msapplication-TileColor" content="#573c79">
<meta name="theme-color" content="#573c79">
<title>Registration - Teaven</title>
</head>
<body>
<!-- Navbar-->
<nav class="navbar navbar-expand-lg py-3 navbar-dark shadow-sm">
  <div class="container"> <a href="home.php" class="navbar-brand"> 
    <!-- Logo Image - aligning left hand side of the screen --> 
    <img src="img/teavenLogoThree-purple.png" class="logo" alt="" class="d-inline-block align-middle mr-2"> </a> 
    <!-- Nav toggle button (hamburger menu) - this toggle appears when a user is in mobile/ tablet view -->
    <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
    <!-- Nav content - Home, Shop, Our Story, Contact, Cart, Account, Login/Logout -->
    <div id="navbarSupportedContent" class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="home.php" class="nav-link">HOME</a></li>
        <li class="nav-item"><a href="shop.php" class="nav-link">SHOP</a></li>
        <li class="nav-item"><a href="ourStory.php" class="nav-link">OUR STORY</a></li>
        <li class="nav-item"><a href="findUs.php" class="nav-link active">CONTACT</a></li>
        <li class="nav-item"><a href="shoppingCart.php" class="nav-link">CART<i class="fas fa-shopping-cart"></i></a></li>
        
        <!-- This checks if user is logged-in, if so shows log out button and allows access to account page but if not then shows log in button and restricts access to account page. -->
        <?php
        try {
          require_once( "functions.php" );
          //Check if the user logs in, if so then shows the log out button but if not then shows login button. Try and catch to catch any errrors.

          if ( isset( $_SESSION[ 'logged-in' ] ) ) {
            if ( check_login() ) {
              echo "<li class='nav-item'><a href='customerAccount.php' class='nav-link'>ACCOUNT<i class='fas fa-user-circle'></i></a></li>
			  <li class='nav-item'><a href='logout.php' class='nav-link'>LOGOUT</a></li>"; // Logout button
            }
          } else {
            echo "<li class='nav-item'><a href='restricted.php' class='nav-link'>ACCOUNT<i class='fas fa-user-circle'></i></a></li>
			<li class='nav-item'><a href='loginForm.php' class='nav-link'>LOGIN</a></li>"; // Login button
          }
        } catch ( Exception $e ) {
          //Output error message
          echo "<p>problem occured</p>\n";
          //Log error
          log_error( $e );
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
<!-- End of Nav --> 
<main>
		<?php
		//Retrieve variables from login form
		$firstname = filter_has_var(INPUT_POST, 'firstname') ? $_POST['firstname'] : null;
		$surname = filter_has_var(INPUT_POST, 'surname') ? $_POST['surname'] : null;
		$username = filter_has_var(INPUT_POST, 'username') ? $_POST['username'] : null;
		$newpassword = filter_has_var(INPUT_POST, 'newPassword') ? $_POST['newPassword'] : null;
		$confirmpassword = filter_has_var(INPUT_POST, 'confirmPassword') ? $_POST['confirmPassword'] : null;
		$referer = filter_has_var(INPUT_POST, 'referer') ? $_POST['referer']: null;
		
		//Remove whitespace from variables
		$firstname = trim($firstname);
		$surname = trim($surname);
		$username = trim($username);
		$newpassword = trim($newpassword);
		$confirmpassword = trim($confirmpassword);
		
		//Check if first name, last name , username, password is empty
		if (empty($firstname) || empty($surname) || empty($username) || empty($newpassword) || empty($confirmpassword)) {
			//If empty display message
			echo "<h1>REGISTRATION FAILED</h1>
			<p>Please <a href='registration.php'>try again.</a></p>\n";
		}
	    //Check if bith passwords are the same
		else if ($newpassword != $confirmpassword) {
			//If not display error message
			echo "<h1>REGISTRATION FAILED</h1>
			<p>Please <a href='registration.php'>try again.</a></p>\n";
		}
		else {
			//set cost and store in variable
			$option = ['cost' => 12,];
			//hash password to store in database
			$passwordHash = password_hash($newpassword, PASSWORD_DEFAULT, $option);
			
			try {
				//connect to databse
				require_once("functions.php");
				$dbConn = getConnection();
				
				//Insert new user record into databse
				$querySQL = "INSERT INTO teaven_users (firstname, surname, username, password_hash) VALUES (:firstname, :surname, :username, :password_hash)";
				
				//use prepared statement to execute query
				$stmt = $dbConn->prepare($querySQL);
				$stmt->execute(array(':firstname' => $firstname, ':surname' => $surname, ':username' => $username, ':password_hash' => $passwordHash));
				
				//use select query to retrieve usernames from databse
				$selectSQL = "SELECT username
							FROM teaven_users";
				//execute query and fetch data
				$queryResult = $dbConn->query( $selectSQL );
          		$user = $queryResult->fetchObject();
				
				if ($user) {
					//check if username already exists in databse
					if ($username == ':username') {
						//if it does display error message
						echo "<h1>This username is taken.</h1>\n
						<p>Please <a href='registration.php'>try again.</a></p>\n";
					} 
					else {
						//If username does not exist check if referer is the same as continue page url
						//Tahmidha
						if ($referer == 'http://unn-w17017369.newnumyspace.co.uk/site/continue.php') {
							
						//Care
						//if ($referer == 'http://unn-w19015711.newnumyspace.co.uk/continue.php') {
							
							//If it is redirect browser to checkout page
							header('Location: checkoutt.php');
						}
						else {
							//if not redirect to home page
							header('Location: home.php');
						}
					}
				}
			}
			catch (Exception $e) {
	        	//Output error message
	  			echo "<p>Sorry there was a problem. Please <a href='$referer'>try again.</a></p>\n";
	  			//Log errors
	  			log_error($e);
			}
		}
		?>
</main>
<!-- End of main --> 

<!-- FOOTER --> 
<!-- Footer contains 2 rows and 3 columns of content. All columns are wrapped together using 'container' class and 'row' class --> 
<!-- First column contains the logo and social media icons. Those icons are from Font Awesome -->
<footer>
  <div class="footer">
    <div class="container"> 
      <!-- First row -->
      <div class="row">
        <div class="col-lg-5 col-xs-12"> <img  src="img/teavenLogo.png" class="footer-logo"/>
          <div class="footer-socialmedia text-center"> <a href="#"><i class="fab fa-facebook-f"></i></a> <a href="#"><i class="fab fa-twitter"></i></a> <a href="#"><i class="fab fa-instagram"></i></a> <a href="#"><i class="fab fa-youtube"></i></a> </div>
        </div>
        <!-- Second column contains a list of our three main content - Shop, Our Story and Contact -->
        <div class="col-lg-3 col-xs-12 links text-center">
          <h3>USEFUL LINKS</h3>
          <ul class="m-0 p-0 " >
            <li><a href="shop.php">Shop</a></li>
            <li><a href="ourStory.php">Our Story</a></li>
            <li><a href="findUs.php">Contact</a></li>
          </ul>
        </div>
        <!-- Third column contains our contact info. The phone number and email are clickable so a user can contact us just by clicking the links -->
        <div class="col-lg-4 col-xs-12 location text-center">
          <h3>CONTACT INFO</h3>
          <p>22, Lorem ipsum dolor</p>
          <p><a href="tel:5417543010" class="phone-link"><i class="fa fa-phone mr-3"></i>(541) 754-3010</a></p>
          <p><a href="mailto:hello@teaven.com" class="email-link"><i class="fa fa-envelope-o mr-3"></i>hello@teaven.com</a></p>
        </div>
      </div>
      <!-- Second row --> 
      <!-- This copyright text takes the full width of the column -->
      <div class="row mt-3">
        <div class="col copyright text-center">
          <p class="pt-4"><small class="text-white-50">&copy; 
            <!-- This javascript snippet will automatically update the copyright year, depending on the user's time settings --> 
            <script type="text/javascript">
				  document.write(new Date().getFullYear());
			  </script>Teaven. All Rights Reserved.</small></p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Optional JavaScript --> 
<!-- jQuery first, then Popper.js, then Bootstrap JS --> 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
<!-- Font Awesome Kit - this is link to an account --> 
<script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script> 
<!-- CUSTOM JAVASCRIPT FOR THIS WEBSITE --> 
<script src="script.js" type="text/javascript"></script>
</body>
</html>