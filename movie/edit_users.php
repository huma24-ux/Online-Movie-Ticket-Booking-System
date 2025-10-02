<?php
include 'connect.php';
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $age       = $_POST['age'];
    $role      = $_POST['role'];

    $sql = "UPDATE users SET full_name=?, email=?, age=?, role=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $full_name, $email, $age, $role, $id);

    if ($stmt->execute()) {
        echo "User updated!";
        header("Location: read_users.php");
    }
}

$user = $conn->query("SELECT * FROM users WHERE user_id=$id")->fetch_assoc();
?>
<style>
    form {
        margin: 40px auto;
        padding: 30px;
        max-width: 400px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    input, select {
        margin-bottom: 15px;
        padding: 8px;
        width: 100%;
        box-sizing: border-box;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    button {
        padding: 10px 20px;
        border: none;
        background: #007bff;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
<form method="POST">
    Full Name: <input type="text" name="full_name" value="<?= $user['full_name'] ?>"><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>"><br>
    Age: <input type="number" name="age" value="<?= $user['age'] ?>"><br>
    Role: 
    <select name="role">
        <option value="user" <?= $user['role']=="user"?"selected":"" ?>>User</option>
        <option value="admin" <?= $user['role']=="admin"?"selected":"" ?>>Admin</option>
    </select><br>
    <button type="submit">Update</button>
</form>
