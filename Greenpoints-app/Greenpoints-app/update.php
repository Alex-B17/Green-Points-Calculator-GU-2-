<?php
// update.php - Process the submitted form data

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $jobtitle = $_POST['jobtitle']; // You might need to check which radio button is selected
    $message = $_POST['message'];

    // Here you can add your code to process the data, like inserting it into a database or sending an email
    // Example: Insert into a database

    // Assuming you have a database connection
    include('connect_db.php');

    $query = "INSERT INTO reviews (firstname, lastname, email, phone, jobtitle, message) 
              VALUES ('$firstname', '$lastname', '$email', '$phone', '$jobtitle', '$message')";

    if (mysqli_query($link, $query)) {
        echo "Thank you for your message!";
    } else {
        echo "Error: " . mysqli_error($link);
    }

    // Close the database connection
    mysqli_close($link);
}
?>
