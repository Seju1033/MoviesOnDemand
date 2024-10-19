<?php
session_start();

// Define hardcoded admin credentials (for testing only)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'password123'); // Change this to a more secure password in production

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_id'] = session_id(); // Store session id to verify admin login
        $_SESSION['username'] = $username; // Store username
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file for styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://wallpapercave.com/wp/wp10615910.jpg'); /* Background image */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #000; /* Change text color to black for better visibility on white background */
        }

        .login-container {
            background: rgba(255, 255, 255, 0.8); /* White background with some transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333; /* Darker color for the header */
            font-size: 24px;
        }

        .login-container label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
            color: #333; /* Darker color for labels */
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        .login-container input:focus {
            border-color: #FFDD44; /* Yellow border on focus */
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #FF4444; /* Bright red color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }

        .login-container button:hover {
            background: #FF2222; /* Darker red on hover */
        }

        .error-message {
            color: #FF4444; /* Bright red for error messages */
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Responsive design */
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
