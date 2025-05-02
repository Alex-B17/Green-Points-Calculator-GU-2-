<?php
// Include the navigation bar
include('includes/nav.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

# Start session
session_start();

# Redirect if not logged in
if (!isset($_SESSION['id'])) { 
    require('login_tools.php'); 
    load(); 
}

# Include database connection
require('connect_db.php');

# Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Collect the entered card details
    $cardholder_name = mysqli_real_escape_string($link, trim($_POST['cardholder_name']));
    $card_number = mysqli_real_escape_string($link, trim($_POST['card_number']));
    $expiry_date = mysqli_real_escape_string($link, trim($_POST['expiry_date']));
    $cvv = mysqli_real_escape_string($link, trim($_POST['cvv']));
    $user_id = $_SESSION['id'];  # User ID from session

    # Validate card number (simple length check, can be more complex)
    if (strlen($card_number) != 16) {
        $error = 'Invalid card number. It must be 16 digits long.';
    } 
    # Validate CVV (3 digits, change based on your card type)
    elseif (strlen($cvv) != 3) {
        $error = 'Invalid CVV. It must be 3 digits long.';
    }
    # If no errors, proceed with inserting data
    else {
        # Prepare the SQL query to insert the card details into the database
        $q = "INSERT INTO card_details (user_id, cardholder_name, card_number, expiry_date, cvv) 
              VALUES ('$user_id', '$cardholder_name', '$card_number', '$expiry_date', '$cvv')";

        # Execute the query and check for errors
        if (mysqli_query($link, $q)) {
            $success = 'Card details added successfully!';
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Add New Card</h1>

    <!-- Display error or success messages -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Form to add card details -->
    <form action="add_card.php" method="POST">
        <div class="form-group">
            <label for="cardholder_name" class="text-white">Cardholder Name</label>
            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Enter name of cardholder (in full)" required>
        </div>
        <div class="form-group">
            <label for="card_number" class="text-white">Card Number</label>
            <input type="text" class="form-control" id="card_number" name="card_number" placeholder="**** **** **** **** (16 digits)" required>
        </div>
        <div class="form-group">
            <label for="expiry_date" class="text-white">Expiry Date</label>
            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
        </div>
        <div class="form-group">
            <label for="cvv" class="text-white">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="*** (3 digits)" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add Card</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<br>
<br>

<?php
// Include the footer bar
include('includes/footer.php');
?>
