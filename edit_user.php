<?php
require_once "includes/header.php";
require_once "includes/db_connect.php";

if ($_SESSION['role'] !== 'Admin') {
    header("location: dashboard.php");
    exit;
}

$full_name = $username = $role = "";
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    // If password field is empty, don't update it. Otherwise, update it.
    if(empty($password)){
        $sql = "UPDATE users SET full_name = ?, username = ?, role = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $full_name, $username, $role, $id);
    } else {
        $sql = "UPDATE users SET full_name = ?, username = ?, role = ?, password = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $username, $role, $password, $id);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        header("location: users.php");
        exit();
    }
} else {
    $id = trim($_GET["id"]);
    $sql = "SELECT full_name, username, role FROM users WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $full_name = $row['full_name'];
            $username = $row['username'];
            $role = $row['role'];
        }
    }
}
?>
<div class="container">
    <h2>Edit User</h2>
    <form action="edit_user.php" method="post" class="styled-form">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div class="form-group"><label>Full Name</label><input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>" required></div>
        <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required></div>
        <div class="form-group"><label>New Password (leave blank to keep current)</label><input type="password" name="password" class="form-control"></div>
        <div class="form-group"><label>Role</label>
            <select name="role" class="form-control" required>
                <option value="Admin" <?php echo ($role == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="Pharmacist" <?php echo ($role == 'Pharmacist') ? 'selected' : ''; ?>>Pharmacist</option>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Update User">
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>