<?php
// Ensure no debug output is printed on the page
// Comment out or remove debug settings
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

include('includes/nav.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Card</title>
    <link rel="stylesheet" type="text/css" href="includes/Cinema.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Function to confirm navigation back to the user account page
        function confirmReturnToAccount() {
            var userConfirmed = confirm("Card details updated successfully! Do you want to return to your account page?");
            if (userConfirmed) {
                window.location.href = 'user_account.php'; // Redirect to user account page
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1>Update Card Details</h1>

        <br>

        <?php
        session_start();

        if (!isset($_SESSION['id'])) {
            require('login_tools.php');
            load();
        }

        require('connect_db.php');

        // Check if card_id is passed in the URL
        if (isset($_GET['card_id']) && !empty($_GET['card_id'])) {
            $card_id = $_GET['card_id'];

            // Retrieve the card details from the database
            $q = "SELECT * FROM card_details WHERE card_id = '$card_id' AND user_id = {$_SESSION['id']}";
            $r = mysqli_query($link, $q);

            if (mysqli_num_rows($r) > 0) {
                $card = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $cardholder_name = $card['cardholder_name'];
                $card_number = $card['card_number'];
                $expiry_date = $card['expiry_date']; // Ensure expiry_date is in MM/YY format
                $cvv = $card['cvv'];
            } else {
                echo "<div class='alert alert-danger'>Card not found or you do not have permission to update it.</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-danger'>No card ID provided in the URL.</div>";
            exit;
        }

        // Handle form submission to update card
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cardholder_name = mysqli_real_escape_string($link, $_POST['cardholder_name']);
            $card_number = mysqli_real_escape_string($link, $_POST['card_number']);
            $expiry_date = mysqli_real_escape_string($link, $_POST['expiry_date']);
            $cvv = mysqli_real_escape_string($link, $_POST['cvv']);

            // Update the card details in the database (expiry_date stays in MM/YY format)
            $q = "UPDATE card_details SET cardholder_name = '$cardholder_name', card_number = '$card_number', expiry_date = '$expiry_date', cvv = '$cvv' WHERE card_id = '$card_id' AND user_id = {$_SESSION['id']}";
            if (mysqli_query($link, $q)) {
                echo "<div class='alert alert-success'>Card details updated successfully!</div>";

                // Trigger the confirmation pop-up using JavaScript
                echo "<script>confirmReturnToAccount();</script>";
            } else {
                echo "<div class='alert alert-danger'>Error updating card: " . mysqli_error($link) . "</div>";
            }
        }
        ?>

        <form action="update_card.php?card_id=<?php echo $card_id; ?>" method="POST">
            <div class="form-group">
                <label for="cardholder_name">Cardholder Name</label>
                <input type="text" class="form-control" name="cardholder_name" value="<?php echo $cardholder_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" class="form-control" name="card_number" value="<?php echo $card_number; ?>" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date (MM/YY)</label>
                <input type="text" class="form-control" name="expiry_date" value="<?php echo $expiry_date; ?>" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" name="cvv" value="<?php echo $cvv; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Card</button>
        </form>
    </div>

    <br>
    <br>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
