<?php
include('db.php');
session_start();
if ($_SESSION['role'] != 'admin') {
  header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $query = "INSERT INTO categories (name) VALUES ('$name')";
  mysqli_query($conn, $query);
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<form method="POST" action="manage_categories.php">
  <input type="text" name="name" placeholder="Category Name" required />
  <button type="submit">Add Category</button>
</form>

<ul>
  <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
    <li><?php echo $category['name']; ?></li>
  <?php } ?>
</ul>
