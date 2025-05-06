<?php
// Start the session before any HTML output
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) { 
    require('login_tools.php'); 
    load(); 
}

// Include the navigation bar
include('includes/nav.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
require('connect_db.php');

// Initialize error message variable
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cardholder_name = mysqli_real_escape_string($link, trim($_POST['cardholder_name']));
    $card_number = mysqli_real_escape_string($link, trim($_POST['card_number']));
    $expiry_date = mysqli_real_escape_string($link, trim($_POST['expiry_date']));
    $cvv = mysqli_real_escape_string($link, trim($_POST['cvv']));
    $user_id = $_SESSION['id'];

    // Simple validation
    if (strlen($card_number) != 16 || !ctype_digit($card_number)) {
        $error = 'Invalid card number. It must be exactly 16 digits.';
    } elseif (strlen($cvv) != 3 || !ctype_digit($cvv)) {
        $error = 'Invalid CVV. It must be exactly 3 digits.';
    } else {
        // Insert card data
        $q = "INSERT INTO card_details (user_id, cardholder_name, card_number, expiry_date, cvv) 
              VALUES ('$user_id', '$cardholder_name', '$card_number', '$expiry_date', '$cvv')";

        if (mysqli_query($link, $q)) {
            mysqli_close($link);
            header('Location: user_account.php?msg=card_added');
            exit(); // Stop script after redirect
        } else {
            $error = 'Error adding card details: ' . mysqli_error($link);
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Card</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="includes/Greenptsformat.css">

    <!-- Google Fonts (optional) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>

<div class="container mt-5 mb-5">
    <h1 class="text-center text-white mb-4">Add New Card</h1>

    <!-- Display error message -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Form to add card details -->
    <form action="add_card.php" method="POST" class="bg-dark text-light p-4 rounded">
        <div class="mb-3">
            <label for="cardholder_name" class="form-label">Cardholder Name</label>
            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Full Name" required>
        </div>
        <div class="mb-3">
            <label for="card_number" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="card_number" name="card_number" placeholder="16-digit number" required>
        </div>
        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
        </div>
        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="3 digits" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Card</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
