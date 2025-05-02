<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>Green Points Calculator App</title>
</head>

<body>

<!-- ✅ Navbar include -->
<?php include('includes/nav.php'); ?>

<div class="container mt-4">
    <div class="row">
        <!-- Your movie listings or other home page content goes here -->

        <!-- Commented movie listings (optional for testing) -->
        <!-- 
        <?php
        // require('connect_db.php');
        // $q = "SELECT * FROM movie_listings";
        // $r = mysqli_query($link, $q);
        // if (!$r) {
        //     echo '<p>Error retrieving movie listings. Please try again later.</p>';
        //     mysqli_close($link);
        //     include('includes/footer.php');
        //     exit();
        // }
        // while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        //     echo '...';
        // }
        // mysqli_close($link);
        ?>
        -->
    </div>
</div>

<!-- ✅ Footer include -->
<?php include('includes/footer.php'); ?>

<!-- ✅ Bootstrap JS (already included in head.php, but you can move it here if preferred) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
