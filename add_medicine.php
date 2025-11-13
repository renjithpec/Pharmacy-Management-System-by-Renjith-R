<?php
// Include the secure header and database connection
require_once "includes/header.php";
require_once "includes/db_connect.php";

// Define variables and initialize with empty values
$med_name = $packing = $generic_name = $price = "";
$error_message = $success_message = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $med_name = trim($_POST["med_name"]);
    $packing = trim($_POST["packing"]);
    $generic_name = trim($_POST["generic_name"]);
    $price = trim($_POST["price"]);

    // Simple validation
    if (empty($med_name) || empty($packing) || empty($price)) {
        $error_message = "Please fill in all required fields (Medicine Name, Packing, Price).";
    } else {
        // Prepare an insert statement for better security
        $sql = "INSERT INTO medicines (med_name, packing, generic_name, price) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssd", $med_name, $packing, $generic_name, $price);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to medicines list page after successful creation
                header("location: medicines.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<div class="container">
    <div class="header-part">
        <h2>Add New Medicine</h2>
        <a href="medicines.php" class="btn btn-primary">Back to List</a>
    </div>

    <?php 
    if(!empty($error_message)){
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>

    <form action="add_medicine.php" method="post" class="styled-form">
        <div class="form-group">
            <label>Medicine Name</label>
            <input type="text" name="med_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Packing (e.g., 10pc, 100ml)</label>
            <input type="text" name="packing" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Generic Name</label>
            <input type="text" name="generic_name" class="form-control">
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save Medicine">
        </div>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>