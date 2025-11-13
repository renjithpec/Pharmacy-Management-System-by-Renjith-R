<?php
header('Content-Type: application/json');
require_once "includes/db_connect.php";

// --- Data for Sales Trend (Last 7 Days) ---
$sales_labels = [];
$sales_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $sql = "SELECT SUM(total_amount) as daily_total FROM sales WHERE DATE(sale_date) = '$date'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sales_labels[] = date('D, M j', strtotime($date)); // Format: "Sun, Sep 21"
    $sales_data[] = $row['daily_total'] ?? 0;
}

// --- Data for Low Stock Items (Top 5) ---
$low_stock_labels = [];
$low_stock_data = [];
$sql_stock = "SELECT med_name, quantity FROM medicines WHERE status = 'Active' ORDER BY quantity ASC LIMIT 5";
$result_stock = mysqli_query($conn, $sql_stock);
while($row = mysqli_fetch_assoc($result_stock)){
    $low_stock_labels[] = $row['med_name'];
    $low_stock_data[] = $row['quantity'];
}

// Combine all data into a single object
$output = [
    'salesTrend' => [
        'labels' => $sales_labels,
        'data' => $sales_data,
    ],
    'lowStock' => [
        'labels' => $low_stock_labels,
        'data' => $low_stock_data,
    ]
];

echo json_encode($output);
?>