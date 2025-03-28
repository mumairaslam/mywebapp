<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signin-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #e50914;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 25px;
            padding: 10px;
            font-size: 16px;
        }

        .btn-signin {
            width: 100%;
            background-color: #e50914;
            color: #fff;
            border-radius: 25px;
            padding: 12px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .btn-signin:hover {
            background-color: #ff0c00;
        }

        .text-center {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="signin-container">
        <h2>Sign In</h2>
        <form action="signin_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-signin">Sign In</button>
        </form>
        <div class="text-center">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>

</html>