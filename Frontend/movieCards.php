<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 15;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search_query = "";
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM moviesdata WHERE title LIKE '%$search_query%' LIMIT $limit OFFSET $offset";
} else {
    $total_result = $conn->query("SELECT COUNT(*) AS count FROM moviesdata");
    $total_row = $total_result->fetch_assoc();
    $total_movies = $total_row['count'];
    $total_pages = ceil($total_movies / $limit);
    $sql = "SELECT * FROM moviesdata LIMIT $limit OFFSET $offset";
}

$result = $conn->query($sql);
if (empty($search_query)) {
    $total_movies = $total_row['count'];
    $total_pages = ceil($total_movies / $limit);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Cards</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            color: white;
        }

        .search-form {
            display: flex;
            justify-content: center; 
            align-items: center;
            margin: 0;
            width: 100%;
          
        }

        .search-bar {
            flex: 1;
            /* Allow the search bar to grow */
            padding: 10px;
            margin-right: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid #ff4757;
            border-radius: 5px 0 0 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-bar:focus {
            border-color: #ff6b81;
        }

        .search-button {
            background-color: #ff4757;
            border: none;
            border-radius: 0 5px 5px 0;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-button i {
            color: white;
            font-size: 18px;
        }

        .search-button:hover {
            background-color: #ff6b81;
        }

        .movie-cards {
            margin: 15px;
            padding: 15px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .movie-card {
            position: relative;
            width: 200px;
            height: 300px;
            overflow: hidden;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .movie-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .movie-card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            z-index: 2;
            text-align: center;
        }

        .movie-card-content h3 {
            margin: 5px 0;
            font-size: 1.2em;
        }

        .movie-card-content p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        .movie-card-content a {
            display: inline-block;
            margin-top: 5px;
            padding: 8px 15px;
            background-color: transparent;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid red;
            transition: background 0.3s;
        }

        .movie-card-content a:hover {
            background-color: red;
            color: white;
        }

        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .pagination a:hover {
            background: #0056b3;
        }

        .pagination a.active {
            background: #0056b3;
            pointer-events: none;
            color: white;
        }

        @media (max-width: 600px) {
            .movie-cards {
                grid-template-columns: repeat(2, 1fr);
                /* Adjust for smaller screens */
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <form method="POST" class="search-form">
        <input type="text" name="search" class="search-bar" placeholder="Search for movies..."
            value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit" class="search-button">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <div class="movie-cards">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="movie-card">
                    <img src="<?php echo $row['poster']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <div class="movie-card-content">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Release Year:</strong> <?php echo htmlspecialchars($row['releaseyear']); ?></p>
                        <a href="Frontend/movie_detail.php?id=<?php echo $row['id']; ?>">More Info</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='color: white;'>No movies found.</p>";
        }
        ?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i === $page)
                   echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>