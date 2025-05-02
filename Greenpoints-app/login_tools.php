<?php # LOGIN HELPER FUNCTIONS.

# Function to load specified or default URL.
function load( $page = 'login.php' )
{
    # Begin URL with protocol, domain, and current directory.
    $url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] );

    # Remove trailing slashes then append page name to URL.
    $url = rtrim( $url, '/\\' );
    $url .= '/' . $page ;

    # Execute redirect then quit. 
    header( "Location: $url" );
    exit();
}

# Function to check if the user is already logged in.
function check_logged_in() {
    # Start session if it's not already started
    if (session_id() == '') {
        session_start();
    }

    # If session variables are set, the user is logged in.
    if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}

# Function to check email address and password. 
function validate( $link, $email = '', $pwd = '')
{
    # Initialize errors array.
    $errors = array();

    # Check email field.
    if (empty($email)) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($email));
    }

    # Check password field.
    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $p = mysqli_real_escape_string($link, trim($pwd));
    }

    # On success retrieve id, username, from 'new_users' table.
    if (empty($errors)) {
        $q = "SELECT id, username FROM new_users WHERE email='$e' AND password=SHA2('$p',256)";
        $r = mysqli_query($link, $q);
        if (@mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(true, $row);
        }
        # Or on failure set error message.
        else {
            $errors[] = 'Email address and password not found.';
        }
    }
    # On failure retrieve error message/s.
    return array(false, $errors);
}

# Function to handle user login. 
function login_user($email, $password) {
    require('connect_db.php');
    
    list($check, $data) = validate($link, $email, $password);

    if ($check) {
        session_start();
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        load('home.php');  // Or 'user_account.php', depending on where you want them to go after login.
    } else {
        return $data;  // Return errors if login fails
    }

    mysqli_close($link);
}

?>
