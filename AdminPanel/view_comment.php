>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all comments
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
    $comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;

    if ($comment_id > 0) {
        $delete_sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $comment_id);

        if ($stmt->execute()) {
            echo "<p style='color: #4caf50;'>Comment deleted successfully.</p>";
            // Refresh the page to show updated comments
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<p style='color: #ff4444;'>Error deleting comment: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: #ff4444;'>Invalid comment ID.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Comments</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #f5f5f5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #1f1f1f;
            color: #f5f5f5;
        }

        table th,
        table td {
            padding: 15px;
            border: 1px solid #ff6b6b;
            text-align: center;
        }

        table th {
            background-color: #ff6b6b;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #2f2f2f;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            color: #ff6b6b;
        }
    </style>
</head>

<body>
    <h2>All Comments</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type="submit" name="delete_comment" style="background-color: #ff4444; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>  
        <p>No comments found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>

</html>
