<?php
include 'connect.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM show_rates WHERE rate_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo "Record not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $show_id  = $_POST['show_id'];
    $class_id = $_POST['class_id'];
    $price    = $_POST['price'];

    $stmt = $conn->prepare("UPDATE show_rates SET show_id=?, class_id=?, price=? WHERE rate_id=?");
    $stmt->bind_param("iidi", $show_id, $class_id, $price, $id);

    if ($stmt->execute()) {
        header("Location: read_show_rates.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Show Rate</title>
</head>
<body>
    <h2>Edit Show Rate</h2>
    <form method="post">
        Show ID: <input type="number" name="show_id" value="<?= $row['show_id'] ?>" required><br><br>
        Class ID: <input type="number" name="class_id" value="<?= $row['class_id'] ?>" required><br><br>
        Price: <input type="text" name="price" value="<?= $row['price'] ?>" required><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
