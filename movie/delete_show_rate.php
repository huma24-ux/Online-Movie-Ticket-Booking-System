<?php
include 'connect.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM show_rates WHERE rate_id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: read_show_rates.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
