<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "moviedb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $poster = $conn->real_escape_string($_POST['poster']);
    $teraboxlink480 = $conn->real_escape_string($_POST['teraboxlink480']);
    $teraboxlink720 = $conn->real_escape_string($_POST['teraboxlink720']);
    $teraboxlink1080 = $conn->real_escape_string($_POST['teraboxlink1080']);
    $releaseyear = $conn->real_escape_string($_POST['releaseyear']);
    $language = $conn->real_escape_string($_POST['language']);
    $size = $conn->real_escape_string($_POST['size']);
    $formate = $conn->real_escape_string($_POST['formate']);
    $runtime = $conn->real_escape_string($_POST['runtime']);
    $quality = $conn->real_escape_string($_POST['quality']);
    $oriagnallanguage = $conn->real_escape_string($_POST['oriagnallanguage']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $writer = $conn->real_escape_string($_POST['writer']);
    $cast = $conn->real_escape_string($_POST['cast']);
    $director = $conn->real_escape_string($_POST['director']);
    $plot = $conn->real_escape_string($_POST['plot']);
    $youtubelink = $conn->real_escape_string($_POST['youtubelink']);
    $screenshot1 = $conn->real_escape_string($_POST['screenshot1']);
    $screenshot2 = $conn->real_escape_string($_POST['screenshot2']);
    $screenshot3 = $conn->real_escape_string($_POST['screenshot3']);
    $screenshot4 = $conn->real_escape_string($_POST['screenshot4']);
    $screenshot5 = $conn->real_escape_string($_POST['screenshot5']);
    $screenshot6 = $conn->real_escape_string($_POST['screenshot6']);
    $actores = $conn->real_escape_string($_POST['actores']);

    $stmt = $conn->prepare("INSERT INTO moviesdata (title, description, poster, teraboxlink480, teraboxlink720, teraboxlink1080, releaseyear, language, size, formate, runtime, quality, oriagnallanguage, genre, writer, cast, director, plot, youtubelink, screenshot1, screenshot2, screenshot3, screenshot4, screenshot5, screenshot6, actores) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssssssssssssssssssssssss",
        $title,
        $description,
        $poster,
        $teraboxlink480,
        $teraboxlink720,
        $teraboxlink1080,
        $releaseyear,
        $language,
        $size,
        $formate,
        $runtime,
        $quality,
        $oriagnallanguage,
        $genre,
        $writer,
        $cast,
        $director,
        $plot,
        $youtubelink,
        $screenshot1,
        $screenshot2,
        $screenshot3,
        $screenshot4,
        $screenshot5,
        $screenshot6,
        $actores
    );


    if ($stmt->execute()) {
        echo "<script>alert('New movie added successfully');</script>";
    } else {
        echo "<script>alert('Error adding movie: " . $stmt->error . "');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link rel="stylesheet" href="admin_add_movie.css">
    <style>
        .add-movie-container {
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: red;
            /* Changed to red for better visibility */
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

        input,
        textarea {
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
    <div class="add-movie-container">
        <h2>Add New Movie</h2>
        <form action="" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="poster">Poster URL:</label>
            <input type="text" id="poster" name="poster" required>

            <label for="teraboxlink480">Download Link 480p:</label>
            <input type="text" id="teraboxlink480" name="teraboxlink480" required>

            <label for="teraboxlink720">Download Link 720p:</label>
            <input type="text" id="teraboxlink720" name="teraboxlink720" required>

            <label for="teraboxlink1080">Download Link 1080p:</label>
            <input type="text" id="teraboxlink1080" name="teraboxlink1080" required>

            <label for="releaseyear">Release Year:</label>
            <input type="text" id="releaseyear" name="releaseyear" required>

            <label for="language">Language:</label>
            <input type="text" id="language" name="language" required>

            <label for="size">File Size:</label>
            <input type="text" id="size" name="size" required>

            <label for="formate">Format:</label>
            <input type="text" id="formate" name="formate" required>

            <label for="runtime">Runtime:</label>
            <input type="text" id="runtime" name="runtime" required>

            <label for="quality">Quality:</label>
            <input type="text" id="quality" name="quality" required>

            <label for="oriagnallanguage">Original Language:</label>
            <input type="text" id="oriagnallanguage" name="oriagnallanguage" required>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required>

            <label for="writer">Writer:</label>
            <input type="text" id="writer" name="writer" required>

            <label for="cast">Cast:</label>
            <input type="text" id="cast" name="cast" required>

            <label for="director">Director:</label>
            <input type="text" id="director" name="director" required>

            <label for="plot">Plot:</label>
            <input type="text" id="plot" name="plot" required>

            <label for="youtubelink">YouTube Trailer Link:</label>
            <input type="text" id="youtubelink" name="youtubelink" required>

            <label for="screenshot1">Screenshot 1 URL:</label>
            <input type="text" id="screenshot1" name="screenshot1" required>

            <label for="screenshot2">Screenshot 2 URL:</label>
            <input type="text" id="screenshot2" name="screenshot2" required>

            <label for="screenshot3">Screenshot 3 URL:</label>
            <input type="text" id="screenshot3" name="screenshot3" required>

            <label for="screenshot4">Screenshot 4 URL:</label>
            <input type="text" id="screenshot4" name="screenshot4" required>

            <label for="screenshot5">Screenshot 5 URL:</label>
            <input type="text" id="screenshot5" name="screenshot5" required>

            <label for="screenshot6">Screenshot 6 URL:</label>
            <input type="text" id="screenshot6" name="screenshot6" required>

            <label for="actores">Actors:</label>
            <input type="text" id="actores" name="actores" required>


            <button type="submit">Add Movie</button>
        </form>
    </div>
</body>

</html>