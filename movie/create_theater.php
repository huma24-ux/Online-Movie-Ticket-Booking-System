<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Theater</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Add New Theater</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Theater Name</label>
            <input type="text" name="theater_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png" required>
        </div>

        <button type="submit" name="ins" class="btn btn-primary">Save</button>
        <a href="read_theaters.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php
if (isset($_POST['ins'])) {
    $theater_name = $_POST['theater_name'];
    $location     = $_POST['location'];

    $fileName = $_FILES['file']['name'];
    $fileTmp  = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];

    $uploadDir = "images/theaters/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $newFile = $uploadDir . uniqid("theater_", true) . "_" . basename($fileName);

    $allowed = ['image/jpg','image/jpeg','image/png'];

    if (in_array(strtolower($fileType), $allowed)) {
        if ($fileSize <= 1000000) {
            if (move_uploaded_file($fileTmp, $newFile)) {
                $sql = "INSERT INTO theaters (theater_name,theater_img,location) VALUES ('$theater_name','$newFile','$location')";
                if ($conn->query($sql)) {
                    echo "<script>alert('Theater Added'); window.location='read_theaters.php';</script>";
                }
            } else {
                echo "<script>alert('Failed to upload image');</script>";
            }
        } else {
            echo "<script>alert('Image must be < 1MB');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type');</script>";
    }
}
?>
</body>
</html>
