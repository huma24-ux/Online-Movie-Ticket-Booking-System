<?php
include 'connect.php';
$sql = "SELECT * FROM show_rates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Rates</title>
</head>
<body>
    <h2>Show Rates</h2>
    <a href="create_show_rate.php">Add New Rate</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>Rate ID</th>
            <th>Show ID</th>
            <th>Class ID</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['rate_id'] ?></td>
            <td><?= $row['show_id'] ?></td>
            <td><?= $row['class_id'] ?></td>
            <td><?= $row['price'] ?></td>
            <td>
                <a href="edit_show_rate.php?id=<?= $row['rate_id'] ?>">Edit</a> |
                <a href="delete_show_rate.php?id=<?= $row['rate_id'] ?>" onclick="return confirm('Delete this record?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
