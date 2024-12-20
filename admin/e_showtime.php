<?php
  session_start();
  require('../dbconnect.php');

  $showtimeid = $_GET['id'];
              
  $sql = "SELECT * FROM showtime WHERE showtime_id = '$showtimeid' ";
  $query = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($query);

  $sql2 = " SELECT * FROM showtime
            JOIN movie ON movie.movie_id = showtime.movie_id
            JOIN theatre_hall ON  theatre_hall.theatre_id = showtime.theatre_id
            JOIN time On time.time_id = showtime.time_id
            JOIN audio ON audio.audio_id = showtime.audio_id
            JOIN subtitle ON subtitle.sub_id = showtime.sub_id
            WHERE showtime_id = $showtimeid ";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($query2);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

    <link rel="stylesheet" href="../css/admin_page.css">
    <link rel="stylesheet" href="../css/movie_page.css">

    <title>Edit Showtime</title>
</head>
<body>
    <!-- nav bar -->
    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a style="font-size: 26px;" class="navbar-brand" href="#">
                Admin Page
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['name']; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a href="admin_page.php?logout='1'" class="dropdown-item">ออกจากระบบ</a></li>
                </ul>
              </div>
        </div>
    </nav>
    <!-- sidebar -->
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                          <a class="nav-link" aria-current="page" href="admin_page.php">
                            <span style="font-size: 22px;" class="ml-2">Home</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="movie_page.php">
                            <span style="font-size: 22px;" class="ml-2">Movie</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="edit_showtime.php">
                            <span  style="font-size: 22px;" class="ml-2">Showtime</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="edit_hall.php">
                            <span style="font-size: 22px;" class="ml-2">Hall</span>
                          </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <p><a href="edit_showtime.php" class="btn btn-primary">Back</a></p>

                <form class="form-group mt-4" action="add_showtime_db.php" method="post">
                    <p class="form-control form-control-lg"><?=$row2['movie_name']?></p>

                    <!-- เลือกวันที่ฉาย -->
                    <label>Date</label><br>
                    <input type="date" name="showtimeDate" value="<?=$row2['showtime_date']?>" class="form-control form-control-lg" />

                    <label>Hall</label>
                    <!-- เลือกโรง -->
                    <?php
                      $hall_sql = "SELECT * FROM theatre_hall";
                      $hall_query = mysqli_query($conn, $hall_sql);

                      $hall_sql2 = "SELECT * FROM showtime JOIN theatre_hall ON theatre_hall.theatre_id = showtime.theatre_id WHERE showtime_id = '$showtimeid'";
                      $hall_query2 = mysqli_query($conn, $hall_sql2);
                      $hall_row = mysqli_fetch_array($hall_query2);
                     ?>
                    <select class="form-control form-control-lg mt-2" name="hall" >
                    <?php foreach($hall_query as $rows) : ?>
                        <option value="<?=$rows['theatre_id']; ?>"<?php if($hall_row['theatre_id'] == $rows['theatre_id']) echo 'selected="selected"'; ?>><?php echo $rows['hall_name']; ?></option>
                      <?php endforeach; ?>
                    </select>

                    <label>Start Time</label>
                    <!-- เลือกเวลา -->
                    <?php 
                      $time_sql = "SELECT * FROM time";
                      $time_query = mysqli_query($conn, $time_sql);

                      $time_sql2 = "SELECT * FROM showtime JOIN time ON time.time_id = showtime.time_id WHERE showtime_id = '$showtimeid' ";
                      $time_query2 = mysqli_query($conn, $time_sql2);
                      $time_row = mysqli_fetch_array($time_query2);
                    ?>

                    <select class="form-control form-control-lg mt-2" name="time" >
                      <?php foreach($time_query as $rows) : ?>
                        <option value="<?=$rows['time_id']; ?>"<?php if($time_row['time_id'] == $rows['time_id']) echo 'selected="selected"'; ?>><?php echo $rows['start_time']; ?></option>
                      <?php endforeach; ?>
                    </select>

                    <label>Audio</label>
                    <!-- เลือก audio -->
                    <?php
                      $au_sql2 = "SELECT * FROM audio" ;
                      $au_query2 = mysqli_query($conn, $au_sql2);

                      $audio_sql = "SELECT * FROM showtime JOIN audio ON audio.audio_id = showtime.audio_id WHERE showtime_id = '$showtimeid'  ";
                      $au_sql = mysqli_query($conn, $audio_sql);
                      $au_row = mysqli_fetch_array($au_sql);

                    ?>
                    <select class="form-control form-control-lg mt-2" name="audio">
                      <?php foreach($au_query2 as $rows):?>
                        <option value="<?=$rows['audio_id']; ?>"<?php if($au_row['audio_id'] == $rows['audio_id']) echo 'selected="selected"'; ?>><?php echo $rows['audio']; ?></option>
                      <?php endforeach;?>
                    </select>
                  
                    
                    <label>Subtitle</label>
                    <!-- เลือก sub -->
                    <?php
                      $subdio_sql = "SELECT * FROM subtitle";
                      $subdio_query = mysqli_query($conn, $subdio_sql); 

                      $sub_sql = "SELECT * FROM showtime JOIN subtitle ON subtitle.sub_id = showtime.sub_id WHERE showtime_id = '$showtimeid'  ";
                      $sub_sql = mysqli_query($conn, $sub_sql);
                      $sub_row = mysqli_fetch_array($sub_sql);

                    ?>
                    <select class="form-control form-control-lg mt-2" name="sub">
                      <?php foreach($subdio_query as $rows):?>
                        <option value="<?=$rows['sub_id']; ?>"<?php if($sub_row['sub_id'] == $rows['sub_id']) echo 'selected="selected"'; ?>><?php echo $rows['subtitle']; ?></option>
                      <?php endforeach;?>
                    </select>
                    
                    <button type="submit" name="edit_save" value="<?=$showtimeid?>" class="btn btn-success mt-3">บันทึก</button>
                </form>
            </main>
              

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

    <script>
    new MultiSelectTag('mtype')  // id
    </script>
    
</body>
</html>