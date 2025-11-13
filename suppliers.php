<?php
require_once "includes/header.php";
require_once "includes/db_connect.php";
?>

<div class="container">
    <div class="header-part">
        <h2>Manage Suppliers</h2>
        <a href="add_supplier.php" class="btn btn-primary">Add New Supplier</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Supplier Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM suppliers ORDER BY supplier_id DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['supplier_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['supplier_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact_person']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit_supplier.php?id=" . $row['supplier_id'] . "' class='btn btn-edit'>Edit</a> ";
                    echo "<a href='delete_supplier.php?id=" . $row['supplier_id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No suppliers found.</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
<?php require_once 'includes/footer.php'; ?>