<?php
include 'connect.php';

if (isset($_POST['ins'])) {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $trailer_url = $_POST['trailer_url'];
    $release_date= $_POST['release_date'];
    $duration    = $_POST['duration'];
    $rating      = $_POST['rating'];

    $fileName = $_FILES['file']['name'];
    $fileTmp  = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    $uploadDir = "images/movies/";
    $folder = $uploadDir . basename($fileName);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowed = ['image/jpg', 'image/png', 'image/jpeg'];

    if (in_array(strtolower($fileType), $allowed)) {
        if ($fileSize <= 1000000) {
            if (move_uploaded_file($fileTmp, $folder)) {
                $sql = "INSERT INTO movies (title, description, trailer_url, release_date, duration, rating, movie_img) 
                        VALUES ('$title', '$description', '$trailer_url', '$release_date', '$duration', '$rating', '$folder')";
                if ($conn->query($sql)) {
                    echo "<script>alert('Movie added successfully'); window.location='read_movies.php';</script>";
                } else {
                    echo "Error: " . $conn->error;
                }
            }
        } else {
            echo "<script>alert('File size must be less than 1MB');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Movie</title></head>
<body>
<h2>Add Movie</h2>
<form method="post" enctype="multipart/form-data">
    Title: <input type="text" name="title" required><br><br>
    Description: <textarea name="description" required></textarea><br><br>
    Trailer URL: <input type="text" name="trailer_url"><br><br>
    Release Date: <input type="date" name="release_date" required><br><br>
    Duration (min): <input type="number" name="duration" required><br><br>
    Rating: <input type="number" step="0.1" name="rating" required><br><br>
    Image: <input type="file" name="file" required><br><br>
    <button type="submit" name="ins">Save</button>
</form>
</body>
</html>
