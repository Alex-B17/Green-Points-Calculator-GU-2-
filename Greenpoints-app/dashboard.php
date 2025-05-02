<?php
// Start the session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the navigation
include('includes/nav.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); // Include the head.php file ?>
    <title>User Dashboard</title>
</head>
<body>

<?php
// Open database connection
require('connect_db.php');

// Check if session id is set
if (!isset($_SESSION['id'])) {
    echo '<p>User not logged in.</p>';
    exit();
}

// Retrieve user info from the 'users' table
$q = "SELECT * FROM users WHERE user_id = {$_SESSION['id']}";
$r = mysqli_query($link, $q);

if (!$r) {
    // Handle query error gracefully
    echo '<p>Error retrieving user information: ' . mysqli_error($link) . '. Please try again later.</p>';
    mysqli_close($link);
    include('includes/footer.php');
    exit();
}

// Check if we got the user data
if (mysqli_num_rows($r) == 1) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

    // Format the date fields (assuming they are stored as MySQL DATETIME)
    $last_login = date("F j, Y, g:i a", strtotime($row['last_login']));
    $date_joined = date("F j, Y", strtotime($row['date_joined']));

    // Display the user info
    echo '
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">Welcome, ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . '!</h1>
                    <p>Email: ' . htmlspecialchars($row['email']) . '</p>
                    <p>Points Balance: ' . $row['points_balance'] . ' points</p>
                    <p>Account Status: ' . ($row['active'] ? 'Active' : 'Inactive') . '</p>
                    <hr>
                    <h4>Your Recent Activities</h4>
                    <ul>
                        <li>Last login: ' . $last_login . '</li>
                        <li>Account created: ' . $date_joined . '</li>
                    </ul>
                </div>
            </div>
        </div>';
} else {
    echo '<p>User not found.</p>';
}

// Close the database connection
mysqli_close($link);
?>

<!-- Include the footer -->
<?php include('includes/footer.php'); ?>

<!-- Optional: Include JavaScript if you need any interactivity -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
