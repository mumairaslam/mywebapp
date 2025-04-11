<?php
// Database connection
$hostname = "localhost";
$username = "root";
$password = "";  
$dbname = "videos1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $FName = mysqli_real_escape_string($conn, $_POST['FName']);
    $LName = mysqli_real_escape_string($conn, $_POST['LName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Password = mysqli_real_escape_string($conn, $_POST['Password']);
    
    // Hash the password
    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
    
    // SQL query to insert data into the users table
    $sql = "INSERT INTO users (FName, LName, Email, Password)
            VALUES ('$FName', '$LName', '$Email' , '$hashed_password')";
    
    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
        header('Location: Home.php'); // Redirect after successful registration
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close connection
    $conn->close();
}
?>
