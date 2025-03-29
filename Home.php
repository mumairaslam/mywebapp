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
            background: linear-gradient(45deg, #54046f, #e91e63, #4a148c, #f50057);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
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
            color: rgb(63, 27, 29);
        }

        .nav-bar .profile-btn {
            color: #e50914;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            display: block;
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
            text-decoration: none;
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

        /* Image Feed Layout */
        .feed {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
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

        .post img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .post-details {
            padding: 15px;
        }

        .post-details .post-header {
            display: flex;
            align-items: center;
        }

        .post-details .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post-details h4 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .post-details p {
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }

        /* Actions below each post */
        .post-actions {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .post-actions i {
            font-size: 18px;
            cursor: pointer;
            color: #e50914;
            transition: color 0.3s ease;
        }

        /* Liked state - solid heart with a darker red */
        .post-actions i.liked {
            color: #ff0c00; /* Liked heart color */
        }

        /* Additional styling for the solid heart */
        .post-actions i.fas {
            color: #ff0c00; /* Solid heart color */
        }
        
        /* Comment Section Styles */
        .comment-section {
            margin-top: 15px;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        .comment-section input[type="text"] {
            width: 80%;
            padding: 8px;
            margin-right: 10px;
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
            margin-top: 10px;
        }

        .comment {
            margin-bottom: 8px;
            font-size: 14px;
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

        <!-- Logout Button aligned to the right -->
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
            // Display each post
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="post">';
                echo '<img src="uploads/' . $row['file_name'] . '" alt="Post Image">';
                echo '<div class="post-details">';
                echo '<p>' . $row['caption'] . '</p>';
                echo '<div class="post-actions">';
                echo '<i class="far fa-heart like-btn" onclick="toggleLike(this)"></i>';  // Like icon
                echo '</div>';
                // Fetch comments for each post
                $comments_query = "SELECT * FROM comments WHERE post_id = " . $row['id'];
                $comments_result = mysqli_query($conn, $comments_query);
                echo '<div class="comment-section">';
                echo '<form method="POST" action="">';
                echo '<input type="text" name="comment" placeholder="Add a comment..." required>';
                echo '<input type="hidden" name="post_id" value="' . $row['id'] . '">';
                echo '<button type="submit">Comment</button>';
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
            // Toggle between liked (solid heart) and unliked (empty heart)
            button.classList.toggle("liked");

            // Optionally, change the icon (from empty to solid heart)
            if (button.classList.contains("liked")) {
                button.classList.remove("far");
                button.classList.add("fas"); // 'fas' is for solid icons
            } else {
                button.classList.remove("fas");
                button.classList.add("far"); // 'far' is for regular (empty) icons
            }
        }
    </script>

</body>
</html>

<?php
mysqli_close($conn);
?>
