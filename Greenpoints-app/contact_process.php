<?php
require('connect_db.php'); // make sure this connects to your DB

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $firstname = mysqli_real_escape_string($link, trim($_POST['firstname']));
    $lastname = mysqli_real_escape_string($link, trim($_POST['lastname']));
    $email = mysqli_real_escape_string($link, trim($_POST['email']));
    $message = mysqli_real_escape_string($link, trim($_POST['message']));

    if ($firstname && $lastname && $email && $message) {
        $q = "INSERT INTO feedback (firstname, lastname, email, message) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $q);
        mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $email, $message);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to contact page with a success query string
            header("Location: contact.php?success=1");
        } else {
            header("Location: contact.php?error=1");
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: contact.php?error=1");
    }

    mysqli_close($link);
} else {
    header("Location: contact.php");
}
