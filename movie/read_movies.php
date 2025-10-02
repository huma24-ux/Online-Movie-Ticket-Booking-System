<?php
include 'connect.php';
include 'header.php';

$result = $conn->query("SELECT * FROM movies");
?>

<div class="col-sm-12 m-5">
    <div class="bg-light rounded h-100 p-4">
        <!-- Add New Movie Button -->
        <a href="create_movie.php" class="btn btn-primary mb-4">
            <i class="fa fa-plus me-2"></i>Add New Movie
        </a>

        <h6 class="mb-4">Movies</h6>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Trailer</th>
                    <th scope="col">Date</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <th scope="row"><?= $row['movie_id'] ?></th>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><a href="<?= $row['trailer_url'] ?>" target="_blank">Watch</a></td>
                    <td><?= $row['release_date'] ?></td>
                    <td><?= $row['duration'] ?> min</td>
                    <td><?= $row['rating'] ?></td>
                    <td><img src="<?= $row['movie_img'] ?>" width="100" alt="Movie Image"></td>
                    <td>
                        <a href="edit_movie.php?id=<?= $row['movie_id'] ?>" class="text-warning">
                            <i class="fa fa-pencil me-2"></i>Edit
                        </a> | 
                        <a href="delete_movie.php?id=<?= $row['movie_id'] ?>" onclick="return confirm('Delete this movie?')" class="text-danger">
                            <i class="fa fa-trash me-2"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'footer.php';
?>
