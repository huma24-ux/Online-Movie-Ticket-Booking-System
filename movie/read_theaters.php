<?php include 'connect.php'; 
include 'header.php';


?>

<div class="container my-5">
    <h2 class="mb-4">Theaters List</h2>
    <a href="create_theater.php" class="btn btn-primary mb-3">+ Add Theater</a>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Theater Name</th>
                <th>Location</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM theaters ORDER BY theater_id DESC");
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $row['theater_id'] ?></td>
                <td><?= htmlspecialchars($row['theater_name']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><img src="<?= $row['theater_img'] ?>" width="100" height="100"></td>
                <td>
                    <a href="edit_theater.php?id=<?= $row['theater_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_theater.php?id=<?= $row['theater_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this theater?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>



<?php
include 'footer.php';
?>
