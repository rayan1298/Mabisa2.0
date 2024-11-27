<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance Area Indicators</title>
</head>
<body>

<h1>Maintenance Area Indicators List</h1>

<?php
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>{$_SESSION['success']}</p>";
    unset($_SESSION['success']);
}
?>

<a href="create_indicators.php">Add New Indicator Entry</a>

<table border="1">
    <tr>
        <th>KeyCtr</th>
        <th>Governance Code</th>
        <th>Description Key</th>
        <th>Area Description</th>
        <th>Indicator Code</th>
        <th>Indicator Description</th>
        <th>Relevance Definition</th>
        <th>Minimum Requirement</th>
        <th>Trail</th>
        <th>Actions</th>
    </tr>

    <?php
    // Adjust the SQL query to select all needed columns
    $stmt = $pdo->query("SELECT a.*, b.cat_code 
                          FROM maintenance_area_indicators a 
                          INNER JOIN maintenance_governance b ON a.governance_code = b.keyctr");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['keyctr']}</td>
                <td>{$row['cat_code']}</td>
                <td>{$row['desc_keyctr']}</td>
                <td>{$row['area_description']}</td>
                <td>{$row['indicator_code']}</td>
                <td>{$row['indicator_description']}</td>
                <td>{$row['relevance_def']}</td>
                <td>{$row['min_requirement']}</td>
                <td>{$row['trail']}</td>
                <td>
                    <a href='edit_indicators.php?indicator_code={$row['indicator_code']}'>Edit</a> | 
                    <a href='delete_indicators.php?indicator_code={$row['indicator_code']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
    }
    ?>
</table>

</body>
</html>
