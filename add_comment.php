<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $comment = strip_tags($_POST['comment']);  
    $comment = mysqli_real_escape_string($conn, $comment);  
    $query = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
    mysqli_query($conn, $query);
    header("Location: view_post.php?id=$post_id");
}
?>
