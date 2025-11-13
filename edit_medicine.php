<?php
// Include header and database connection
require_once "includes/header.php";
require_once "includes/db_connect.php";

// Initialize variables
$med_name = $packing = $generic_name = $price = "";
$id = 0;
$error_message = "";

// --- Part 1: Process the UPDATE when the form is submitted ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden id value from the form
    $id = $_POST["id"];
    $med_name = trim($_POST["med_name"]);
    $packing = trim($_POST["packing"]);
    $generic_name = trim($_POST["generic_name"]);
    $price = trim($_POST["price"]);

    // Validate input
    if (empty($med_name) || empty($packing) || empty($price) || empty($id)) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Prepare an update statement
        $sql = "UPDATE medicines SET med_name = ?, packing = ?, generic_name = ?, price = ? WHERE med_id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssdi", $med_name, $packing, $generic_name, $price, $id);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to the medicines list page after a successful update
                header("location: medicines.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
} else {
    // --- Part 2: Fetch existing data to PRE-FILL the form ---
    // Check if ID parameter exists in the URL
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM medicines WHERE med_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    // Fetch the record
                    $row = mysqli_fetch_assoc($result);
                    // Retrieve individual field values
                    $med_name = $row["med_name"];
                    $packing = $row["packing"];
                    $generic_name = $row["generic_name"];
                    $price = $row["price"];
                } else {
                    // URL doesn't contain a valid ID. Redirect to the error page or medicines list.
                    header("location: medicines.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // If no ID was provided in the URL
        header("location: medicines.php");
        exit();
    }
}
?>

<div class="container">
    <div class="header-part">
        <h2>Edit Medicine</h2>
        <a href="medicines.php" class="btn btn-primary">Back to List</a>
    </div>

    <?php 
    if(!empty($error_message)){
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>

    <form action="edit_medicine.php" method="post" class="styled-form">
        <div class="form-group">
            <label>Medicine Name</label>
            <input type="text" name="med_name" class="form-control" value="<?php echo htmlspecialchars($med_name); ?>" required>
        </div>
        <div class="form-group">
            <label>Packing</label>
            <input type="text" name="packing" class="form-control" value="<?php echo htmlspecialchars($packing); ?>" required>
        </div>
        <div class="form-group">
            <label>Generic Name</label>
            <input type="text" name="generic_name" class="form-control" value="<?php echo htmlspecialchars($generic_name); ?>">
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($price); ?>" required>
        </div>
        
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update Medicine">
        </div>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>