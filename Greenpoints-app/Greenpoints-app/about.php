<?php
if (session_id() == '') {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>About Us - Green Points App</title>
</head>
<body>

<?php include('includes/nav.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Mission Statement Section -->
        <div class="col-md-6 mb-4">
            <div class="bg-white p-4 rounded shadow-sm h-100">
                <h2 class="mb-3 text-center">Our Mission</h2>
                <p>
                At Sustain Energy, we empower companies to take responsibility for their environmental impact and contribute to a cleaner, greener future.
                <br>
                <br>
                We provide tools to calculate an environmental friendliness score based on the percentage of renewable energy used — the higher the renewables, the better the score.
                <br>
                <br>
                Our goal isn’t just accountability — it’s to reward transparency, encourage good corporate citizenship, and help businesses show consumers and competitors that they are serious about climate action.
                </p>
            </div>
        </div>

        <!-- Terms and Conditions Section -->
        <div class="col-md-6 mb-4">
            <div class="bg-white p-4 rounded shadow-sm h-100">
                <h2 class="mb-3">Terms & Conditions</h2>
                <h5>Introduction</h5>
                <p>By using our website, you agree to the following terms and conditions...</p>
                <h5>Limitation of Liability</h5>
                <p>We are not responsible for any damages or loss of data while using our website.</p>
                <h5>Privacy Policy</h5>
                <p>We value your privacy and commit to protecting your personal information.</p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
