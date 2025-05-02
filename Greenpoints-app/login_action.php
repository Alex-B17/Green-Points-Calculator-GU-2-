<?php # PROCESS LOGIN ATTEMPT.

# Start session at the beginning
session_start();

# Check if the user is already logged in
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // If user is already logged in, redirect to the user account page or home page
    header("Location: user_account.php");  // You can change this to home.php if needed
    exit();
}

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require('connect_db.php');

    # Get connection, load, and validate functions.
    require('login_tools.php');

    # Check login.
    list($check, $data) = validate($link, $_POST['email'], $_POST['password']);

    # On success set session data and display logged in page.
    if ($check) {
        # Access session.
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];

        # Redirect to home or user account page after successful login
        header('Location: home.php'); // Or you can use 'user_account.php' depending on where you want the user to land
        exit();
    } else {
        # Or on failure set errors.
        $errors = $data;
    }

    # Close database connection.
    mysqli_close($link);
}

# Continue to display login page on failure.
include('login.php');
?>
