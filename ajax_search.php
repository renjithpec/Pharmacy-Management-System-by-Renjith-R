<?php
require_once "includes/db_connect.php";
header('Content-Type: application/json');

$term = $_GET['term'] ?? '';
$medicines = [];

if (strlen($term) > 1) {
    $sql = "SELECT med_id, med_name, packing, price FROM medicines WHERE med_name LIKE ? AND status = 'Active' LIMIT 10";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        $search_term = "%" . $term . "%";
        mysqli_stmt_bind_param($stmt, "s", $search_term);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $medicines[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}

echo json_encode($medicines);
?>