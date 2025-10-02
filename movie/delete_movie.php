<?php
include 'connect.php';
$id = intval($_GET['id']);
$sql = "DELETE FROM movies WHERE movie_id=$id";
if ($conn->query($sql)) {
    echo "<script>alert('Movie deleted'); window.location='read_movies.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
