<?php
session_start();
require_once "includes/db_connect.php";
require('fpdf/fpdf.php');

// Security Check
if (!isset($_SESSION["loggedin"]) || !isset($_GET['id'])) {
    header("location: login.php");
    exit;
}

$sale_id = $_GET['id'];

// --- Fetch Sale Data ---
// Get main sale info
$sql_sale = "SELECT * FROM sales WHERE sale_id = ?";
$stmt_sale = mysqli_prepare($conn, $sql_sale);
mysqli_stmt_bind_param($stmt_sale, "i", $sale_id);
mysqli_stmt_execute($stmt_sale);
$result_sale = mysqli_stmt_get_result($stmt_sale);
$sale = mysqli_fetch_assoc($result_sale);

// Get sale items
$sql_items = "SELECT m.med_name, si.quantity_sold, si.price_per_unit FROM sale_items si JOIN medicines m ON si.med_id = m.med_id WHERE si.sale_id = ?";
$stmt_items = mysqli_prepare($conn, $sql_items);
mysqli_stmt_bind_param($stmt_items, "i", $sale_id);
mysqli_stmt_execute($stmt_items);
$result_items = mysqli_stmt_get_result($stmt_items);

// --- Create PDF ---
$pdf = new FPDF();
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Hospital Pharmacy Invoice', 0, 1, 'C');
$pdf->Ln(10);

// Invoice Info
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, 'Invoice #: ' . $sale['sale_id'], 0, 1);
$pdf->Cell(0, 6, 'Date: ' . date('d-m-Y', strtotime($sale['sale_date'])), 0, 1);
$pdf->Cell(0, 6, 'Customer: ' . $sale['customer_name'], 0, 1);
$pdf->Ln(10);

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 7, 'Item', 1);
$pdf->Cell(30, 7, 'Quantity', 1);
$pdf->Cell(30, 7, 'Unit Price', 1);
$pdf->Cell(35, 7, 'Total', 1, 1); // 1,1 means border and new line

// Table Rows
$pdf->SetFont('Arial', '', 12);
while($item = mysqli_fetch_assoc($result_items)){
    $item_total = $item['quantity_sold'] * $item['price_per_unit'];
    $pdf->Cell(95, 7, $item['med_name'], 1);
    $pdf->Cell(30, 7, $item['quantity_sold'], 1);
    $pdf->Cell(30, 7, '$' . number_format($item['price_per_unit'], 2), 1);
    $pdf->Cell(35, 7, '$' . number_format($item_total, 2), 1, 1);
}
$pdf->Ln(10);

// Totals
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(155, 7, 'Total Amount:', 0, 0, 'R');
$pdf->Cell(35, 7, '$' . number_format($sale['total_amount'], 2), 1, 1, 'R');

$pdf->Cell(155, 7, 'Amount Paid:', 0, 0, 'R');
$pdf->Cell(35, 7, '$' . number_format($sale['amount_paid'], 2), 1, 1, 'R');

$pdf->Cell(155, 7, 'Change Due:', 0, 0, 'R');
$pdf->Cell(35, 7, '$' . number_format($sale['change_due'], 2), 1, 1, 'R');

// Output the PDF
$pdf->Output('D', 'invoice-' . $sale_id . '.pdf'); // 'D' forces download
?>