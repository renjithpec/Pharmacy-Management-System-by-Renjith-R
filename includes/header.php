<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="preloader">
        <lottie-player src="assets/animations/health.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
    </div>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fa-solid fa-pills"></i> Go-Pharma</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="sales.php"><i class="fa-solid fa-dollar-sign"></i> Sales</a></li>
            <li><a href="medicines.php"><i class="fa-solid fa-capsules"></i> Medicines</a></li>
            <li><a href="suppliers.php"><i class="fa-solid fa-truck-fast"></i> Suppliers</a></li>
            <?php if ($_SESSION['role'] == 'Admin'): ?>
                <li><a href="users.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
            <?php endif; ?>
        </ul>
    </aside>

    <main class="main-content">
        <header class="top-bar">
            <div class="user-info">
                <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></span>
                <a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </header>

        <div class="content-body">