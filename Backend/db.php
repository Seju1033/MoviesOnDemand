<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedb";  // Corrected database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination settings
$limit = 10;  // Number of records to display per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Get current page number
$offset = ($page - 1) * $limit;  // Calculate offset

// Query to get the total number of records
$total_result = $conn->query("SELECT COUNT(*) AS count FROM moviesdata");
$total_row = $total_result->fetch_assoc();
$total_movies = $total_row['count'];  // Total number of movies
$total_pages = ceil($total_movies / $limit);  // Calculate total pages

// Query to fetch the movies for the current page
$sql = "SELECT * FROM moviesdata LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);


?>

