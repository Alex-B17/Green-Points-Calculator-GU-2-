<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('connect_db.php');

// Error reporting (development only — disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_page = basename($_SERVER['PHP_SELF']);
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $email = mysqli_real_escape_string($link, trim($_POST['email']));
    $password = trim($_POST['password']);

    // Query to find user by email
    $q = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($link, $q)) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // Check password
            if (password_verify($password, $row['password'])) {
                // ✅ Set session variables (must match what nav.php checks for)
                $_SESSION['id'] = $row['user_id'];
                $_SESSION['username'] = $row['first_name'];
                $_SESSION['email'] = $row['email'];

                // Redirect to home or dashboard
                header('Location: home.php');
                exit();
            } else {
                $error = 'Invalid password. Please try again.';
            }
        } else {
            $error = 'Invalid email address. Please try again.';
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>Login</title>
    <style>
        label { color: white; }
    </style>
</head>
<body>

<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="text-center text-white">Login</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST" class="bg-dark p-4 rounded shadow">
        <div class="form-group mb-3">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group mb-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <a href="forgot_password.php" class="text-primary">Forgot Password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3 text-white">
        Don't have an account yet? 
        <a href="sign_up.php" class="text-primary">Sign Up here</a>
    </p>
</div>

<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
