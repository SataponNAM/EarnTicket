<?php
    require('dbconnect.php');
    session_start();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css\user_ticket.css">

    <title>Ticket</title>
</head>
<body>
<script src="javascript/background.js"></script>
<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

<?php 
    $email = $_SESSION['email'];
    $sql1 = "SELECT * FROM ticket WHERE uemail = '$email' ";
    $query = mysqli_query($conn, $sql1);
?>

<!-- แสดงตั๋ว -->
<div class="container">
    <div class="row">
        <?php while ($row=mysqli_fetch_array($query)) { 
            $showtime_id = $row['showtime_id'];
            $sql2 = "SELECT * FROM ticket 
                    JOIN showtime ON showtime.showtime_id = ticket.showtime_id
                    JOIN movie ON movie.movie_id = showtime.movie_id
                    JOIN theatre_hall ON theatre_hall.theatre_id = showtime.theatre_id
                    JOIN time ON time.time_id = showtime.time_id
                    WHERE ticket.showtime_id = '$showtime_id' ";
            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_array($query2);
        ?>
            <div class="ticket">
                <h5><?= $row2['movie_name'] ?></h5>
                <h4><?= $row['seat_id'] ?> <?= $row2['hall_name'] ?></h4>
                <p><?= $row2['showtime_date'] ?></p>
                <p>รอบฉาย <?= $row2['start_time'] ?></p>
                <p>ID <?= $row['ticket_id'] ?></p>
            </div>
        <?php } ?>
    </div>
</div>


</body>
</html>