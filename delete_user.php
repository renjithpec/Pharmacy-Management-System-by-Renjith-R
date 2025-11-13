<?php
session_start();
require_once "includes/db_connect.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role'] !== 'Admin') {
    header("location: login.php");
    exit;
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id_to_delete = trim($_GET["id"]);
    
    // Safety check: prevent an admin from deleting their own account
    if ($id_to_delete == $_SESSION['user_id']) {
        header("location: users.php?error=cannotdelete");
        exit();
    }

    $sql = "DELETE FROM users WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id_to_delete);
        mysqli_stmt_execute($stmt);
    }
}
header("location: users.php");
exit();
?>