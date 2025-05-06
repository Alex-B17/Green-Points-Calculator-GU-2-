<?php
// Start the session if it's not already started
if (session_id() == '') {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="/Greenpoints-App/home.php">Green Points Calculator App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="/Greenpoints-App/dashboard.php">Dashboard</a>
            </li>

            <!-- About -->
            <li class="nav-item <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="/Greenpoints-App/about.php">About</a>
            </li>

            <!-- Contact -->
            <li class="nav-item <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="/Greenpoints-App/contact.php">Contact & Help</a>
            </li>

            <!-- Feedback -->
            <li class="nav-item <?php echo ($current_page == 'feedback.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="/Greenpoints-App/feedback.php">Feedback</a>
            </li>

            <!-- User Account -->
            <li class="nav-item <?php echo ($current_page == 'user_account.php') ? 'active' : ''; ?>">
                <?php if (isset($_SESSION['id'])): ?>
                    <a class="nav-link" href="/Greenpoints-App/user_account.php">User Account</a>
                <?php else: ?>
                    <a class="nav-link" href="/Greenpoints-App/login.php">User Account</a>
                <?php endif; ?>
            </li>

            <!-- Points History -->
            
            <?php if (isset($_SESSION['id'])): ?>
                <li class="nav-item <?php echo ($current_page == 'points_history.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/Greenpoints-App/points_history.php">Points History</a>
                </li>
            <?php endif; ?>

            <!-- Cart -->
            <?php if (isset($_SESSION['id'])): ?>
                <li class="nav-item <?php echo ($current_page == 'checkout.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/Greenpoints-App/checkout.php">Cart</a>
                </li>
            <?php endif; ?>

            <!-- Login -->
            <?php if (!isset($_SESSION['id'])): ?>
                <li class="nav-item <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/Greenpoints-App/login.php">Login</a>
                </li>
            <?php endif; ?>

            <!-- Sign Up -->
            <?php if (!isset($_SESSION['id'])): ?>
                <li class="nav-item <?php echo ($current_page == 'sign_up.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/Greenpoints-App/sign_up.php">Sign Up</a>
                </li>
            <?php endif; ?>

            <!-- Logout -->
            <?php if (isset($_SESSION['id'])): ?>
                <li class="nav-item <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/Greenpoints-App/logout.php">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- Display First Name or Guest -->
<div class="px-3 py-2">
    <h1 class="text-white">Hello <?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name'], ENT_QUOTES, 'UTF-8') : 'Guest'; ?></h1>
</div>
