<?php
include 'connect.php';
$result = $conn->query("SELECT * FROM seat_classes");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seat Classes</title>
</head>
<body>
    <h2>Seat Classes</h2>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color:green"><?= htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <a href="create_seats_classes.php">Add New Class</a><br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Class Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['class_id'] ?></td>
            <td><?= htmlspecialchars($row['class_name']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td>
                <a href="edit_seats_classes.php?id=<?= $row['class_id'] ?>">Edit</a> |
                <a href="delete_seats_classes.php?id=<?= $row['class_id'] ?>" onclick="return confirm('Delete this class?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
