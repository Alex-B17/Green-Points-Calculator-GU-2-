<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQs and Terms and Conditions</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="includes/Greenptsformat.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>
  
<?php
# Include navbar before anything else
include('includes/nav.php');  // Include the navbar for consistent navigation

# Check if the cart is empty or total is invalid
if (empty($_SESSION['cart']) || !isset($_GET['total']) || $_GET['total'] <= 0) {
    echo '<p>No items in cart or invalid total.</p>';
    include('includes/footer.php');  // Include footer (important for consistent design)
    exit();  // Stop the script
}

# Open database connection
require('connect_db.php');

# Insert order into the 'orders' table
$orderTotal = $_GET['total']; // Get total amount from URL query
$userId = $_SESSION['id'];  // Get the user ID from the session

$query = "INSERT INTO orders (user_id, total, order_date, status) VALUES ($userId, $orderTotal, NOW(), 'pending')";
if (mysqli_query($link, $query)) {
    $orderId = mysqli_insert_id($link);  // Get the order ID of the newly inserted order

    # Now, insert items into the 'order_items' table (or whatever table stores the cart items)
    foreach ($_SESSION['cart'] as $movieId => $item) {
        $movieId = $movieId;  // Movie ID
        $quantity = $item['quantity'];  // Quantity of items
        $price = $item['price'];  // Price per item

        $query = "INSERT INTO order_items (order_id, movie_id, quantity, price) VALUES ($orderId, $movieId, $quantity, $price)";
        mysqli_query($link, $query);
    }

    # Clear the cart after the order is placed
    $_SESSION['cart'] = [];

    # Display the order confirmation message
    echo '<div class="container">';
    echo '<p>Your order has been successfully placed!</p>';
    echo '<p>Order Reference: #' . str_pad($orderId, 6, '0', STR_PAD_LEFT) . '</p>';
    echo '<p>Total Paid: £' . number_format($orderTotal, 2) . '</p>';
    echo '</div>';

} else {
    echo '<p>There was an error placing your order. Please try again later.</p>';
}

# Close the database connection
mysqli_close($link);

# Include footer for consistent design
include('includes/footer.php');
?>
