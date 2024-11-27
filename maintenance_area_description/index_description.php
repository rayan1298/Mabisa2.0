<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance Area Descriptions</title>
</head>
<body>

<h1>Maintenance Area Descriptions</h1>

<!-- Display success messages, if any -->
<?php
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>{$_SESSION['success']}</p>";
    unset($_SESSION['success']);
}
?>

<!-- Add new description link -->
<a href="create_description.php">Add New Description</a>

<!-- Display descriptions from the database -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Description</th>
        <th>Trail</th>
        <th>Actions</th>
    </tr>

    <?php
    // Fetch area descriptions from the database
    $stmt = $pdo->query("SELECT * FROM maintenance_area_description");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['keyctr']}</td>
                <td>{$row['description']}</td>
                <td>{$row['trail']}</td>
                <td>
                    <a href='edit_description.php?keyctr={$row['keyctr']}'>Edit</a> | 
                    <a href='delete_description.php?keyctr={$row['keyctr']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
    }
    ?>
</table>

</body>
</html>
