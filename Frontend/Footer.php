<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* Footer Styles */
        footer {
            background-color: #222;
            color: #fff;
            padding: 40px 20px;
            text-align: center;
            margin-top: 40px;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            margin: 10px;
        }

        .footer-section h4 {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #f4f4f4;
        }

        .footer-section p {
            font-size: 0.9em;
            line-height: 1.6;
            color: #ccc;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9em;
        }

        .footer-section ul li a:hover {
            color: red;
        }

        .footer-section.social a {
            display: inline-block;
            margin: 10px 10px;
            transition: transform 0.3s ease;
        }

        .footer-section.social a img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
            /* White icons */
        }

        .footer-section.social a:hover {
            transform: scale(1.2);
            /* Scale effect on hover */
        }

        .footer-bottom {
            background-color: #111;
            padding: 10px 0;
            margin-top: 30px;
            font-size: 0.9em;
            color: #888;
        }

        .footer-bottom span {
            color: red;
        }
    </style>
</head>

<body>

    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h4>About Us</h4>
                <p>We provide a wide selection of movies, from classics to the latest releases, available for download.
                    Enjoy high-quality entertainment at your convenience.</p>
            </div>
            <div class="footer-section links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Movies</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section social">
                <h4>Follow Us</h4>
                <a href="#"><img src="facebook-icon.png" alt="Facebook"></a>
                <a href="#"><img src="twitter-icon.png" alt="Twitter"></a>
                <a href="#"><img src="instagram-icon.png" alt="Instagram"></a>
                <a href="#"><img src="youtube-icon.png" alt="YouTube"></a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 MoviesOnDemand | All Rights Reserved.
        </div>
    </footer>
</body>

</html>