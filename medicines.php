<?php
// Include the secure header
require_once "includes/header.php";
// Include the database connection
require_once "includes/db_connect.php";
?>

<div class="container">
    <div class="header-part">
        <h2>Manage Medicines</h2>
        <a href="add_medicine.php" class="btn btn-primary">Add New Medicine</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Medicine Name</th>
                <th>Packing</th>
                <th>Generic Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL query to fetch all medicines from the database
            $sql = "SELECT * FROM medicines WHERE status = 'Active' ORDER BY med_id DESC";
            $result = mysqli_query($conn, $sql);

            // Check if there are any records
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row of the result
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['med_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['med_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['packing']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['generic_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit_medicine.php?id=" . $row['med_id'] . "' class='btn btn-edit'>Edit</a> ";
                    echo "<a href='delete_medicine.php?id=" . $row['med_id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this medicine?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                // If no records are found, display a message
                echo "<tr><td colspan='6'>No medicines found.</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
<?php require_once 'includes/footer.php'; ?>