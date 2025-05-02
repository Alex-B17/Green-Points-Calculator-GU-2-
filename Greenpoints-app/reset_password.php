<?php
require('connect_db.php');

$errors = [];

// 1. Check if token is in URL
if (!isset($_GET['token'])) {
    die('Invalid request.');
}

$token = mysqli_real_escape_string($link, $_GET['token']);

// 2. Validate the token
$q = "SELECT id, email FROM users WHERE reset_token = ? AND token_expires > NOW()";
$stmt = mysqli_prepare($link, $q);
mysqli_stmt_bind_param($stmt, 's', $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    die('Invalid or expired token.');
}

$user = mysqli_fetch_assoc($result);

// 3. If form submitted, validate and reset password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass1 = trim($_POST['pass1']);
    $pass2 = trim($_POST['pass2']);

    if ($pass1 !== $pass2) {
        $errors[] = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $pass1)) {
        $errors[] = 'Password must be at least 8 characters and contain letters and numbers.';
    }

    if (empty($errors)) {
        $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
        $update_q = "UPDATE users SET password = ?, reset_token = NULL, token_expires = NULL WHERE id = ?";
        $stmt = mysqli_prepare($link, $update_q);
        mysqli_stmt_bind_param($stmt, 'si', $hashed_password, $user['id']);
        mysqli_stmt_execute($stmt);
        echo "<p>Password has been reset. <a href='login.php'>Login</a></p>";
        exit;
    }
}
?>

<!-- 4. Show reset form -->
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<h2>Reset Your Password</h2>

<?php if (!empty($errors)): ?>
    <div>
        <?php foreach ($errors as $msg) echo "<p>$msg</p>"; ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <label>New Password:</label><br>
    <input type="password" name="pass1" required><br><br>
    <label>Confirm Password:</label><br>
    <input type="password" name="pass2" required><br><br>
    <button type="submit">Reset Password</button>
</form>
</body>
</html>
