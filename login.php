<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Global Styles */
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Center the login form on the page */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login Form Styles */
        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Input Styles */
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
        }

        /* Button Styles */
        .btn-login {
            background-color: #007bff;
            color: #fff;
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        /* Error message style */
        .error-message {
            color: #ff4d4d;
            text-align: center;
            margin-top: 10px;
        }

        /* Link styles */
        .signup-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .signup-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- Login Form Container -->
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>
            
            <!-- Form start -->
            <form action="login_process.php" method="POST">
                
                <!-- Username Input -->
                <input type="text" name="username" class="form-control" placeholder="Username" required>

                <!-- Password Input -->
                <input type="password" name="password" class="form-control" placeholder="Password" required>

                <!-- Login Button -->
                <button type="submit" class="btn-login">Login</button>
                
                <!-- Display error message if login failed -->
                <div class="error-message">
                    <!-- This error message will be shown dynamically using PHP -->
                    <?php
                    if (isset($_GET['error'])) {
                        echo "Invalid username or password.";
                    }
                    ?>
                </div>

            </form>

            <!-- Sign-up link -->
            <a href="signup.php" class="signup-link">Don't have an account? Sign up</a>
        </div>
    </div>

</body>

</html>
