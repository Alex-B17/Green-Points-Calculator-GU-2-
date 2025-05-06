<?php
// Start session if not already started
if (session_id() == '') {
    session_start();
}

require('connect_db.php');
$errors = [];

if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot_password.php");
    exit();
}

$user_id = $_SESSION['reset_user_id'];
$security_question = $_SESSION['security_question'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $security_answer = !empty($_POST['security_answer']) ? mysqli_real_escape_string($link, trim($_POST['security_answer'])) : null;

    if (!$security_answer) {
        $errors[] = 'Please provide an answer to the security question.';
    }

    if (empty($errors)) {
        // Check if the security answer matches
        $check_q = "SELECT security_answer_hash FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $check_q)) {
            mysqli_stmt_bind_param($stmt, 'i', $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $stored_answer_hash);
            mysqli_stmt_fetch($stmt);

            if (password_verify($security_answer, $stored_answer_hash)) {
                // Answer is correct, allow password reset
                header("Location: reset_password.php");
                exit();
            } else {
                $errors[] = 'Incorrect answer. Please try again.';
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>Verify Security Answer</title>
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="text-center text-white">Verify Your Identity</h1>

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

    <form action="verify_security_answer.php" method="post" class="bg-dark p-4 rounded shadow">
        <div class="form-group mb-3">
            <label for="security_question"><?php echo $security_question; ?></label>
        </div>
        <div class="form-group mb-3">
            <label for="security_answer">Your Answer</label>
            <input type="text" class="form-control" name="security_answer" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>

    <p class="text-center mt-3 text-white">Go back to <a href="forgot_password.php" class="text-primary">Forgot Password</a></p>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
