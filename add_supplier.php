<?php
require_once "includes/header.php";
require_once "includes/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = trim($_POST["supplier_name"]);
    $contact_person = trim($_POST["contact_person"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);

    if (!empty($supplier_name) && !empty($phone)) {
        $sql = "INSERT INTO suppliers (supplier_name, contact_person, phone, email, address) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $supplier_name, $contact_person, $phone, $email, $address);
            if (mysqli_stmt_execute($stmt)) {
                header("location: suppliers.php");
                exit();
            }
        }
    }
}
?>

<div class="container">
    <h2>Add New Supplier</h2>
    <form action="add_supplier.php" method="post" class="styled-form">
        <div class="form-group"><label>Supplier Name</label><input type="text" name="supplier_name" class="form-control" required></div>
        <div class="form-group"><label>Contact Person</label><input type="text" name="contact_person" class="form-control"></div>
        <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
        <div class="form-group"><label>Address</label><textarea name="address" class="form-control"></textarea></div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Save Supplier">
            <a href="suppliers.php" class="btn">Cancel</a>
        </div>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>