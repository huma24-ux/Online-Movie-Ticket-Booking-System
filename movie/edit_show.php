<?php
include 'connect.php';
$id = $_GET['id'];

// Fetch movies, theaters, and current show
$movies = $conn->query("SELECT * FROM movies");
$theaters = $conn->query("SELECT * FROM theaters");
$show = $conn->query("SELECT * FROM shows WHERE show_id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id   = $_POST['movie_id'];
    $theater_id = $_POST['theater_id'];
    $show_date  = $_POST['show_date'];
    $show_time  = $_POST['show_time'];

    $sql = "UPDATE shows SET movie_id=?, theater_id=?, show_date=?, show_time=? WHERE show_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $movie_id, $theater_id, $show_date, $show_time, $id);

    if ($stmt->execute()) {
        header("Location: read_shows.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 40px;
    background: #f9f9f9;
}
form {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    max-width: 400px;
    margin: 0 auto;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
form select, form input[type="date"], form input[type="time"] {
    width: 100%;
    padding: 8px;
    margin: 8px 0 16px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}
form button {
    padding: 10px 20px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
form button:hover {
    background: #0056b3;
}
h2 {
    text-align: center;
    margin-bottom: 24px;
}
</style>
<h2>Edit Show</h2>
<form method="POST">
    Movie:
    <select name="movie_id">
        <?php while($m = $movies->fetch_assoc()) { ?>
        <option value="<?= $m['movie_id'] ?>" <?= $m['movie_id']==$show['movie_id']?"selected":"" ?>>
            <?= $m['title'] ?>
        </option>
        <?php } ?>
    </select><br>

    Theater:
    <select name="theater_id">
        <?php while($t = $theaters->fetch_assoc()) { ?>
        <option value="<?= $t['theater_id'] ?>" <?= $t['theater_id']==$show['theater_id']?"selected":"" ?>>
            <?= $t['theater_name'] ?>
        </option>
        <?php } ?>
    </select><br>

    Date: <input type="date" name="show_date" value="<?= $show['show_date'] ?>"><br>
    Time: <input type="time" name="show_time" value="<?= $show['show_time'] ?>"><br>
    <button type="submit">Update</button>
</form>
