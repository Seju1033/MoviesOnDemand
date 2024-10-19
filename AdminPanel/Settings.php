<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Query to fetch the movies for the current page
$sql = "SELECT * FROM moviesdata ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Cards</title>
    <style>
        /* General Body Styles */
        /* General Body Styles */
        html,
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* padding: 10px; */
           
        }

        /* Movie Cards Container */
        .movie-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            /* Space between cards */
        }

        /* Individual Movie Card */
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

        /* Movie poster image, set as background */
        .movie-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
           
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        /* Overlay container for the text */
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

        /* Movie Title */
        .movie-card-content h3 {
            margin: 5px 0;
            font-size: 1.2em;
            color: #fff;
        }

        /* Release Year */
        .movie-card-content p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        /* View More button */
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

        /* Pagination Container */
        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        /* Pagination Links */
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
            /* Darker blue on hover */
        }

        /* Active Page Link */
        .pagination a.active {
            background: #0056b3;
            pointer-events: none;
            /* Disable click on active page */
            color: white;
        }
    </style>
</head>

<body>
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
            echo "<p>No movies found.</p>";
        }
        ?>
    </div>

  

</body>

</html>

<?php
$conn->close(); // Close the database connection
?>