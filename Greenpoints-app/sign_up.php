<?php
// Start the session if not already started
if (session_id() == '') {
    session_start();
}

require('connect_db.php');
$current_page = basename($_SERVER['PHP_SELF']);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the inputs
    $first_name = !empty($_POST['first_name']) ? mysqli_real_escape_string($link, trim($_POST['first_name'])) : null;
    $last_name = !empty($_POST['last_name']) ? mysqli_real_escape_string($link, trim($_POST['last_name'])) : null;
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($link, trim($_POST['email'])) : null;
    $password = !empty($_POST['pass1']) ? trim($_POST['pass1']) : null;
    $confirm_password = $_POST['pass2'] ?? '';
    $security_question = !empty($_POST['security_question']) ? mysqli_real_escape_string($link, trim($_POST['security_question'])) : null;
    $security_answer = !empty($_POST['security_answer']) ? mysqli_real_escape_string($link, trim($_POST['security_answer'])) : null;

    // Validate first name
    if (!$first_name) {
        $errors[] = 'Enter your first name.';
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
        $errors[] = 'First name can only contain letters, apostrophes, hyphens, and spaces.';
    }

    // Validate last name
    if (!$last_name) {
        $errors[] = 'Enter your last name.';
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
        $errors[] = 'Last name can only contain letters, apostrophes, hyphens, and spaces.';
    }

    // Validate email
    if (!$email) {
        $errors[] = 'Enter your email address.';
    }

    // Validate password
    if (!$password) {
        $errors[] = 'Enter your password.';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters long and contain at least one letter and one number.";
    }

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Validate security question and answer
    if (!$security_question) {
        $errors[] = 'Please select a security question.';
    }
    if (!$security_answer) {
        $errors[] = 'Please provide an answer to the security question.';
    }

    // If there are no errors, proceed with checking if the email is already in use
    if (empty($errors)) {
        // Check if the email already exists in the 'users' table
        $check_q = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $check_q)) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $errors[] = 'Email already registered. <a class="alert-link" href="login.php">Sign In Now</a>';
            }
            mysqli_stmt_close($stmt);
        }
    }

    // If no errors, proceed with inserting the new user into the database
    if (empty($errors)) {
        // Hash the password using password_hash() (bcrypt by default)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Hash the security answer
        $security_answer_hash = password_hash($security_answer, PASSWORD_DEFAULT);

        // Insert the user into the 'users' table
        $q = "INSERT INTO users (first_name, last_name, email, password, security_question, security_answer_hash, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, NOW())";

        if ($stmt = mysqli_prepare($link, $q)) {
            mysqli_stmt_bind_param($stmt, 'ssssss', $first_name, $last_name, $email, $hashed_password, $security_question, $security_answer_hash);
            $r = mysqli_stmt_execute($stmt);
            if ($r) {
                $_SESSION['user_id'] = mysqli_insert_id($link);  // Store the user's ID in the session
                $_SESSION['first_name'] = $first_name;
                mysqli_stmt_close($stmt);
                mysqli_close($link);

                // Show the success modal with a redirect button
                echo '
                <!-- Success Modal -->
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>You have successfully registered! Click OK to log in.</p>
                            </div>
                            <div class="modal-footer">
                                <a href="login.php" class="btn btn-primary">OK</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background Overlay (for dimming effect) -->
                <div class="modal-backdrop fade show"></div>

                <script>
                    // Show the modal after the user successfully registers
                    var myModal = new bootstrap.Modal(document.getElementById("successModal"));
                    myModal.show();
                </script>';
                exit();
            } else {
                $errors[] = 'An error occurred while processing your request. Please try again later.';
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
    <title>Sign Up</title>
    <style>
        label { color: white; }
        /* Styling for modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
    </style>
</head>
<body>

<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <h1 class="text-center text-white">Sign Up</h1>

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

    <form action="sign_up.php" method="post" class="bg-dark p-4 rounded shadow">
        <!-- First Name Input -->
        <div class="form-group mb-3">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" 
                   value="<?php if (isset($_POST['first_name'])) echo htmlspecialchars($_POST['first_name']); ?>" required>
        </div>

        <!-- Last Name Input -->
        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" 
                   value="<?php if (isset($_POST['last_name'])) echo htmlspecialchars($_POST['last_name']); ?>" required>
        </div>

        <!-- Email Input -->
        <div class="form-group mb-3">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" required>
        </div>

        <!-- Password Input -->
        <div class="form-group mb-3">
            <label for="pass1">Password</label>
            <input type="password" class="form-control" id="pass1" name="pass1" required>
        </div>

        <!-- Confirm Password Input -->
        <div class="form-group mb-4">
            <label for="pass2">Confirm Password</label>
            <input type="password" class="form-control" id="pass2" name="pass2" required>
        </div>
        
        <!-- Security Question -->
        <div class="form-group mb-3">
            <label for="security_question">Security Question</label>
            <select class="form-control" name="security_question" required>
                <option value="">-- Select a question --</option>
                <option value="mother_maiden">What is your mother's maiden name?</option>
                <option value="first_pet">What was the name of your first pet?</option>
                <option value="birth_city">In what city were you born?</option>
            </select>
        </div>

        <!-- Security Answer -->
        <div class="form-group mb-3">
            <label for="security_answer">Your Answer</label>
            <input type="text" class="form-control" name="security_answer" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>

    <p class="text-center mt-3 text-white">Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
