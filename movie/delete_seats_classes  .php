<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM seat_classes WHERE class_id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index_seats_class.php?msg=Class deleted successfully");
        exit;
    } else {
        echo "Error deleting class: " . $stmt->error;
    }
}
