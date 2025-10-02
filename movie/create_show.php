<?php
include 'connect.php';

// Fetch movies and theaters for dropdowns
$movies = $conn->query("SELECT * FROM movies");
$theaters = $conn->query("SELECT * FROM theaters");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id   = $_POST['movie_id'];
    $theater_id = $_POST['theater_id'];
    $show_date  = $_POST['show_date'];
    $show_time  = $_POST['show_time'];

    $sql = "INSERT INTO shows (movie_id, theater_id, show_date, show_time)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $movie_id, $theater_id, $show_date, $show_time);

    if ($stmt->execute()) {
        header("Location: read_shows.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<style>
    body {
        margin: 30px;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    form {
        margin: 20px 0;
        padding: 20px;
        border: 1px solid #ccc;
        width: 350px;
        background: #f9f9f9;
    }
    form input, form select {
        margin-bottom: 10px;
        padding: 6px;
        width: 95%;
        box-sizing: border-box;
    }
    button {
        padding: 8px 16px;
        margin-top: 10px;
    }
</style>
<h2>Add Show</h2>
<form method="POST">
    Movie:
    <select name="movie_id">
        <?php while($m = $movies->fetch_assoc()) { ?>
        <option value="<?= $m['movie_id'] ?>"><?= $m['title'] ?></option>
        <?php } ?>
    </select><br>

    Theater:
    <select name="theater_id">
        <?php while($t = $theaters->fetch_assoc()) { ?>
        <option value="<?= $t['theater_id'] ?>"><?= $t['theater_name'] ?></option>
        <?php } ?>
    </select><br>

    Date: <input type="date" name="show_date" required><br>
    Time: <input type="time" name="show_time" required><br>
    <button type="submit">Save</button>
</form>
