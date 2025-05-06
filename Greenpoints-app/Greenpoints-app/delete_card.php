<?php
session_start();

if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load();
}

require('connect_db.php');

if (isset($_GET['card_id']) && !empty($_GET['card_id'])) {
    $card_id = $_GET['card_id'];

    // Delete the card from the database
    $q = "DELETE FROM card_details WHERE card_id = '$card_id' AND user_id = {$_SESSION['id']}";
    if (mysqli_query($link, $q)) {
        // Redirect back to user account page with success message
        header("Location: user_account.php?msg=card_deleted");
        exit; // Always call exit after header redirection
    } else {
        // Redirect with error message if deletion fails
        header("Location: user_account.php?msg=error");
        exit;
    }
} else {
    // Redirect to user account page if no card ID is provided
    header("Location: user_account.php?msg=error");
    exit;
}

mysqli_close($link);
