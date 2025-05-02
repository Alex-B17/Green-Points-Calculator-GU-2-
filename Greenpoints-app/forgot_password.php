<?php
// Start session if not already started
if (session_id() == '') {
    session_start();
}

require('connect_db.php');
$errors = [];
$success = false;
$email_checked = false;
$email = '';
$user_id = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($link, trim($_POST['email'])) : null;

    if (!$email) {
        $errors[] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Step 1: Check if email exists
    if (empty($errors)) {
        $q = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $q)) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $user_id);
                mysqli_stmt_fetch($stmt);
                $email_checked = true;
            } else {
                $errors[] = 'Email not found. Please check and try again.';
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Step 2: If passwords are submitted, validate and update
    if ($email_checked && isset($_POST['pass1'], $_POST['pass2'])) {
        $pass1 = trim($_POST['pass1']);
        $pass2 = trim($_POST['pass2']);

        if ($pass1 !== $pass2) {
            $errors[] = 'Passwords do not match.';
        } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $pass1)) {
            $errors[] = 'Password must be at least 8 characters and contain both letters and numbers.';
        }

        if (empty($errors)) {
            $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
            $update_q = "UPDATE users SET password = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $update_q)) {
                mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $success = true;
            } else {
                $errors[] = 'An error occurred while updating your password.';
            }
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>Forgot Password</title>
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="text-center text-white">Forgot Password</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <h5>The following error(s) occurred:</h5>
            <ul>
                <?php foreach ($errors as $msg): ?>
                    <li><?php echo $msg; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success text-center">
            <p>Password reset successful!</p>
            <a href="login.php" class="btn btn-success">Return to Login</a>
        </div>
    <?php else: ?>
        <form action="forgot_password.php" method="post" class="bg-dark p-4 rounded shadow">
            <!-- Email Input -->
            <div class="form-group mb-3">
                <label for="email" class="text-white">Email address</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?php echo htmlspecialchars($email); ?>" required <?= $email_checked ? 'readonly' : '' ?>>
            </div>

            <?php if ($email_checked): ?>
                <!-- New Password -->
                <div class="form-group mb-3">
                    <label for="pass1" class="text-white">New Password</label>
                    <input type="password" class="form-control" id="pass1" name="pass1" required>
                </div>

                <!-- Confirm New Password -->
                <div class="form-group mb-3">
                    <label for="pass2" class="text-white">Confirm New Password</label>
                    <input type="password" class="form-control" id="pass2" name="pass2" required>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">
                <?php echo $email_checked ? 'Reset Password' : 'Verify Email'; ?>
            </button>
        </form>
    <?php endif; ?>

    <p class="text-center mt-3 text-white">Remembered your password?
        <a href="login.php" class="text-primary">Login here</a></p>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
