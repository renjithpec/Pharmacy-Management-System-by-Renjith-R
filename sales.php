<?php
require_once "includes/header.php";
?>

<div class="container">
    <div class="header-part">
        <h2>New Sale / Billing</h2>
    </div>

    <form id="sale-form" method="post" action="process_sale.php">
        <div class="form-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="medicine-search">Search for Medicine:</label>
            <input type="text" id="medicine-search" class="form-control" autocomplete="off">
            <div id="search-results"></div>
        </div>

        <h3>Bill Items</h3>
        <table class="data-table" id="billing-table">
            <thead>
                <tr>
                    <th>Medicine Name</th>
                    <th>Packing</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
        
        <div class="sale-summary">
            <div class="summary-item">
                <strong>Subtotal:</strong> ₹ <span id="subtotal">0.00</span>
            </div>
            <div class="summary-item">
                <label for="amount_paid"><strong>Amount Paid:</strong> ₹ </label>
                <input type="number" step="0.01" id="amount_paid" name="amount_paid" required>
            </div>
            <div class="summary-item">
                <strong>Change Due:</strong> ₹ <span id="change_due">0.00</span>
            </div>
        </div>

        <input type="hidden" name="total_amount" id="total_amount_hidden">

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Complete Sale">
        </div>
    </form>
</div>

<script src="assets/js/sales.js"></script>
<?php require_once 'includes/footer.php'; ?>