<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "videos1";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file and caption are provided
    if (isset($_FILES['file']) && isset($_POST['caption'])) {
        $file = $_FILES['file'];
        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $user_image = 'default-avatar.png'; // Default image for user avatar if not provided
        $username = $_SESSION['username']; // Assuming the username is stored in the session

        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if file is an image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                // Insert the post data into the database
                $sql = "INSERT INTO posts (username, user_image, file_name, caption, created_at) 
                        VALUES ('$username', '$user_image', '" . basename($file["name"]) . "', '$caption', NOW())";
                if (mysqli_query($conn, $sql)) {
                    echo "Post uploaded successfully!";
                    header('Location: Home.php');  // Redirect to feed page
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Post</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            padding: 20px;
        }

        .upload-form {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .upload-form input[type="file"] {
            width: 100%;
            margin-bottom: 15px;
        }

        .upload-form textarea {
            width: 100%;
            height: 150px;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .upload-form button {
            background-color: #e50914;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .upload-form button:hover {
            background-color: #ff0c00;
        }
    </style>
</head>
<body>

    <h2>Upload a Post</h2>

    <div class="upload-form">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Select image to upload:</label>
            <input type="file" name="file" id="file" required>
            
            <label for="caption">Caption:</label>
            <textarea name="caption" id="caption" required></textarea>
            
            <button href="Home.php" type="submit">Upload Post</button>
        </form>
    </div>

</body>
</
