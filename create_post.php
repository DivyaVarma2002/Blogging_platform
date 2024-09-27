<?php
include('db.php');
session_start();

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];
    } else {
        $category_id = null; 
    }
    $author_id = $_SESSION['user_id'];
    $query = "INSERT INTO posts (title, content, category_id, author_id) VALUES ('$title', '$content', '$category_id', '$author_id')";
    
    if (mysqli_query($conn, $query)) {
        $message = "Your post has been created successfully!"; 
    } else {
        $message = "Error: " . mysqli_error($conn); 
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css"> <
    <script>
         function showAlert() {
            alert("<?php echo addslashes($message); ?>"); 
        }
        window.onload = function() {
            <?php if ($message) { echo "showAlert();"; } ?>
        };
    </script>
</head>
<body>
<center>
<form method="POST" action="create_post.php">
    <input type="text" name="title" placeholder="Post Title" required />
    <textarea name="content" placeholder="Content" required></textarea>
   <button type="submit">Create Post</button>
</form>
</center>
</body>
</html>
