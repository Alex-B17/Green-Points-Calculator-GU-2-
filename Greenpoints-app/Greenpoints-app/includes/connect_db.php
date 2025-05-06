<?php 
# CONNECT TO MySQL DATABASE.

# Connect/Link on 'localhost' with username, password, and database name.
$link = mysqli_connect('localhost', 'root', '', 'greenpoints');

# Check if the connection was successful
if (!$link) {
    # If there's an error, output the error message
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

# Optional: You can add this line for debugging purposes (remove in production)
# echo '<br>Connected to the database successfully!<br><br>';
?>
