<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQs and Terms and Conditions</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="includes/Greenptsformat.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
</head>
<body>

<!-- ✅ Include the nav *inside* the body -->
<?php include('includes/nav.php'); ?>

<div class="container mt-5">
    <!-- FAQ and Terms & Conditions Sections in a Flexbox Container -->
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
                               <!-- This website allows companies to create an account and to sign up to our service which (using our green points calculator tool) provides an environmental friendliness rating based on a few factors. The company will then gain certification of the level they have achieved in certificate form (ranging from a Bronze, Silver or Gold rating). -->
                               This website helps companies sign up and use our Green Points Calculator tool to assess their environmental friendliness.
                               <br>
                               <br>
                               Based on various sustainability factors, companies receive a score and earn a certification level — Bronze, Silver, or Gold — as official recognition of their efforts.
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
                                You will be able to access the certificate if you have an active subscription and have completed at least one of the forms to calculate your score using our green points calculator tool.
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

                    <!-- Item 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                How is the additional greenpoints money spent?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                In order to remain functional, our company will take 100% of the money earned from subscriptions.
                                <br>
                                <br>
                                This will go towards the everyday running costs of the website, staff member salaries and so on.
                                <br>
                                <br>
                                The company only takes a 20% cut of the money from green points purchases, with the other 80% going to planting trees, to offset the amount of greenhouse gases that company is deemed to have used via non renewable energies.
                                This cost is factored into the price in the first place, so no money is being diverted from offsetting the environmental impact of planting the trees as a long term carbon capture method.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <!-- Terms Section -->
        <div class="terms-section">
            <h2>Terms and Conditions</h2>
            <h5>Introduction</h5>
            <p>By using our website, you agree to the terms and conditions.</p>
            <h5>Privacy Policy</h5>
            <p>Your data is safe with us.</p>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="card mt-5">
        <div class="card-header">
            <h2>Contact Us with Any Enquiries</h2>
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
                    <label for="message">Message</label>
                    <textarea class="form-control" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

    <!-- Success Modal (Hidden initially) -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Form Submitted Successfully!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Thank you for your message! We will get back to you as soon as possible.</p>
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

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Check if there's a query parameter that indicates successful form submission
    <?php if (isset($_GET['success'])): ?>
        // Trigger the modal if the form was submitted successfully
        var myModal = new bootstrap.Modal(document.getElementById('successModal'));
        myModal.show();
    <?php endif; ?>
</script>
</body>
</html>
