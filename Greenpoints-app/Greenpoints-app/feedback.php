<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="includes/Greenptsformat.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>

<?php include('includes/nav.php'); ?>

<div class="container mt-5">

    <!-- Feedback Explainer Box -->
    <div class="card bg-light mb-4">
        <div class="card-body">
            <h2 class="card-title">We Value Your Feedback</h2>
            <p class="card-text">
                Let us know what you think of the website — the positives, the negatives, any bugs you've found,
                or improvements you think we could make. Your input helps us make the experience better for everyone.
            </p>
        </div>
    </div>

    <!-- Feedback Form -->
    <div class="card">
        <div class="card-header">
            <h2>Feedback Form</h2>
        </div>
        <div class="card-body">
            <form action="contact_process.php" method="POST">
                <div class="mb-3">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message">Your Feedback</label>
                    <textarea class="form-control" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Thank You!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your feedback has been submitted successfully. We appreciate your input!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</div>

<br>
<br>
<br>

<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Show modal if feedback was submitted successfully
    <?php if (isset($_GET['success'])): ?>
    var myModal = new bootstrap.Modal(document.getElementById('successModal'));
    myModal.show();
    <?php endif; ?>
</script>

</body>
</html>
