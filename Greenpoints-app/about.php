<?php
// Start the session only if it isn't already started
if (session_id() == '') {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include the head.php file for consistent meta tags, title, and CSS -->
    <?php include('includes/head.php'); ?>
    <title>About Us - Green Points App</title>
</head>
<body>

    <!-- Navbar Include -->
    <?php include('includes/nav.php'); ?>

    <div class="container">
        <div class="sections-container">
            
            <!-- FAQ Section -->
            <div class="faq-section">
                <h2>Frequently Asked Questions (FAQs)</h2>

                <div class="accordion" id="accordionExample">
                    
                    <!-- Item 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is the purpose of this website?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                This website allows companies to create an account and then sign up to our service which allows them to calculate their environmental friendliness rating based on a few factors and gain certification of the level they have achieved in certificate form.
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How do I get the certificate?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                You will be able to access the certificate if you have an active subscription and have completed at least one of the forms to calculate your score.
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Can I buy points to get a better score?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes, you can buy points to boost your score. The price will apply based on a few different factors.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Terms and Conditions Section -->
            <div class="terms-section">
                <h2>Terms and Conditions</h2>

                <h5>Introduction</h5>
                <p>By using our website, you agree to the following terms and conditions...</p>

                <h5>Limitation of Liability</h5>
                <p>We are not responsible for any damages or loss of data while using our website.</p>

                <h5>Privacy Policy</h5>
                <p>We value your privacy and commit to protecting your personal information.</p>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

<!-- Footer Include -->
<?php include('includes/footer.php'); ?>

</html>
