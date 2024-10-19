<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "moviedb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin profile info from the database
$admin_id = 1; // Replace with the actual admin ID based on your authentication system
$admin_result = $conn->query("SELECT * FROM admin WHERE admin_id = $admin_id");
$admin = $admin_result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $key = $conn->real_escape_string($_POST['key']);
    $new_password = $_POST['new_password'];

    // Prepare the update SQL query
    $update_sql = "UPDATE admin SET name = '$name', `key` = '$key'";

    if (!empty($new_password)) {
        // Only update password if it's provided
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password
        $update_sql .= ", password = '$hashed_password'";
    }

    $update_sql .= " WHERE admin_id = $admin_id";

    // Execute the update query
    if ($conn->query($update_sql) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="admin_profile.css">
    <style>
        .admin-profile-container {
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-size: 1em;
            color: red;
        }
        input {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="admin-profile-container">
        <h2>Admin Profile</h2>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>

            <label for="key">Key:</label>
            <input type="text" id="key" name="key" value="<?php echo htmlspecialchars($admin['key']); ?>" required>

            <label for="new_password">New Password (leave blank if you don't want to change):</label>
            <input type="password" id="new_password" name="new_password">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    
</body>
</html>
