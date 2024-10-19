<?php
// Database connection
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "moviedb"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions for adding, editing, and deleting movies
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add movie
        $title = $_POST['title'];
        $description = $_POST['description'];
        $poster = $_POST['poster'];
        $teraboxlink480 = $_POST['teraboxlink480'];
        $teraboxlink720 = $_POST['teraboxlink720'];
        $teraboxlink1080 = $_POST['teraboxlink1080'];
        $releaseyear = $_POST['releaseyear'];
        $language = $_POST['language'];
        $size = $_POST['size'];
        $formate = $_POST['formate'];
        $runtime = $_POST['runtime'];
        $quality = $_POST['quality'];
        $oriagnallanguage = $_POST['oriagnallanguage'];
        $genre = $_POST['genre'];
        $writer = $_POST['writer'];
        $cast = $_POST['cast'];
        $director = $_POST['director'];
        $plot = $_POST['plot'];
        $youtubelink = $_POST['youtubelink'];
        $screenshot1 = $_POST['screenshot1'];
        $screenshot2 = $_POST['screenshot2'];
        $screenshot3 = $_POST['screenshot3'];
        $screenshot4 = $_POST['screenshot4'];
        $screenshot5 = $_POST['screenshot5'];
        $screenshot6 = $_POST['screenshot6'];

        $sql = "INSERT INTO moviesdata (title, description, poster, teraboxlink480, teraboxlink720, teraboxlink1080, releaseyear, language, size, formate, runtime, quality, oriagnallanguage, genre, writer, cast, director, plot, youtubelink, screenshot1, screenshot2, screenshot3, screenshot4, screenshot5, screenshot6) VALUES ('$title', '$description', '$poster', '$teraboxlink480', '$teraboxlink720', '$teraboxlink1080', '$releaseyear', '$language', '$size', '$formate', '$runtime', '$quality', '$oriagnallanguage', '$genre', '$writer', '$cast', '$director', '$plot', '$youtubelink', '$screenshot1', '$screenshot2', '$screenshot3', '$screenshot4', '$screenshot5', '$screenshot6')";

        if ($conn->query($sql) === TRUE) {
            echo "New movie added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['edit'])) {
        // Edit movie
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $poster = $_POST['poster'];
        $teraboxlink480 = $_POST['teraboxlink480'];
        $teraboxlink720 = $_POST['teraboxlink720'];
        $teraboxlink1080 = $_POST['teraboxlink1080'];
        $releaseyear = $_POST['releaseyear'];
        $language = $_POST['language'];
        $size = $_POST['size'];
        $formate = $_POST['formate'];
        $runtime = $_POST['runtime'];
        $quality = $_POST['quality'];
        $oriagnallanguage = $_POST['oriagnallanguage'];
        $genre = $_POST['genre'];
        $writer = $_POST['writer'];
        $cast = $_POST['cast'];
        $director = $_POST['director'];
        $plot = $_POST['plot'];
        $youtubelink = $_POST['youtubelink'];
        $screenshot1 = $_POST['screenshot1'];
        $screenshot2 = $_POST['screenshot2'];
        $screenshot3 = $_POST['screenshot3'];
        $screenshot4 = $_POST['screenshot4'];
        $screenshot5 = $_POST['screenshot5'];
        $screenshot6 = $_POST['screenshot6'];

        $sql = "UPDATE moviesdata SET title='$title', description='$description', poster='$poster', teraboxlink480='$teraboxlink480', teraboxlink720='$teraboxlink720', teraboxlink1080='$teraboxlink1080', releaseyear='$releaseyear', language='$language', size='$size', formate='$formate', runtime='$runtime', quality='$quality', oriagnallanguage='$oriagnallanguage', genre='$genre', writer='$writer', cast='$cast', director='$director', plot='$plot', youtubelink='$youtubelink', screenshot1='$screenshot1', screenshot2='$screenshot2', screenshot3='$screenshot3', screenshot4='$screenshot4', screenshot5='$screenshot5', screenshot6='$screenshot6' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Movie updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        // Delete movie
        $id = $_POST['id'];
        $sql = "DELETE FROM moviesdata WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Movie deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetching movie data
$movies_result = $conn->query("SELECT * FROM moviesdata");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .manage-movies-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .add-movie-form,
        .edit-movie-form {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            background-color: #ff0000;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #cc0000;
        }

        .movie-list {
            margin-top: 20px;
        }

        .movie {
            background-color: #444;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
        }

        .movie h4 {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="manage-movies-container">
        <h2>Manage Movies</h2>


        <div class="movie-list">
            <h3>Movie List</h3>
            <?php while ($movie = $movies_result->fetch_assoc()): ?>
                <div class="movie">
                    <h4><?php echo $movie['title']; ?></h4>
                    <p><?php echo $movie['description']; ?></p>
                    <button onclick="toggleEditForm(<?php echo $movie['id']; ?>)">Edit</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>

                    <div class="edit-movie-form" id="edit-form-<?php echo $movie['id']; ?>" style="display: none;">
                        <h4>Edit Movie</h4>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">

                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" value="<?php echo $movie['title']; ?>" required>

                            <label for="description">Description</label>
                            <textarea name="description" id="description"
                                required><?php echo $movie['description']; ?></textarea>

                            <label for="poster">Poster URL</label>
                            <input type="text" name="poster" id="poster" value="<?php echo $movie['poster']; ?>" required>

                            <label for="teraboxlink480">TeraBox Link (480p)</label>
                            <input type="text" name="teraboxlink480" id="teraboxlink480"
                                value="<?php echo $movie['teraboxlink480']; ?>" required>

                            <label for="teraboxlink720">TeraBox Link (720p)</label>
                            <input type="text" name="teraboxlink720" id="teraboxlink720"
                                value="<?php echo $movie['teraboxlink720']; ?>" required>

                            <label for="teraboxlink1080">TeraBox Link (1080p)</label>
                            <input type="text" name="teraboxlink1080" id="teraboxlink1080"
                                value="<?php echo $movie['teraboxlink1080']; ?>" required>

                            <label for="releaseyear">Release Year</label>
                            <input type="text" name="releaseyear" id="releaseyear"
                                value="<?php echo $movie['releaseyear']; ?>" required>

                            <label for="language">Language</label>
                            <input type="text" name="language" id="language" value="<?php echo $movie['language']; ?>"
                                required>

                            <label for="size">Size</label>
                            <input type="text" name="size" id="size" value="<?php echo $movie['size']; ?>" required>

                            <label for="formate">Format</label>
                            <input type="text" name="formate" id="formate" value="<?php echo $movie['formate']; ?>"
                                required>

                            <label for="runtime">Runtime</label>
                            <input type="text" name="runtime" id="runtime" value="<?php echo $movie['runtime']; ?>"
                                required>

                            <label for="quality">Quality</label>
                            <input type="text" name="quality" id="quality" value="<?php echo $movie['quality']; ?>"
                                required>

                            <label for="oriagnallanguage">Original Language</label>
                            <input type="text" name="oriagnallanguage" id="oriagnallanguage"
                                value="<?php echo $movie['oriagnallanguage']; ?>" required>

                            <label for="genre">Genre</label>
                            <input type="text" name="genre" id="genre" value="<?php echo $movie['genre']; ?>" required>

                            <label for="writer">Writer</label>
                            <input type="text" name="writer" id="writer" value="<?php echo $movie['writer']; ?>" required>

                            <label for="cast">Cast</label>
                            <input type="text" name="cast" id="cast" value="<?php echo $movie['cast']; ?>" required>

                            <label for="director">Director</label>
                            <input type="text" name="director" id="director" value="<?php echo $movie['director']; ?>"
                                required>

                            <label for="plot">Plot</label>
                            <textarea name="plot" id="plot" required><?php echo $movie['plot']; ?></textarea>

                            <label for="youtubelink">YouTube Trailer Link</label>
                            <input type="text" name="youtubelink" id="youtubelink"
                                value="<?php echo $movie['youtubelink']; ?>" required>

                            <label for="screenshot1">Screenshot 1 URL</label>
                            <input type="text" name="screenshot1" id="screenshot1"
                                value="<?php echo $movie['screenshot1']; ?>" placeholder="Screenshot 1 URL">

                            <label for="screenshot2">Screenshot 2 URL</label>
                            <input type="text" name="screenshot2" id="screenshot2"
                                value="<?php echo $movie['screenshot2']; ?>" placeholder="Screenshot 2 URL">

                            <label for="screenshot3">Screenshot 3 URL</label>
                            <input type="text" name="screenshot3" id="screenshot3"
                                value="<?php echo $movie['screenshot3']; ?>" placeholder="Screenshot 3 URL">

                            <label for="screenshot4">Screenshot 4 URL</label>
                            <input type="text" name="screenshot4" id="screenshot4"
                                value="<?php echo $movie['screenshot4']; ?>" placeholder="Screenshot 4 URL">

                            <label for="screenshot5">Screenshot 5 URL</label>
                            <input type="text" name="screenshot5" id="screenshot5"
                                value="<?php echo $movie['screenshot5']; ?>" placeholder="Screenshot 5 URL">

                            <label for="screenshot6">Screenshot 6 URL</label>
                            <input type="text" name="screenshot6" id="screenshot6"
                                value="<?php echo $movie['screenshot6']; ?>" placeholder="Screenshot 6 URL">

                            <button type="submit" name="edit">Update Movie</button>
                        </form>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function toggleEditForm(movieId) {
            const form = document.getElementById(`edit-form-${movieId}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>