<?php
require_once "includes/header.php";
require_once "includes/db_connect.php";

if ($_SESSION['role'] !== 'Admin') {
    header("location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // In a real app, you MUST hash this password.
    $role = trim($_POST['role']);

    $sql = "INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $full_name, $username, $password, $role);
        if (mysqli_stmt_execute($stmt)) {
            header("location: users.php");
            exit();
        }
    }
}
?>
<div class="container">
    <h2>Add New User</h2>
    <form action="add_user.php" method="post" class="styled-form">
        <div class="form-group"><label>Full Name</label><input type="text" name="full_name" class="form-control" required></div>
        <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
        <div class="form-group"><label>Role</label>
            <select name="role" class="form-control" required>
                <option value="Admin">Admin</option>
                <option value="Pharmacist" selected>Pharmacist</option>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Save User">
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>