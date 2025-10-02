<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO seat_classes (class_name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $class_name, $price);

    if ($stmt->execute()) {
        header("Location: read_seats_classes.php?msg=Class added successfully");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Seat Class</title>
</head>
<body>
    <h2>Add Seat Class</h2>
    <form method="POST">
        <label>Class Name:</label><br>
        <input type="text" name="class_name" required><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <button type="submit">Save</button>
    </form>
    <br>
    <a href="read_seats_classes.php">Back</a>
</body>
</html>
