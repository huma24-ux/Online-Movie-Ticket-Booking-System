<?php
include 'connect.php';

$sql = "SELECT s.show_id, m.title AS movie, t.theater_name, s.show_date, s.show_time
    FROM shows s
    JOIN movies m ON s.movie_id = m.movie_id
    JOIN theaters t ON s.theater_id = t.theater_id";
$result = $conn->query($sql);
?>
<style>
body {
    margin: 30px;
    padding: 0;
    font-family: Arial, sans-serif;
}
h2 {
    margin-bottom: 20px;
}
a {
    margin-right: 10px;
}
table {
    border-collapse: collapse;
    margin-top: 20px;
    width: 100%;
}
th, td {
    padding: 12px 16px;
    text-align: left;
}
th {
    background: #f0f0f0;
}
tr:nth-child(even) {
    background: #fafafa;
}
</style>
<h2>Shows List</h2>
<a href="create_show.php">Add New Show</a>
<table border="1" cellpadding="5">
<tr>
  <th>ID</th><th>Movie</th><th>Theater</th><th>Date</th><th>Time</th><th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?= $row['show_id'] ?></td>
  <td><?= $row['movie'] ?></td>
  <td><?= $row['theater_name'] ?></td>
  <td><?= $row['show_date'] ?></td>
  <td><?= $row['show_time'] ?></td>
  <td>
    <a href="edit_show.php?id=<?= $row['show_id'] ?>">Edit</a> | 
    <a href="delete_show.php?id=<?= $row['show_id'] ?>" onclick="return confirm('Delete this show?')">Delete</a>
  </td>
</tr>
<?php } ?>
</table>
