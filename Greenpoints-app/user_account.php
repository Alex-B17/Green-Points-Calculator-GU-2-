<?php
// Start the session at the very beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load(); // This will redirect to login.php
}

// Include the navbar since the user is logged in
include('includes/nav.php');
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <title>User Account</title>
    <link rel="stylesheet" type="text/css" href="includes/Greenptsformat.css">
</head>
<body>
    <br>
    <div class="wrapper">
        <div class="content Section2">
            <?php
            require('connect_db.php');

            // Check if there's a message to display (success/error)
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'card_updated') {
                    echo '<div class="alert alert-success">Card updated successfully.</div>';
                } elseif ($_GET['msg'] == 'card_added') {
                    echo '<div class="alert alert-success">New card added successfully.</div>';
                } elseif ($_GET['msg'] == 'card_deleted') {
                    echo '<div class="alert alert-success">Card deleted successfully.</div>';
                } elseif ($_GET['msg'] == 'error') {
                    echo '<div class="alert alert-danger">Error occurred. Please try again later.</div>';
                }
            }

            // Retrieve user details with improved SQL query
            $user_id = mysqli_real_escape_string($link, $_SESSION['id']);
            $q = "SELECT * FROM new_users WHERE id=$user_id";
            $r = mysqli_query($link, $q);
            if (mysqli_num_rows($r) > 0) {
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    $date = $row["created_at"];
                    $day = substr($date, 8, 2);
                    $month = substr($date, 5, 2);
                    $year = substr($date, 0, 4);

                    echo "
                    <h1>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</h1>
                    <hr>
                    <p>User ID: EC2024/{$row['id']}</p>
                    <hr>
                    <p>Email: " . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</p>
                    <hr>
                    <p>Registration Date: $day/$month/$year</p>
                    <hr>
                    ";
                }
            } else {
                echo '<h3>No user details available.</h3>';
            }

            // Retrieve saved card details with improved SQL query
            $q = "SELECT * FROM card_details WHERE user_id = '$user_id'";
            $r = mysqli_query($link, $q);
            if (mysqli_num_rows($r) > 0) {
                while ($card = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    $card_id = $card['card_id']; // Ensure you're using 'card_id' here
                    $cardholder_name = $card['cardholder_name'];
                    $card_number = $card['card_number'];
                    $expiry_date = $card['expiry_date'];
                    $cvv = $card['cvv'];

                    // Mask the card number and CVV
                    $masked_card_number = str_repeat('**** ', 3) . substr($card_number, -4);
                    $masked_cvv = '**' . substr($cvv, -1);

                    echo "<hr><h3>Your Saved Card Details</h3>";
                    echo "<p><strong>Cardholder Name:</strong> " . htmlspecialchars($cardholder_name, ENT_QUOTES, 'UTF-8') . "</p>";
                    echo "<p><strong>Card Number:</strong> $masked_card_number</p>";
                    echo "<p><strong>Expiry Date:</strong> " . htmlspecialchars($expiry_date, ENT_QUOTES, 'UTF-8') . "</p>";
                    echo "<p><strong>CVV:</strong> $masked_cvv</p>";

                    echo "
                        <a href='update_card.php?card_id=$card_id' class='btn btn-warning'>Update Card</a>
                        <a href='delete_card.php?card_id=$card_id' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this card?\")'>Delete Card</a>
                    ";
                }
            } else {
                echo "<hr><p>No saved card details found.</p>";
            }

            mysqli_close($link);
            ?>

            <!-- Add New Card Button -->
            <a href="add_card.php" class="btn btn-primary">Add New Card</a>

        </div>

        <br><br><br><br><br><br><br><br>
        
        <!-- Footer -->
        <?php include('includes/footer.php'); ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
