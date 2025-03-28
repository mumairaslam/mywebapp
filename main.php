<?php
// Database connection details
$hostname = "sahrjeelmysql.mysql.database.azure.com";
$username = "sharjeel";
$password = "Sa1234567";
$dbname = "netflix";

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into users table if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO users (username, password, FName, LName, Email, ContactNumber) VALUES ('$username', '$password', '$fname', '$lname', '$email', '$contact')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green; text-align: center;'>You have been registered successfully.</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form method="POST" action="">
            <div>
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>First Name:</label>
                <input type="text" name="fname" required>
            </div>
            <div>
                <label>Last Name:</label>
                <input type="text" name="lname" required>
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Contact Number:</label>
                <input type="text" name="contact" required>
            </div>
            <div>
                <button type="submit">Sign Up</button>
            </div>
        </form>
    </div>

    <h2 style="text-align:center;">Users List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["FName"] . "</td>";
                    echo "<td>" . $row["LName"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["ContactNumber"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-users'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>