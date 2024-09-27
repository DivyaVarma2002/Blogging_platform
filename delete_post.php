<?php
include('db.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_role = $_SESSION['role']; 
    $user_id = $_SESSION['user_id']; 
    if ($user_role == 'admin') {
        $delete_query = "DELETE FROM posts WHERE id = '$post_id'";
        
        if (mysqli_query($conn, $delete_query)) {
            header("Location: index.php?message=PostDeleted");
            exit();
        } else {
            echo "Error deleting post: " . mysqli_error($conn);
        }
    } else {
        echo "You do not have permission to delete this post.";
    }
} else {
    echo "Invalid request.";
}
?>
