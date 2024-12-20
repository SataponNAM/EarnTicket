<?php 
    require('dbconnect.php');

?>



<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="css\movie_showtime.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="showtime.js"></script>


    <script src="..\javascript\movie_showtime.js"></script>

    <title>Movie</title>
</head>

<body>
<script src="javascript/background.js"></script>
<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

    <?php 
    // ดึงข้อมูลหนัง
    $movieid = $_GET['id'];
    $_SESSION['movie_id'] = $movieid;
    $sql = "SELECT * FROM movie WHERE movie.movie_id = $movieid  ";
    $query = mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($query);
    
    
    //ดึงข้อมูลประเภทหนัง
    $sql2 = "SELECT mtype.movie_id,mtype.movie_type_id, movie_type.movie_type_id,movie_type.movie_type
    FROM mtype, movie_type WHERE movie_id = $movieid  and mtype.movie_type_id =  movie_type.movie_type_id ";
    $query2 = mysqli_query($conn,$sql2);
    ?>

    <div class="container">
        <div class="movie-info">
            <img src="movie image/<?=$row['image']?>" width="100%" height="auto">
            <div class="info">
                <h3><?=$row['movie_name']?></h3>

                <!-- แสดงประเภทหนัง -->
                <?php
                while ($row2 = mysqli_fetch_array($query2)) {
                ?>
                    <p><?=$row2['movie_type']?></p>
                <?php
                }
                ?>

                <p><?=$row['lenght']?> นาที</p>
            </div>
        </div>

        <div class="showtime-date-slide">
            <div class="date-container">
                <div class="slick-slider">

                    <?php 
                    $showtime_sql = "SELECT * FROM showtime WHERE movie_id = $movieid ";
                    $query_showtime = mysqli_query($conn, $showtime_sql);

                    $list=array();
                    $list2=array();
                    $day=array();
                    
                    $month = date("m");
                    $year = date("Y");
                    $days = date("d");
                    $dcount = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                    for ($i=1; $i < 15; $i++) { 
                        for($d=$days; $d<=$dcount; $d++)
                        {
                        $time=mktime(12, 0, 0, $month, $d, $year);          
                        if (date('m', $time)==$month)       
                            $list[]=date('d m ', $time);
                            $list2[]=date('D',$time);
                            $day[]=date('Y-m-d', $time);

                        }
                    }
                    ?>

                    <div class="slick-track">
                        <?php $i = 0;
                        while ($i < 15) { 
                        ?>
                            <div class="slick-slide">
                                <form method="post" action="movie_showtime.php?id=<?=$movieid?>">
                                    <button type="submit" class="btn btn-secondary" name="datelink" value="<?= $day[$i] ?>">
                                        <span style="display: block;"><?= $list2[$i]?></span>
                                        <span style="display: block;"><?= $list[$i]?></span>
                                    </button>
                                </form>
                            </div>
                        <?php $i++; } ?>
                    </div>

                </div>          
            </div>
        </div>
        
        <div id="showtime">
            <?php
                if (isset($_POST['datelink'])) {
                    $days = $_POST['datelink'];
                }
                //เชื่อมโรง เวลาฉาย

                    $tsql = "SELECT * FROM showtime
                            INNER JOIN time ON time.time_id = showtime.time_id
                            INNER JOIN theatre_hall ON theatre_hall.theatre_id = showtime.theatre_id
                            WHERE showtime.movie_id='$movieid' AND showtime.showtime_date = '$days'
                            ORDER BY start_time";
                    $tquery = mysqli_query($conn, $tsql);
                
                    // เชื่อม sub audio
                    $sql3 = "SELECT * FROM showtime 
                            JOIN audio ON audio.audio_id = showtime.audio_id
                            JOIN subtitle ON subtitle.sub_id = showtime.sub_id
                            JOIN time ON time.time_id = showtime.time_id
                            WHERE movie_id = $movieid";
                    $query3 = mysqli_query($conn, $sql3);
                    $row3 = mysqli_fetch_array($query3);
                    ?>
                    <!-- ปุ่มเวลาฉาย -->
                    <?php if(mysqli_num_rows($tquery) > 0) : ?>
                        <div class="showtime-date">
                            <?php while ($trow = mysqli_fetch_assoc($tquery)) { ?>
                                <p><?=$trow['hall_name']?></p>
                                <p><?= "Audio: ".$row3['audio_id'].' '."Subtitle: ".$row3['sub_id'] ?></p>

                                <form action="movie_booking.php" method="post">
                                    <button class="btn btn-secondary" name="timelink" value="<?=$trow['showtime_id']?>" ><?= $trow['start_time'] ?></button>
                                </form>
                        <?php } ?>
                        </div>
                        <?php else : ?>
                            <p>ไม่พบรอบฉาย</p>
                        <?php endif ?>
               
        </div>

    </div>
    
    <script>
        $('.fade').ready(function(){
            $('.slick-track').slick({
                infinite: false,
                slidesToShow: 7,
                slidesToScroll: 3,
            });
        });
    </script>

</body>
</html>