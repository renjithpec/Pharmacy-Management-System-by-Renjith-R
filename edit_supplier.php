<?php
require_once "includes/header.php";
require_once "includes/db_connect.php";

$supplier_name = $contact_person = $phone = $email = $address = "";
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $supplier_name = trim($_POST["supplier_name"]);
    $contact_person = trim($_POST["contact_person"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);

    if (!empty($supplier_name) && !empty($phone)) {
        $sql = "UPDATE suppliers SET supplier_name=?, contact_person=?, phone=?, email=?, address=? WHERE supplier_id=?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssi", $supplier_name, $contact_person, $phone, $email, $address, $id);
            if (mysqli_stmt_execute($stmt)) {
                header("location: suppliers.php");
                exit();
            }
        }
    }
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);
        $sql = "SELECT * FROM suppliers WHERE supplier_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $supplier_name = $row["supplier_name"];
                    $contact_person = $row["contact_person"];
                    $phone = $row["phone"];
                    $email = $row["email"];
                    $address = $row["address"];
                }
            }
        }
    }
}
?>

<div class="container">
    <h2>Edit Supplier</h2>
    <form action="edit_supplier.php" method="post" class="styled-form">
        <div class="form-group"><label>Supplier Name</label><input type="text" name="supplier_name" class="form-control" value="<?php echo $supplier_name; ?>" required></div>
        <div class="form-group"><label>Contact Person</label><input type="text" name="contact_person" class="form-control" value="<?php echo $contact_person; ?>"></div>
        <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?php echo $email; ?>"></div>
        <div class="form-group"><label>Address</label><textarea name="address" class="form-control"><?php echo $address; ?></textarea></div>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update Supplier">
            <a href="suppliers.php" class="btn">Cancel</a>
        </div>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>