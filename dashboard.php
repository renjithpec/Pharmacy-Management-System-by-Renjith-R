<?php
// Include our secure header and database connection
require_once "includes/header.php";
require_once "includes/db_connect.php";

// --- Query to get total number of ACTIVE medicines ---
$sql_medicines = "SELECT COUNT(med_id) AS total_medicines FROM medicines WHERE status = 'Active'";
$result_medicines = mysqli_query($conn, $sql_medicines);
$data_medicines = mysqli_fetch_assoc($result_medicines);
$total_medicines = $data_medicines['total_medicines'];

// --- Query to get total number of suppliers ---
$sql_suppliers = "SELECT COUNT(supplier_id) AS total_suppliers FROM suppliers";
$result_suppliers = mysqli_query($conn, $sql_suppliers);
$data_suppliers = mysqli_fetch_assoc($result_suppliers);
$total_suppliers = $data_suppliers['total_suppliers'];

// --- Query to get total sales for today ---
$sql_sales = "SELECT SUM(total_amount) AS todays_sales FROM sales WHERE DATE(sale_date) = CURDATE()";
$result_sales = mysqli_query($conn, $sql_sales);
$data_sales = mysqli_fetch_assoc($result_sales);
$todays_sales = $data_sales['todays_sales'] ?? 0;

mysqli_close($conn);
?>

<div class="content-body">
    <h2>Dashboard</h2>
    <p>Welcome to the Hospital Pharmacy Management System.</p>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Medicines</h3>
            <p><?php echo $total_medicines; ?></p>
        </div>
        <div class="stat-card">
            <h3>Suppliers</h3>
            <p><?php echo $total_suppliers; ?></p>
        </div>
        <div class="stat-card">
            <h3>Today's Sales</h3>
            <p>₹<?php echo number_format($todays_sales, 2); ?></p>
        </div>
    </div>

    <div class="chart-container">
        <div class="chart-wrapper">
            <h3>Last 7 Days Sales Trend</h3>
            <canvas id="salesTrendChart"></canvas>
        </div>
        <div class="chart-wrapper">
            <h3>Low Stock Medicines</h3>
            <canvas id="lowStockChart"></canvas>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>