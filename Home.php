<?php
session_start();

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";  
$dbname = "videos1";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();  // Destroy session
    header('Location: index.php');  // Redirect to index.php
    exit();
}

// Fetch posts
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

// Add comment functionality
if (isset($_POST['comment']) && isset($_POST['post_id'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $post_id = $_POST['post_id'];
    $username = $_SESSION['username'];  // Assuming the user is logged in

    $comment_query = "INSERT INTO comments (post_id, username, comment) VALUES ('$post_id', '$username', '$comment')";
    mysqli_query($conn, $comment_query);
    header("Location: Home.php");  // Redirect to Home.php after posting a comment
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram-like Feed</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fafafa; /* Lighter background color for a cleaner look */
        }

        /* Navigation Bar */
        .nav-bar {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-bar .logo {
            font-size: 30px;
            font-weight: 600;
            color: #262626;
        }

        .nav-bar .profile-btn {
            color: #e50914;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-bar .profile-btn:hover {
            color: #ff0c00;
        }

        .nav-bar .logout-btn {
            background-color: #e50914;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-bar .logout-btn:hover {
            background-color: #ff0c00;
        }

        /* Upload Button */
        .upload-btn-container {
            margin: 10px;
            display: flex;
            justify-content: center;
        }

        .upload-btn {
            background-color: #e50914;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .upload-btn:hover {
            background-color: #ff0c00;
        }

        /* Feed Layout */
        .feed {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            gap: 20px;
        }

        .post {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .post:hover {
            transform: scale(1.05);
        }

        .post img,
        .post video {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .post-details {
            padding: 15px;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post-header h4 {
            font-size: 16px;
            font-weight: bold;
            color: #262626;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 18px;
        }

        .post-actions i {
            cursor: pointer;
            color: #262626;
            transition: color 0.3s ease;
        }

        .post-actions i:hover {
            color: #e50914;
        }

        .comment-section {
            margin-top: 10px;
            padding: 15px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        .comment-section form {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .comment-section input[type="text"] {
            width: 80%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .comment-section button {
            padding: 8px 15px;
            background-color: #e50914;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .comment-section button:hover {
            background-color: #ff0c00;
        }

        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .comment {
            font-size: 14px;
            color: #262626;
        }

        .comment span {
            font-weight: bold;
            color: #e50914;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="nav-bar">
        <div class="logo">Instagram Clone</div>
        <?php if (isset($_SESSION['username'])): ?>
            <div>
                <a href="profile.php" class="profile-btn">Profile</a>
            </div>
        <?php endif; ?>
        <form method="POST" action="" style="display: inline-block; margin-left: 20px;">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Upload Button -->
    <div class="upload-btn-container">
        <a href="upload.php" class="upload-btn">Upload a Post</a>
    </div>

    <!-- Feed -->
    <div class="feed">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="post">';
                
                // Check if the file is an image or a video based on its extension
                $filePath = 'uploads/' . $row['file_name'];
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                
                // Display image or video based on file type
                if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo '<img src="' . $filePath . '" alt="Post Image">';
                } elseif (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov'])) {
                    echo '<video controls><source src="' . $filePath . '" type="video/' . $fileExtension . '">Your browser does not support the video tag.</video>';
                }
                
                echo '<div class="post-details">';
                echo '<div class="post-header">';
                echo '<h4>'. "Title:"  . '</h4>';  // Replace with actual avatar
                echo '<h4>' . $row['title'] . '</h4>';  // Display the title
                echo '</div>';
                echo '<h4>'. "File Type : " . $row['caption'] . '</h4>';  // Replace with actual avatar
                //echo '<h4>' . $row['caption'] .'</h4>';
                //echo '<p>' . $row['caption'] . '</p>';
                echo '<p><strong>Location:</strong> ' . $row['location'] . '</p>';
                echo '<p><strong>Person:</strong> ' . $row['person'] . '</p>';
                echo '<div class="post-actions">';
                echo '<i class="far fa-heart like-btn" onclick="toggleLike(this)"></i>';  // Like icon
                echo '<i class="far fa-comment"></i>';  // Comment icon
                echo '<i class="far fa-share-square"></i>';  // Share icon
                echo '</div>';
                
                // Fetch comments for each post
                $comments_query = "SELECT * FROM comments WHERE post_id = " . $row['id'];
                $comments_result = mysqli_query($conn, $comments_query);
                echo '<div class="comment-section">';
                echo '<form method="POST" action="">';
                echo '<input type="text" name="comment" placeholder="Add a comment..." required>';
                echo '<input type="hidden" name="post_id" value="' . $row['id'] . '">';
                echo '<button type="submit">Post</button>';
                echo '</form>';
                echo '<div class="comments-list">';
                if ($comments_result && mysqli_num_rows($comments_result) > 0) {
                    while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                        echo '<div class="comment"><span>' . $comment_row['username'] . ':</span> ' . $comment_row['comment'] . '</div>';
                    }
                } else {
                    echo '<div>No comments yet.</div>';
                }
                echo '</div>';  // comments-list
                echo '</div>';  // comment-section
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No posts available.</p>';
        }
        ?>
    </div>

    <script>
        function toggleLike(button) {
            button.classList.toggle("liked");

            if (button.classList.contains("liked")) {
                button.classList.remove("far");
                button.classList.add("fas");
            } else {
                button.classList.remove("fas");
                button.classList.add("far");
            }
        }
    </script>

</body>
</html>


<?php
mysqli_close($conn);
?>
