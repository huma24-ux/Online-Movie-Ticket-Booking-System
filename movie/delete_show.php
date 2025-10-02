<?php include 'connect.php'; $id = $_GET['id']; $sql = "DELETE FROM shows WHERE show_id=?"; 
$stmt = $conn->prepare($sql); $stmt->bind_param("i", $id);
 $stmt->execute(); header("Location: read_shows.php"); ?>