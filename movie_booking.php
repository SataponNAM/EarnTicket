<?php 
    session_start();
    require('dbconnect.php');

    if (isset($_POST['timelink'])) {
        $showtimeID = $_POST['timelink'];
        $_SESSION['showtimeID'] = $showtimeID;
    }
    

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="css\mbooking.css">

    <title>Ticket Booking</title>
</head>

<body>
<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

    <?php 
        // ดึงข้อมูลหนัง
        $showtime_id = $_POST['timelink'];
        $movieid = $_SESSION['movie_id'];
        
        $sql = "SELECT * FROM movie WHERE movie_id = $movieid  ";
        $query = mysqli_query($conn,$sql);
        $row=mysqli_fetch_array($query);

        $sql2 = "SELECT * FROM showtime 
                JOIN audio ON audio.audio_id = showtime.audio_id
                JOIN subtitle ON subtitle.sub_id = showtime.sub_id
                JOIN time ON time.time_id = showtime.time_id
                WHERE movie_id = $movieid";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($query2);
    ?>

    <div class="container">
        <div class="movie-info">
            <img src="movie image/<?=$row['image']?>" width="100%" height="auto">

            <div class="info">
                <h3><?=$row['movie_name']?></h3>
                <p><?=$row2['audio']?></p>
                <p><?=$row2['subtitle']?></p>
                <p><?=$row2['showtime_date']?></p>
                <p><?=$row2['start_time']?></p>
            </div>

        </div>

        <div class="wrapper">
            <div class="seat-container">
                <h3 >SCREEN</h3>

                <?php 
                $seat_sql = "SELECT * FROM seat
                    JOIN seat_type WHERE seat.seat_type_id = seat_type.seat_type_id
                    ORDER BY seat_id DESC";
                $seat_query = mysqli_query($conn, $seat_sql);

                // Get all booked seats for the selected showtime
                $seat_check = "SELECT seat_id FROM ticket
                    WHERE showtime_id = '$showtime_id'";
                $seat_check_query = mysqli_query($conn, $seat_check);
                $booked_seats = array();
                while ($row2 = mysqli_fetch_assoc($seat_check_query)) {
                    $booked_seats[] = $row2['seat_id'];
                }
                ?>

                <!-- show ที่นั่ง -->
                <div class="seat-plan">
                    <div class="tbody">
                            <?php while($seat_row=mysqli_fetch_assoc($seat_query)) { ?>
                                <?php if (in_array($seat_row['seat_id'], $booked_seats)): ?>
                                    <!-- seat is booked -->
                                    <div class="seat-sold"><a id="<?= $seat_row['seat_id']?>"><?= $seat_row['seat_id']?></a></div>
                                <?php else: ?>
                                    <!-- seat is available -->
                                    <?php if ($seat_row['seat_type_id'] == "NM") :?>
                                        <a class="seat-nm seat" onclick="toggle(this.id)" id="<?= $seat_row['seat_id']?>" data-price="<?=$seat_row['seat_price']?>"><?= $seat_row['seat_id']?></a>
                                    <?php elseif ($seat_row['seat_type_id'] == "PM") : ?>
                                        <a class="seat-pm seat" onclick="toggle(this.id)" id="<?= $seat_row['seat_id']?>" data-price="<?=$seat_row['seat_price']?>"><?= $seat_row['seat_id']?></a>
                                    <?php endif ?>
                                <?php endif ?>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <!-- ดูตั๋วที่กดด้านข้าง -->
            <div class="t-side">
                <img src="movie image/<?=$row['image']?>" width="100%" height="auto">
                
                <p class="text">
                    <div>
                    ที่นั่ง <br>
                    <span id="selectSeats"></span><br>
                    </div>
                </p>
                <p class="text">
                    <div>
                    ราคา<br>
                    <span id="total" ></span><br>
                    </div>
                </p>
                
                <?php if(isset($_SESSION['name'])) : ?>
                <form action="booking.php" method="post">
                    <button type="submit" class="book_submit btn btn-success" id="book-submit" name="seats" value="">จองตั๋ว</button>
                </form>
                <?php else : ?>
                <form action="login.php" method="post">
                    <button type="submit" class="book_submit btn btn-success" name="login" value="ศนเรื">เข้าสู่ระบบ</button>
                </form>
                <?php endif ?>
            </div>
        </div>
    </div>

    <script src="javascript\movie_booking.js"></script>
    <script src="jquery-3.6.3.min.js"></script>
</body>
</html>