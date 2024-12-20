<?php
    session_start();
    require('../dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Showtime</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

    <link rel="stylesheet" href="../css/admin_page.css">
    <link rel="stylesheet" href="../css/movie_page.css">
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
                  <li><a class="dropdown-item" href="admin_page.php?logout='1'">ออกจากระบบ</a></li>
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
                            <span style="font-size: 22px;" class="ml-2">Showtime</span>
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
                <a class="btn btn-primary" href="edit_showtime.php">Back</a>

                <form action="add_showtime_db.php" method="post" class="mt-3">
                    <h4 class="mt-5">Add Showtime</h4>
                    <input type="date" name="showtimeDate" class="form-control form-control-lg mt-2" />

                    <!-- เลือกหนัง -->
                    <?php
                      $movie_sql = "SELECT * FROM movie";
                      $movie_query = mysqli_query($conn, $movie_sql)
                    ?>

                    <select class="form-control form-control-lg mt-2" name="movie" >
                      <?php while ($mrow=mysqli_fetch_array($movie_query)) { ?>
                        <option value="<?=$mrow['movie_id']?>"><?=$mrow['movie_name']?></option>
                      <?php } ?>
                    </select>
                    
                    <!-- เลือกโรง -->
                    <?php
                      $hall_sql = "SELECT * FROM theatre_hall";
                      $hall_query = mysqli_query($conn, $hall_sql);
                     ?>
                    <select class="form-control form-control-lg mt-2" name="hall" >
                    <option value="">เลือกโรง</option>
                      <?php while ($hrow=mysqli_fetch_array($hall_query)) { ?>
                        <option value="<?=$hrow['theatre_id']?>"><?=$hrow['hall_name'] ?></option>
                      <?php } ?>
                    </select>
                    
                    <!-- เลือกเวลา -->
                    <?php 
                      $time_sql = "SELECT * FROM time";
                      $time_query = mysqli_query($conn, $time_sql);
                    ?>

                    <select class="form-control form-control-lg mt-2" name="time" >
                      <?php while ($time_row = mysqli_fetch_array($time_query)) { ?>
                        <option value="<?=$time_row['time_id']?>"><?=$time_row['start_time']?></option>
                      <?php } ?>
                    </select>

                    <!-- เลือก audio -->
                    <?php
                      $audio_sql = "SELECT * FROM audio";
                      $audio_query = mysqli_query($conn, $audio_sql); 
                    ?>
                    <select class="form-control form-control-lg mt-2" name="audio">
                    <option value="">Audio</option>
                    <?php while ($audrow = mysqli_fetch_array($audio_query)) { ?>
                      <option value="<?=$audrow['audio_id']?>"><?=$audrow['audio']?></option>
                    <?php } ?>
                    </select>

                    <!-- เลือก sub -->
                    <?php
                      $subdio_sql = "SELECT * FROM subtitle";
                      $subdio_query = mysqli_query($conn, $subdio_sql); 
                    ?>
                    <select class="form-control form-control-lg mt-2" name="sub">
                      <option value="">Subtitle</option>
                    <?php while ($subrow = mysqli_fetch_array($subdio_query)) { ?>
                      <option value="<?=$subrow['sub_id']?>"><?=$subrow['subtitle']?></option>
                    <?php } ?>
                    </select>

                    <button type="submit" name="add_showtime" class="btn btn-success mt-3">บันทึก</button>
                    
                    <!-- เพิ่ม movietype -->
                    <h4 class="mt-5">Add Movie Type</h4>
                    <form action="add_showtime_db.php" method="post">
                      <input type="text" class="form-control form-control-lg mt-3"name="movietypeid" placeholder="Movie Type ID"/>
                      <input type="text" class="form-control form-control-lg mt-3"name="movietype" placeholder="Movie Type">
                      <button type="submit" name="add_type" class="btn btn-success mt-3">บันทึก</button>
                    </form>

                    <!-- เพิ่มเวลา -->
                    <h4 class="mt-5">Add Time</h4>
                    <form action="add_showtime_db.php" method="post">
                      <input type="text" class="form-control form-control-lg mt-3"name="timeid" placeholder="Time ID">
                      <input type="time" class="form-control form-control-lg mt-2" name="atime" placeholder="Time">
                      <button type="submit" name="add_time" class="btn btn-success mt-3">บันทึก</button>
                    </form>
                </form>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
</body>
</html>