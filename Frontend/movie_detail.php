<?php include '../Frontend/Header.php' ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$movie_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM moviesdata WHERE id = $movie_id";
$result = $conn->query($sql);
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "<p>Movie not found.</p>";
    exit();
}

//for toutube video
$youtube_url = $movie['youtubelink'];
$youtube_id = '';

// Check if the URL is valid and extract the video ID
if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtube_url, $matches)) {
    $youtube_id = $matches[1]; // Extracted video ID
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : null;
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
    $message = isset($_POST['comment']) ? $conn->real_escape_string($_POST['comment']) : null;

    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO comments (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?> - Movie Details</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #f5f5f5;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        /* Movie Detail Styles */
        .movie-detail {
            background-color: #1f1f1f;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);
            padding: 20px;
            overflow: hidden;
        }

        .movie-detail h1 {
            margin-bottom: 20px;
            color: #ff6b6b;
            text-align: center;
            font-size: 2.5rem;
        }

        .movie-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .movie-poster {
            flex: 1 1 300px;
            max-width: 300px;
            margin: 0 20px;
        }

        .movie-poster img {
            border-radius: 10px;
            transition: transform 0.3s;
            width: 100%;
        }

        .movie-poster img:hover {
            transform: scale(1.05);
        }

        .movie-details {
            flex: 1 1 calc(60% - 40px);
            padding-left: 20px;
        }

        .movie-details p {
            margin: 10px 0;
            font-size: 1rem;
        }

        .plot {
            margin: 20px 0;
            font-size: 1rem;
        }

        .youtube-player {
            margin: 20px 0;
            height: 450px;
            border-radius: 10px;
            overflow: hidden;
        }

        .youtube-player iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Screenshot Section */
        .screenshot-section {
            margin: 20px 0;
        }

        .screenshot-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            justify-content: space-between;
        }

        .screenshot {
            width: 100%;
            
            height: 100%;
          
            overflow: hidden;
            /* Hide overflow */
        }

        .screenshot img {
            width: 100%;
            
           
            
            border-radius: 5px;
            transition: transform 0.3s;
        }

        /* Download Section */
        .download-section {
            display: flex;
            
            flex-direction: column;
            
            align-items: center;
            
            margin: 20px 0;
            text-align: center;
        
        }

        .download-button {
            width: 100%;
            
            max-width: 300px;
          
            background-color: #ff6b6b;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .download-button:hover {
            background-color: #ff4444;
            transform: translateY(-2px);
        }

        /* Comment Section */
        .comment-section {
            margin-top: 40px;
            background-color: #2f2f2f;
            padding: 20px;
            border-radius: 10px;
        }

        .comment-section h3 {
            color: #ff6b6b;
            margin-bottom: 20px;
        }

        .comment-section input,
        .comment-section textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ff6b6b;
            border-radius: 5px;
            background-color: #1f1f1f;
            color: #f5f5f5;
        }

        .comment-section button {
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .comment-section button:hover {
            background-color: #ff4444;
            transform: translateY(-2px);
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .movie-info {
                flex-direction: column;
                align-items: center;
            }

            .movie-details {
                padding-left: 0;
            }

            .movie-poster {
                margin: 20px 0;
            }

            .screenshot {
                flex: 1 1 calc(50% - 10px);
                margin: 5px 0;
            }
        }

        @media (max-width: 768px) {
            .screenshot {
                flex: 1 1 100%;
            }

            .download-button {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .movie-detail h1 {
                font-size: 2rem;
            }

            .movie-details p,
            .plot {
                font-size: 0.9rem;
            }
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="movie-detail">
            <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
            <div class="movie-info">
                <div class="movie-poster">
                    <img src="<?php echo htmlspecialchars($movie['poster']); ?>"
                        alt="<?php echo htmlspecialchars($movie['title']); ?>">
                </div>
                <div class="movie-details">
                    <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                    <p><strong>Writer:</strong> <?php echo htmlspecialchars($movie['writer']); ?></p>
                    <p><strong>Cast:</strong> <?php echo htmlspecialchars($movie['cast']); ?></p>
                    <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
                    <p><strong>Release Year:</strong> <?php echo htmlspecialchars($movie['releaseyear']); ?></p>
                    <p><strong>Language:</strong> <?php echo htmlspecialchars($movie['language']); ?></p>
                    <p><strong>Size:</strong> <?php echo htmlspecialchars($movie['size']); ?></p>
                    <p><strong>Format:</strong> <?php echo htmlspecialchars($movie['formate']); ?></p>
                    <p><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['runtime']); ?></p>
                    <p><strong>Quality:</strong> <?php echo htmlspecialchars($movie['quality']); ?></p>
                </div>
            </div>

            <div class="plot">
                <p><strong>Plot:</strong> <?php echo htmlspecialchars($movie['plot']); ?></p>
            </div>

            <div class="youtube-player">
                <?php if (!empty($youtube_id)): ?>
                    <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($youtube_id); ?>" frameborder="0"
                        allowfullscreen></iframe>
                <?php else: ?>
                    <p>Video not available.</p>
                <?php endif; ?>
            </div>


            <div class="screenshot-section">
                <h3>Screenshots</h3>
                <div class="screenshot-row">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <?php if (!empty($movie["screenshot$i"])): ?>
                            <div class="screenshot">
                                <img src="<?php echo htmlspecialchars($movie["screenshot$i"]); ?>"
                                    alt="Screenshot <?php echo $i; ?>">
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="download-section">
                <h3>Download Options</h3>
                <button class="download-button"
                    onclick="window.location.href='<?php echo htmlspecialchars($movie['teraboxlink480']); ?>'">Download
                    720p</button>
                <button class="download-button"
                    onclick="window.location.href='<?php echo htmlspecialchars($movie['teraboxlink720']); ?>'">Download
                    1080p</button>
                <button class="download-button"
                    onclick="window.location.href='<?php echo htmlspecialchars($movie['teraboxlink1080']); ?>'">Download
                    4K</button>
            </div>


            <div class="comment-section">
                <h3>Leave a Comment</h3>
                <form method="post">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="comment" rows="4" placeholder="Your Comment" required></textarea>
                    <button type="submit">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>

</html>

<?php include '../Frontend/Footer.php' ?>