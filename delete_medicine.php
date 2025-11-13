<?php
session_start();
require_once "includes/db_connect.php";

// Security Checks
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Prepare an update statement to deactivate the medicine
    $sql = "UPDATE medicines SET status = 'Inactive' WHERE med_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
// Redirect back to the medicines list
header("location: medicines.php");
exit();
?>