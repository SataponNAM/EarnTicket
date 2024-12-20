<?php 
session_start();
require('dbconnect.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<script src="javascript/background.js"></script>
<?php include 'menubar.php'; ?>

<!-- แสดงหนัง -->
<div class="container">
<?php 
$sql1 = "SELECT * FROM movie ORDER BY movie_id ";
$query1 = mysqli_query($conn,$sql1);

while ($row=mysqli_fetch_array($query1)) {
    ?>
    <?php 
    $movie_id = $row['movie_id'];
    $sql2 = "SELECT mtype.movie_id,mtype.movie_type_id, movie_type.movie_type_id,movie_type.movie_type
    FROM mtype, movie_type WHERE movie_id = '$movie_id' and mtype.movie_type_id =  movie_type.movie_type_id ";
    $query2 = mysqli_query($conn,$sql2);
    //$row2 = mysqli_fetch_array($query2);
    ?>

    <div class="movie-list">
        <a href="movie_showtime.php?id=<?=$row['movie_id']?>">
            <img src="movie image/<?=$row['image']?>" width="100%" height="auto">
            <div class="overlay">
                <div class="movie-info">
                    <h3><?=$row['movie_name']?></h3>
                    <p><?=$row['lenght']?> นาที</p>
                    <?php 
                    // แสดงประเภทหนัง
                    while ($row2 = mysqli_fetch_array($query2)) {
                    ?>
                        <p><?=$row2['movie_type']?></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </a>
        <div class="movie-name">
            <h3><?=$row['movie_name']?></h3>
        </div>
    </div>
<?php
}
mysqli_close($conn);
?>
</div>

</body>
</html>