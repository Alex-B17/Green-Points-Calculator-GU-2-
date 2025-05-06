<?php
session_start();
include('connect_db.php');  // Include the database connection file

// Define points for each response
$points = [
    'positive' => 3,
    'neutral' => 2,
    'negative' => 1
];

// Initialize individual scores (based on user input)
$carbon_emissions = isset($_POST['carbon_emissions']) ? $points[$_POST['carbon_emissions']] : 0;
$renewable_energy = isset($_POST['renewable_energy']) ? $points[$_POST['renewable_energy']] : 0;
$waste_reduction = isset($_POST['waste_reduction']) ? $points[$_POST['waste_reduction']] : 0;
$water_conservation = isset($_POST['water_conservation']) ? $points[$_POST['water_conservation']] : 0;
$sustainable_supply_chain = isset($_POST['sustainable_supply_chain']) ? $points[$_POST['sustainable_supply_chain']] : 0;
$energy_efficient_infrastructure = isset($_POST['energy_efficient_infrastructure']) ? $points[$_POST['energy_efficient_infrastructure']] : 0;
$eco_friendly_products = isset($_POST['eco_friendly_products']) ? $points[$_POST['eco_friendly_products']] : 0;
$transportation_sustainability = isset($_POST['transportation_sustainability']) ? $points[$_POST['transportation_sustainability']] : 0;
$sustainable_packaging = isset($_POST['sustainable_packaging']) ? $points[$_POST['sustainable_packaging']] : 0;
$green_certifications = isset($_POST['green_certifications']) ? $points[$_POST['green_certifications']] : 0;

// Calculate the total score
$total_score = $carbon_emissions + $renewable_energy + $waste_reduction + $water_conservation + $sustainable_supply_chain + $energy_efficient_infrastructure + $eco_friendly_products + $transportation_sustainability + $sustainable_packaging + $green_certifications;

// Determine the rating based on the total score
if ($total_score >= 90) {
    $rating = 'Gold';
} elseif ($total_score >= 70) {
    $rating = 'Silver';
} elseif ($total_score >= 50) {
    $rating = 'Bronze';
} else {
    $rating = 'No Certification';
}

// Ensure the user is logged in and has an active subscription
if (isset($_SESSION['user_id']) && $_SESSION['subscription_active'] == true) {
    $user_id = $_SESSION['user_id'];
    $company_name = $_SESSION['company_name'];  // Assuming company name is stored in session, or you can request it in the form

    // Prepare the insert query
    $query = "INSERT INTO company_ratings 
                (company_name, carbon_emissions, renewable_energy, waste_reduction, water_conservation, sustainable_supply_chain, energy_efficient_infrastructure, eco_friendly_products, transportation_sustainability, sustainable_packaging, green_certifications, total_score, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $link->prepare($query);
    $stmt->bind_param("siiiiiiiiiii", $company_name, $carbon_emissions, $renewable_energy, $waste_reduction, $water_conservation, $sustainable_supply_chain, $energy_efficient_infrastructure, $eco_friendly_products, $transportation_sustainability, $sustainable_packaging, $green_certifications, $total_score);
    $stmt->execute();
    $stmt->close();
} else {
    // If the user isn't logged in or doesn't have an active subscription, redirect to a login or subscription page
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>Green Points Calculator Results</title>
</head>
<body>

<!-- ✅ Navbar include -->
<?php include('includes/nav.php'); ?>

<!-- ✅ Main Content Container -->
<div class="container mt-4">
    <h2>Your Green Points Calculator Results</h2>
    <p><strong>Total Score: </strong><?php echo $total_score; ?></p>
    <p><strong>Your Rating: </strong><?php echo $rating; ?></p>

    <p>Thank you for completing the Green Points Calculator! Based on your efforts, you have achieved a <strong><?php echo $rating; ?></strong> rating.</p>
</div>

<!-- ✅ Footer include -->
<?php include('includes/footer.php'); ?>

</body>
</html>
