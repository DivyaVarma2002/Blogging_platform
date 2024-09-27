<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<h1>Blog Posts</h1>
<br>
<a href="create_post.php">
    <button style="padding: 10px 20px; margin-bottom: 20px;">
        Create Post
    </button>
</a>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include('db.php');
        session_start();
        $posts_query = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");

        if (mysqli_num_rows($posts_query) > 0) {
            while ($post = mysqli_fetch_assoc($posts_query)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($post['title']) . "</td>";
                echo "<td>" . substr(htmlspecialchars($post['content']), 0, 100) . "...</td>";
                echo "<td>
                        <a href='view_post.php?id=" . $post['id'] . "'>Read More</a><br>
                        <form method='POST' action='delete_post.php' style='display:block;' onsubmit='return confirm(\"Are you sure you want to delete this post?\");'>
                            <input type='hidden' name='post_id' value='" . $post['id'] . "'>
                            <button type='submit' style=''>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No posts available.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
