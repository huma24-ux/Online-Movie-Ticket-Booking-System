<?php
include 'connect.php';
$id = intval($_GET['id']);
$row = $conn->query("SELECT * FROM theaters WHERE theater_id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Theater</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Edit Theater</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['theater_id'] ?>">
        <div class="mb-3">
            <label class="form-label">Theater Name</label>
            <input type="text" name="theater_name" value="<?= htmlspecialchars($row['theater_name']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($row['location']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="<?= $row['theater_img'] ?>" width="120">
        </div>

        <div class="mb-3">
            <label class="form-label">Change Image</label>
            <input type="file" name="updatedImage" class="form-control" accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="read_theaters.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $theater_name = $_POST['theater_name'];
    $location = $_POST['location'];

    if (!empty($_FILES['updatedImage']['name'])) {
        $newName = $_FILES['updatedImage']['name'];
        $newTmp  = $_FILES['updatedImage']['tmp_name'];
        $newSize = $_FILES['updatedImage']['size'];
        $newType = $_FILES['updatedImage']['type'];

        $newPath = "images/theaters/" . uniqid("theater_", true) . "_" . basename($newName);

        if (in_array(strtolower($newType), ['image/jpg','image/jpeg','image/png'])) {
            if ($newSize <= 1000000) {
                move_uploaded_file($newTmp, $newPath);
                $sql = "UPDATE theaters SET theater_name='$theater_name', location='$location', theater_img='$newPath' WHERE theater_id=$id";
            }
        }
    } else {
        $sql = "UPDATE theaters SET theater_name='$theater_name', location='$location' WHERE theater_id=$id";
    }
    $conn->query($sql);
    echo "<script>alert('Updated Successfully'); window.location='read_theaters.php';</script>";
}
?>
</body>
</html>
