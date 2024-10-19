  <?php
  include './Backend/db.php';
  $query = "SELECT * FROM moviesdata ORDER BY releaseyear DESC LIMIT 10";
  $result = mysqli_query($conn, $query);
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Movie Download Website</title>
  </head>
  <style>
    html , .body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        background-color: black;
        
    }
  </style>
  <body>
  <?php include '../movie-download/Frontend/Header.php'; ?>

  <div class="content">

  </div>
    
    <div class="indexmoviecards">
      <?php require './Frontend/movieCards.php' ?>
    </div>

    <?php include './Frontend/Footer.php' ?>
  </body>
  </html>



