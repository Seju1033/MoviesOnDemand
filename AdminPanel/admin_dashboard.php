<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch statistics
$total_movies_result = $conn->query("SELECT COUNT(*) AS total FROM moviesdata");
$total_movies = $total_movies_result->fetch_assoc()['total'];

// Fetch all movies
$movies_result = $conn->query("SELECT * FROM moviesdata");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin_dashboard.css">
    <style>
        html,
        body {
            background-color: black;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .dashboard-container {
            display: flex;
            flex-direction: row;
        }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background-color: red;
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow: auto;
            z-index: 10;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 1.5em;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: flex;
            align-items: center;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #b30000;
        }

        .sidebar ul li a .icon {
            margin-right: 10px;
        }
        .hamburger{
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            color: white;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .hamburger {
                display: block;
                position: absolute;
                top: 20px;
                right: 20px;
                color: white;
                padding: 10px;
                border-radius: 5px;
                background-color: red;
                font-size: 30px;
                cursor: pointer;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.7);
                z-index: 9;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar" id="sidebar">
            <h2>Admin Menu</h2>
            <ul>
                <li><a href="?page=add_movie"><i class="fas fa-plus icon"></i><span class="text">Add Movie</span></a>
                </li>
                <li><a href="?page=edit_movie"><i class="fas fa-edit icon"></i><span class="text">Edit Movie</span></a>
                </li>
                <li><a href="?page=admin_profile"><i class="fas fa-user icon"></i><span class="text">Admin
                            Profile</span></a></li>
                <li><a href="?page=settings"><i class="fas fa-cog icon"></i><span class="text">Settings</span></a></li>
                <li><a href="?page=view_comment"><i class="fas fa-comments icon"></i><span class="text">View
                            Comments</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt icon"></i><span class="text">Logout</span></a>
                </li>
            </ul>
        </div>

        <div class="main-content" id="main-content">
            <div class="hamburger" id="hamburger">
                &#9776;
            </div>

            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>You can manage movies here.</p>

            <div>
                <h2>Total Movies: <?php echo $total_movies; ?></h2>
            </div>

            <h2>All Movies</h2>
            <div class="movie-cards">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    switch ($page) {
                        case 'add_movie':
                            include('add_movie.php');
                            break;
                        case 'edit_movie':
                            include('edit_movie.php');
                            break;
                        case 'admin_profile':
                            include('admin_profile.php');
                            break;
                        case 'view_comment':
                            include('view_comment.php');
                            break;
                        case 'settings':
                            include('settings.php');
                            break;
                        default:
                            echo "<p>Select an option from the menu.</p>";
                    }
                } else {
                    echo "<h2>All Movies</h2>";
                    echo '<div class="movie-cards">';
                    if ($movies_result->num_rows > 0) {
                        while ($movie = $movies_result->fetch_assoc()) {
                            echo '<div class="movie-card">';
                            echo '<img src="' . $movie['poster'] . '" alt="' . htmlspecialchars($movie['title']) . '">';
                            echo '<h3>' . htmlspecialchars($movie['title']) . '</h3>';
                            echo '<p>Release Year: ' . $movie['releaseyear'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No movies found.</p>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div class="overlay" id="overlay"></div>
    </div>

    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>

</html>