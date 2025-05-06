<?php
// Start session at the top, only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    require('login_tools.php');
    load();
}

// Include database connection
require('connect_db.php');

// Handle GET request to prefill form
if (isset($_GET['card_id']) && !empty($_GET['card_id'])) {
    $card_id = mysqli_real_escape_string($link, $_GET['card_id']);

    $q = "SELECT * FROM card_details WHERE card_id = '$card_id' AND user_id = {$_SESSION['id']}";
    $r = mysqli_query($link, $q);

    if (mysqli_num_rows($r) > 0) {
        $card = mysqli_fetch_array($r, MYSQLI_ASSOC);
    } else {
        die('<div class="alert alert-danger">Card not found or access denied.</div>');
    }
} else {
    die('<div class="alert alert-danger">No card ID provided.</div>');
}

// Handle POST request for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardholder_name = mysqli_real_escape_string($link, $_POST['cardholder_name']);
    $card_number = mysqli_real_escape_string($link, $_POST['card_number']);
    $expiry_date = mysqli_real_escape_string($link, $_POST['expiry_date']);
    $cvv = mysqli_real_escape_string($link, $_POST['cvv']);

    $q = "UPDATE card_details 
          SET cardholder_name = '$cardholder_name', card_number = '$card_number', expiry_date = '$expiry_date', cvv = '$cvv' 
          WHERE card_id = '$card_id' AND user_id = {$_SESSION['id']}";

    if (mysqli_query($link, $q)) {
        // Redirect to user_account.php with a success message
        header("Location: user_account.php?msg=card_updated");
        exit;
    } else {
        $error = "Error updating card: " . mysqli_error($link);
    }
}

include('includes/nav.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="includes/Greenptsformat.css">
</head>
<body>
<div class="container mt-5 mb-5">
    <h1 class="text-white mb-4">Update Card Details</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="update_card.php?card_id=<?php echo htmlspecialchars($card_id); ?>" method="POST" class="bg-dark text-light p-4 rounded">
        <div class="mb-3">
            <label for="cardholder_name" class="form-label">Cardholder Name</label>
            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" value="<?php echo htmlspecialchars($card['cardholder_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="card_number" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="card_number" name="card_number" value="<?php echo htmlspecialchars($card['card_number']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date (MM/YY)</label>
            <input type="text" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($card['expiry_date']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" value="<?php echo htmlspecialchars($card['cvv']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Card</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
