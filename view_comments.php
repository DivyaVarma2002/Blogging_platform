<?php
include('db.php'); 


if (isset($_GET['post_id']) || isset($_POST['post_id'])) {
    $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : $_POST['post_id'];

    
    $query = "
        SELECT posts.title AS post_title, comments.id AS comment_id, comments.comment, comments.created_at, users.username, users.id AS user_id
        FROM comments 
        JOIN posts ON comments.post_id = posts.id 
        JOIN users ON comments.user_id = users.id 
        WHERE posts.id = '$post_id' 
        ORDER BY comments.created_at DESC
    ";

    $comments_result = mysqli_query($conn, $query);

    if (!$comments_result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    if (mysqli_num_rows($comments_result) > 0) {
      
        $first_comment = mysqli_fetch_assoc($comments_result);
        $post_title = $first_comment['post_title'];

     
        mysqli_data_seek($comments_result, 0);

 
        echo "<h3>Comments for Blog: " . htmlspecialchars($post_title) . "</h3>";

    
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr><th>User</th><th>Comment</th><th>Date</th><th>Action</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($comment = mysqli_fetch_assoc($comments_result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($comment['username']) . "</td>";
            echo "<td>" . htmlspecialchars($comment['comment']) . "</td>";
            echo "<td>" . htmlspecialchars($comment['created_at']) . "</td>";
            
            if ($_SESSION['role'] == 'admin' || $_SESSION['user_id'] == $comment['user_id']) {
                echo "<td>";
                echo "<form method='POST' action='delete_comment.php' onsubmit='return confirm(\"Are you sure you want to delete this comment?\");'>";
                echo "<input type='hidden' name='comment_id' value='" . $comment['comment_id'] . "'>";
                echo "<input type='hidden' name='post_id' value='" . $post_id . "'>";
                echo "<button type='submit'>Delete</button>";
                echo "</form>";
                echo "</td>";
            } else {
                echo "<td>—</td>";
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No comments available for this post.</p>";
    }
} else {
    echo "<p>No post selected.</p>";
}
?>
