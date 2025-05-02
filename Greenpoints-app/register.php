<?php # DISPLAY COMPLETE REGISTRATION PAGE.
# Check form submitted.
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
  # Connect to the database.
  require ('connect_db.php'); 
  
  # Initialize an error array.
  $errors = array();

  # Check for a first name.
  if ( empty( $_POST[ 'username' ] ) )
  { $errors[] = 'Enter your name.' ; }
  else
  { $fn = mysqli_real_escape_string( $link, trim( $_POST[ 'username' ] ) ) ; }

 
  # Check for an email address:
  if ( empty( $_POST[ 'email' ] ) )
  { $errors[] = 'Enter your email address.'; }
  else
  { $e = mysqli_real_escape_string( $link, trim( $_POST[ 'email' ] ) ) ; }

  # Check for a password and matching input passwords.
  if ( !empty($_POST[ 'pass1' ] ) )
  {
    if ( $_POST[ 'pass1' ] != $_POST[ 'pass2' ] )
    { $errors[] = 'Passwords do not match.' ; }
    else
    { $p = mysqli_real_escape_string( $link, trim( $_POST[ 'pass1' ] ) ) ; }
  }
  else { $errors[] = 'Enter your password.' ; }
  
  # Check if email address already registered.
  if ( empty( $errors ) )
  {
    $q = "SELECT id FROM new_users WHERE email='$e'" ;
    $r = @mysqli_query ( $link, $q ) ;
    if ( mysqli_num_rows( $r ) != 0 ) $errors[] = 
	'Email address already registered. 
	<a class="alert-link" href="login.php">Sign In Now</a>' ;
  }
  
  

  # On success register user inserting into 'users' database table.
  if ( empty( $errors ) ) 
  {
    $q = "INSERT INTO new_users (username, email, password) 
	VALUES ('$fn', '$e', SHA2('$p',256))";
    $r = @mysqli_query ( $link, $q ) ;
    if ($r)
    { echo '
	<p>You are now registered.</p>
	<a class="alert-link" href="login.php">Login</a>
		   '
			; }
  
    # Close database connection.
    mysqli_close($link); 

    exit();
  }
  # Or report errors.
  else 
  {
    echo '
	<h4>The following error(s) occurred:</h4>' ;
    foreach ( $errors as $msg )
    { echo " - $msg<br>" ; }
    echo '<p>or please try again.</p><br>';
    # Close database connection.
    mysqli_close( $link );
  }  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>Register</h2>
	<form action="register.php" class="was-validated" method="post">
	  <label for="username">Username:</label><br>
		<input 	type="text" 
				name="username"
				placeholder="Username" 				
				class="form-control" 
				value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"
		 required> 
		<br><br>
		<label for="email">Email:</label><br>
		<input 	type="email" 
				name="email" 
				class="form-control" 
				placeholder="Email" 
				value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"
		 required><br>
		<small id="emailHelp" class="form-text text-muted">
		We'll never share your email with anyone else.
		</small>
		<br><br>
		<label for="password">Password:</label><br>
		<input 	type="password" 
				name="pass1" 
				class="form-control" 
				placeholder="Create New Password" 
				value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"
		required>
				 <br><br>
		<label for="password">Confirm Password:</label><br>
		<input 	type="password" 
				name="pass2" 
				class="form-control" 
				placeholder="Confirm Password" 
				value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" 
		required>
		<br><br>
		  <input type="submit" value="Submit"></p>
	</form>
</body>
</html>