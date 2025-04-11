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
    // Check if file, caption, location, present_person, and title are provided
    if (isset($_FILES['file'], $_POST['caption'], $_POST['location'], $_POST['person'], $_POST['title'])) {
        $file = $_FILES['file'];
        $caption = mysqli_real_escape_string($conn, $_POST['caption']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $person = mysqli_real_escape_string($conn, $_POST['person']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $user_image = 'default-avatar.png'; // Default image for user avatar if not provided

        // Check if username is set in the session
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'default'; 

        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Allow certain file formats: Images and Videos
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif'];
        $allowed_video_types = ['mp4', 'avi', 'mov', 'mkv'];

        // Check if the file is an image
        if (in_array($fileType, $allowed_image_types)) {
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    // Insert post data into the database
                    $sql = "INSERT INTO posts (username, user_image, file_name, caption, location, person, title, created_at, file_type) 
                            VALUES ('$username', '$user_image', '" . basename($file["name"]) . "', '$caption', '$location', '$person', '$title', NOW(), 'image')";
                    if (mysqli_query($conn, $sql)) {
                        echo "Post uploaded successfully!";
                        header('Location: Home.php');  // Redirect to the feed page
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not a valid image.";
            }
        }
        // Check if the file is a video
        elseif (in_array($fileType, $allowed_video_types)) {
            // Check if the file's MIME type matches the video type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            $allowed_video_mime_types = ['video/mp4', 'video/avi', 'video/mov', 'video/x-matroska'];

            if (in_array($mime_type, $allowed_video_mime_types)) {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    // Insert post data into the database
                    $sql = "INSERT INTO posts (username, user_image, file_name, caption, location, person, title, created_at, file_type) 
                            VALUES ('$username', '$user_image', '" . basename($file["name"]) . "', '$caption', '$location', '$person', '$title', NOW(), 'video')";
                    if (mysqli_query($conn, $sql)) {
                        echo "Post uploaded successfully!";
                        header('Location: Home.php');  // Redirect to the feed page
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Sorry, there was an error uploading your video.";
                }
            } else {
                echo "Invalid video file type. Only mp4, avi, mov, mkv are allowed.";
            }
        } else {
            echo "Invalid file type. Only images and videos are allowed.";
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
        /* Body and general background */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text for readability */
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        /* Website title heading */
        h1 {
            text-align: center;
            font-size: 3rem;
            color: #fff;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #e50914, #ff0c00); /* Gradient effect */
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Heading Style for "Upload a Post" */
        h2 {
            text-align: center;
            font-size: 2rem;
            color: #fff;
            margin-bottom: 30px;
            font-weight: 600;
        }

        /* Form container */
        .upload-form {
            max-width: 700px;
            margin: auto;
            background-color: #242424; /* Dark background for the form */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4); /* Smooth shadow effect */
            transition: all 0.3s ease;
            width: 100%;
        }

        .upload-form:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5); /* Deeper shadow on hover */
        }

        /* Form Label Styling */
        .upload-form label {
            font-size: 16px;
            font-weight: 500;
            color: #e0e0e0;
            margin-bottom: 10px;
            display: block;
        }

        /* Form inputs and text area */
        .upload-form input[type="file"],
        .upload-form input[type="text"],
        .upload-form textarea {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #444;
            background-color: #333;
            color: #e0e0e0;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .upload-form input[type="file"]:hover,
        .upload-form input[type="text"]:hover,
        .upload-form textarea:hover {
            border-color: #ff0c00;
            background-color: #444;
        }

        .upload-form textarea {
            height: 150px;
            resize: vertical;
            font-family: 'Poppins', sans-serif;
        }

        /* Button styling */
        .upload-form button {
            background-color: #e50914; /* Red accent for the button */
            color: white;
            padding: 18px 30px;
            font-size: 18px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            border-radius: 50px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .upload-form button:hover {
            background-color: #ff0c00; /* Lighter red on hover */
            transform: translateY(-2px); /* Slight movement on hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4); /* Deeper shadow */
        }

        /* Smooth focus transition for inputs and text area */
        .upload-form input[type="file"]:focus,
        .upload-form input[type="text"]:focus,
        .upload-form textarea:focus {
            outline: none;
            border-color: #ff0c00;
            box-shadow: 0 0 5px rgba(255, 12, 0, 0.6);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .upload-form {
                padding: 20px;
                box-shadow: none;
            }

            h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .upload-form input[type="file"],
            .upload-form input[type="text"],
            .upload-form textarea {
                padding: 12px;
            }

            .upload-form button {
                padding: 15px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Website title -->
    <h1>Instagram Clone</h1>

    <!-- "Upload a Post" heading -->
    <h2>Upload a Post</h2>

    <!-- Form container -->
    <div class="upload-form">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Select image/video to upload:</label>
            <input type="file" name="file" id="file" required>
            
            <label for="caption">Caption:</label>
            <textarea name="caption" id="caption" placeholder="Write a caption..." required></textarea>
            
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" placeholder="Enter location" required>
            
            <label for="person">Present Person:</label>
            <input type="text" name="person" id="person" placeholder="Enter person's name" required>
            
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" placeholder="Enter title for your post" required>
            
            <button type="submit">Upload Post</button>
        </form>
    </div>

</body>
</html>



