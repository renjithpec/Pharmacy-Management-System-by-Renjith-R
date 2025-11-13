<?php
require_once "includes/header.php";
require_once "includes/db_connect.php";

// SECURITY: Ensure only Admins can access this page
if ($_SESSION['role'] !== 'Admin') {
    header("location: dashboard.php");
    exit;
}
?>

<div class="container">
    <div class="header-part">
        <h2>Manage Users</h2>
        <a href="add_user.php" class="btn btn-primary">Add New User</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT user_id, full_name, username, role FROM users";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                echo "<td>";
                echo "<a href='edit_user.php?id=" . $row['user_id'] . "' class='btn btn-edit'>Edit</a> ";
                // Prevent admin from deleting themselves
                if ($_SESSION['user_id'] != $row['user_id']) {
                    echo "<a href='delete_user.php?id=" . $row['user_id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php require_once 'includes/footer.php'; ?>