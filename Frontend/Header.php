



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoOnDemand</title>
    <script>
        // Toggling the menu (hamburger)
        function toggleMenu() {
            var menu = document.getElementById('nav-links');
            menu.classList.toggle('active');
        }
    </script>
    <style>
        /* Ensure no margin/padding around body and html */
        html, body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header styles */
        .header {
            background-color: black;
            color: white;
            padding: 10px 0;
            width: 100%;
            position: relative;
            box-sizing: border-box;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            flex-wrap: wrap;
            width: 100%;
            box-sizing: border-box;
        }

        .logo h1 {
            color: red;
            margin: 0;
        }

        .nav-links {
            list-style-type: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links li a {
            justify-content: start;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
            padding-left: 25px;
        }

        .nav-links li a:hover {
            color: red;
        }

        .nav-links.active {
            display: flex;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            color: white;
            font-size: 30px;
            transition: ease-in-out 0.3s;
        }

        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                display: none;
                background-color: black;
                position: absolute;
                top: 35px;
                right: 0px;
                width: 100%;
                height: 100vh;
                text-align: start;
                padding: 20px 0;
                z-index: 9;
            }

            .nav-links li a::before {
                content: ">";
                position: absolute;
                right: 0;
                justify-content: center;
                background-color: red;
                border-radius: 5px;
                font-size: 30px;
                color: white;
                margin-right: 10px;
                line-height: 1;
            }

            .nav-links.active {
                display: flex;
            }

            .navbar {
                flex-direction: row;
                position: relative;
            }

            .hamburger {
                display: block;
                position: absolute;
                right: 20px;
                top: 0;
                z-index: 10;
            }

            .logo {
                order: 1;
                flex: 1;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <h1>VideoOnDemand</h1>
            </div>
            <div class="hamburger" onclick="toggleMenu()">
                &#9776;
            </div>
            <ul class="nav-links" id="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="http://localhost/movie-download/Frontend/movieCards.php">Movies</a></li>
                <li><a href="http://localhost/movie-download/Frontend/ContactUs.php">Contact</a></li>
                <li><a href="http://localhost/movie-download/Frontend/blog.php">Blog</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
