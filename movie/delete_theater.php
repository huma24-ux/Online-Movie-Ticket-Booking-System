<?php
include 'connect.php';
$id = intval($_GET['id']);

$getImg = $conn->query("SELECT theater_img FROM theaters WHERE theater_id=$id")->fetch_assoc();
if ($getImg && file_exists($getImg['theater_img'])) {
    unlink($getImg['theater_img']); // delete old file
}
$conn->query("DELETE FROM theaters WHERE theater_id=$id");
echo "<script>alert('Deleted Successfully'); window.location='read_theaters.php';</script>";
?>
