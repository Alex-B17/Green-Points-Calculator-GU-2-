<?php
// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not logged in
if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Account</title>

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
    <?php include('includes/nav.php'); ?>

    <div class="container mt-4">
        <?php
        require('connect_db.php');

        // Success/Error messages
        if (isset($_GET['msg'])) {
            $messages = [
                'card_updated' => 'Card updated successfully.',
                'card_added' => 'New card added successfully.',
                'card_deleted' => 'Card deleted successfully.',
                'error' => 'Error occurred. Please try again later.'
            ];
            $alertClass = ($_GET['msg'] === 'error') ? 'alert-danger' : 'alert-success';

            if (array_key_exists($_GET['msg'], $messages)) {
                echo "<div class='alert $alertClass'>{$messages[$_GET['msg']]}</div>";
            }
        }

        // Fetch user details
        $user_id = mysqli_real_escape_string($link, $_SESSION['id']);
        $q = "SELECT * FROM users WHERE id=$user_id";
        $r = mysqli_query($link, $q);

        if (mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $created = date("d/m/Y", strtotime($row["created_at"]));

            echo "
            <h2 class='mb-3'>" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</h2>
            <hr>
            <p><strong>User ID:</strong> EC2024/{$row['id']}</p>
            <p><strong>Email:</strong> " . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>Registration Date:</strong> $created</p>
            ";
        } else {
            echo '<div class="alert alert-warning">No user details available.</div>';
        }

        echo "<hr><h4>Your Saved Card Details</h4>";

        // Fetch saved card details
        $q = "SELECT * FROM card_details WHERE user_id = '$user_id'";
        $r = mysqli_query($link, $q);

        if (mysqli_num_rows($r) > 0) {
            while ($card = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $masked_number = str_repeat('**** ', 3) . substr($card['card_number'], -4);
                $masked_cvv = '**' . substr($card['cvv'], -1);
                $expiry = htmlspecialchars($card['expiry_date'], ENT_QUOTES, 'UTF-8');

                echo "
                <div class='card mb-3'>
                    <div class='card-body'>
                        <p><strong>Cardholder Name:</strong> " . htmlspecialchars($card['cardholder_name'], ENT_QUOTES, 'UTF-8') . "</p>
                        <p><strong>Card Number:</strong> $masked_number</p>
                        <p><strong>Expiry Date:</strong> $expiry</p>
                        <p><strong>CVV:</strong> $masked_cvv</p>
                        <a href='update_card.php?card_id={$card['card_id']}' class='btn btn-warning btn-sm'>Update Card</a>
                        <a href='delete_card.php?card_id={$card['card_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this card?\")'>Delete Card</a>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No saved card details found.</p>";
        }

        // Close DB connection
        mysqli_close($link);
        ?>

        <!-- Add New Card Button -->
        <a href="add_card.php" class="btn btn-primary mt-3">Add New Card</a>
    </div>

    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
