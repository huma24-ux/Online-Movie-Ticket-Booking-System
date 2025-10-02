<?php
include 'connect.php';
include 'header.php';

$result = $conn->query("SELECT * FROM users");
?>

<style>
.table-hover tbody tr:hover {
    background-color: #e6f7ff;
}
</style>

<div class="col-sm-12 col-xl-6 m-5">
    <div class="bg-light rounded h-100 p-4">
        <!-- Add New User Button -->
        <a href="add_user.php" class="btn btn-primary mb-4">
            <i class="fa fa-user-plus me-2"></i>Add New User
        </a>

        <h6 class="mb-4">User List</h6>
        
        <!-- Table -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Age</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <th scope="row"><?= $row['user_id'] ?></th>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td>
                        <!-- Edit and Delete Icons -->
                        <a href="edit_users.php?id=<?= $row['user_id'] ?>" class="text-warning">
                            <i class="fa fa-pencil me-2"></i>Edit
                        </a> | 
                        <a href="delete_users.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete this user?')" class="text-danger">
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
