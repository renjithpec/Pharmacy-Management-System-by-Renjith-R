<?php
session_start();
require_once "includes/db_connect.php";

// Check if the form was submitted and the user is logged in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"])) {

    // --- Begin Database Transaction ---
    mysqli_begin_transaction($conn);

    try {
        // 1. Get data from the form
        $customer_name = $_POST['customer_name'];
        $total_amount = $_POST['total_amount'];
        $amount_paid = $_POST['amount_paid'];
        $change_due = $amount_paid - $total_amount;
        $user_id = $_SESSION['user_id'];

        // Arrays of medicine IDs and quantities
        $med_ids = $_POST['med_id'];
        $quantities = $_POST['quantity'];

        // 2. Insert the main sale record into the `sales` table
        $sql_sale = "INSERT INTO sales (customer_name, total_amount, amount_paid, change_due, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt_sale = mysqli_prepare($conn, $sql_sale);
        mysqli_stmt_bind_param($stmt_sale, "sdddi", $customer_name, $total_amount, $amount_paid, $change_due, $user_id);
        mysqli_stmt_execute($stmt_sale);

        // Get the ID of the sale we just created
        $sale_id = mysqli_insert_id($conn);

        // 3. Loop through each item, insert into `sale_items`, and update `medicines` stock
        $sql_item = "INSERT INTO sale_items (sale_id, med_id, quantity_sold, price_per_unit) VALUES (?, ?, ?, (SELECT price FROM medicines WHERE med_id = ?))";
        $stmt_item = mysqli_prepare($conn, $sql_item);

        $sql_stock = "UPDATE medicines SET quantity = quantity - ? WHERE med_id = ?";
        $stmt_stock = mysqli_prepare($conn, $sql_stock);

        for ($i = 0; $i < count($med_ids); $i++) {
            $current_med_id = $med_ids[$i];
            $current_quantity = $quantities[$i];

            // Insert into sale_items
            mysqli_stmt_bind_param($stmt_item, "iiii", $sale_id, $current_med_id, $current_quantity, $current_med_id);
            mysqli_stmt_execute($stmt_item);

            // Update medicine stock
            mysqli_stmt_bind_param($stmt_stock, "ii", $current_quantity, $current_med_id);
            mysqli_stmt_execute($stmt_stock);
        }

        // If all queries were successful, commit the transaction
        mysqli_commit($conn);
        
        // Redirect with a success message (we can build this feature later)
        // Redirect to the success page, passing the new sale ID
    header("location: sale_success.php?id=" . $sale_id);

    } catch (mysqli_sql_exception $exception) {
        // If any query fails, roll back the transaction
        mysqli_rollback($conn);
        
        // You can log the error or redirect with an error message
        // For now, we just redirect back to the sales page
        header("location: sales.php?sale=error");
        // For debugging: echo "Error: " . $exception->getMessage();
    }

} else {
    // If not a POST request, redirect to the sales page
    header("location: sales.php");
}
?>