<?php
include 'connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid movie ID.");
}

// Fetch the movie record
$result = $conn->query("SELECT * FROM movies WHERE movie_id=$id");
$movie = $result->fetch_assoc();

if (!$movie) {
    die("Movie not found.");
}

if (isset($_POST['update'])) {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $trailer_url = $_POST['trailer_url'];
    $release_date= $_POST['release_date'];
    $duration    = $_POST['duration'];
    $rating      = $_POST['rating'];

    $imgUpdate = "";
    if (!empty($_FILES['file']['name'])) {
        $fileName = $_FILES['file']['name'];
        $fileTmp  = $_FILES['file']['tmp_name'];

        $uploadDir = "images/movies/";
        $folder = $uploadDir . basename($fileName);

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (move_uploaded_file($fileTmp, $folder)) {
            $imgUpdate = ", movie_img='$folder'";
        }
    }

    $sql = "UPDATE movies 
            SET title='$title', description='$description', trailer_url='$trailer_url', 
                release_date='$release_date', duration='$duration', rating='$rating' $imgUpdate 
            WHERE movie_id=$id";

    if ($conn->query($sql)) {
        echo "<script>alert('Movie updated'); window.location='read_movies.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Movie</title></head>
<body>
<h2>Edit Movie</h2>
<form method="post" enctype="multipart/form-data">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required><br><br>
    Description: <textarea name="description" required><?= htmlspecialchars($movie['description']) ?></textarea><br><br>
    Trailer URL: <input type="text" name="trailer_url" value="<?= htmlspecialchars($movie['trailer_url']) ?>"><br><br>
    Release Date: <input type="date" name="release_date" value="<?= $movie['release_date'] ?>" required><br><br>
    Duration: <input type="number" name="duration" value="<?= $movie['duration'] ?>"><br><br>
    Rating: <input type="number" step="0.1" name="rating" value="<?= $movie['rating'] ?>"><br><br>
    Current Image: <br>
    <?php if (!empty($movie['movie_img'])): ?>
        <img src="<?= $movie['movie_img'] ?>" width="120"><br><br>
    <?php endif; ?>
    Upload New Image: <input type="file" name="file"><br><br>
    <button type="submit" name="update">Update</button>
</form>
</body>
</html>
