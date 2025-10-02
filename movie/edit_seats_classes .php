<?php
include 'connect.php';

// Get ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch record
$stmt = $conn->prepare("SELECT * FROM seat_classes WHERE class_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "Seat class not found.";
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = trim($_POST['class_name']);
    $price = floatval($_POST['price']);

    $update = $conn->prepare("UPDATE seat_classes SET class_name=?, price=? WHERE class_id=?");
    $update->bind_param("sdi", $class_name, $price, $id);

    if ($update->execute()) {
        header("Location: read_seats_classes.php?msg=Class updated successfully");
        exit;
    } else {
        echo "Error updating record: " . $update->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Seat Class</title>
</head>
<body>
    <h2>Edit Seat Class</h2>
    <form method="POST">
        <label>Class Name:</label><br>
        <input type="text" name="class_name" value="<?= htmlspecialchars($row['class_name']) ?>" required><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($row['price']) ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
    <br>
    <a href="read_seats_classes.php">Back</a>
</body>
</html>
