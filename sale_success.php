<?php
require_once "includes/header.php";

// Get the sale ID from the URL
$sale_id = $_GET['id'] ?? 0;
?>

<div class="container" style="text-align: center;">
    <h2>Sale Completed Successfully!</h2>
    <p>The sale has been recorded in the system.</p>
    <br>
    
    <?php if ($sale_id > 0): ?>
        <a href="generate_invoice.php?id=<?php echo $sale_id; ?>" class="btn btn-primary">Download Invoice PDF</a>
    <?php endif; ?>
    
    <br><br>
    <a href="sales.php" class="btn">Start a New Sale</a>
</div>
<?php require_once 'includes/footer.php'; ?>