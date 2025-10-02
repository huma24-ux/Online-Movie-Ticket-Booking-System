<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $password  = password_hash($_POST['password'], PASSWORD_BCRYPT); // secure password
    $age       = $_POST['age'];
    $role      = $_POST['role'];

    $sql = "INSERT INTO users (full_name, email, password, age, role) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $full_name, $email, $password, $age, $role);

    if ($stmt->execute()) {
        echo "New user created successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<style>
    form {
        margin: 40px auto;
        padding: 30px;
        border: 1px solid #ccc;
        width: 350px;
        border-radius: 8px;
        background: #f9f9f9;
    }
    form input, form select, form button {
        margin-bottom: 15px;
        padding: 8px;
        width: 100%;
        box-sizing: border-box;
    }
    form label {
        margin-bottom: 5px;
        display: block;
    }
</style>
<form method="POST">
    <label>Full Name:</label>
    <input type="text" name="full_name" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <label>Age:</label>
    <input type="number" name="age"><br>
    <label>Role:</label>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Add User</button>
</form>
 
