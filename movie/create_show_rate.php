<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $show_id  = $_POST['show_id'];
    $class_id = $_POST['class_id'];
    $price    = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO show_rates (show_id, class_id, price) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $show_id, $class_id, $price);

    if ($stmt->execute()) {
        header("Location: read_show_rates.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Show Rate</title>
</head>
<body>
    <h2>Add Show Rate</h2>
    <form method="post">
        Show ID: <input type="number" name="show_id" required><br><br>
        Class ID: <input type="number" name="class_id" required><br><br>
        Price: <input type="text" name="price" required><br><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
