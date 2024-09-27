<?php
include('db.php');
session_start(); 


if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    
    echo "Post ID: " . htmlspecialchars($post_id); 

    
    $post_query = mysqli_query($conn, "SELECT * FROM posts WHERE id = '$post_id'");

    
    if (!$post_query) {
        echo "Error in query: " . mysqli_error($conn); 
        exit;
    }

    
    if (mysqli_num_rows($post_query) > 0) {
        $post = mysqli_fetch_assoc($post_query);
        ?>
        
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Post</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>

        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($post['content'])); ?></td>
            </tr>
        </table>

        
        <?php include('view_comments.php'); ?>

        
        <form method="POST" action="add_comment.php">
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>" />
            <textarea name="comment" placeholder="Add your comment here" required></textarea>
            <button type="submit">Post Comment</button>
        </form>

        </body>
        </html>

        <?php
    } else {
        echo "<p>No post found with the given ID.</p>"; 
    }
} else {
    echo "<p>Invalid post ID.</p>";
}
?>
