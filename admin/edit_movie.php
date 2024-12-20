<?php
  session_start();
  require('../dbconnect.php');

  $movieid = $_GET['id'];
              
  $sql = "SELECT * FROM movie WHERE movie_id = '$movieid' ";
  $query = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($query);

  $sql2 = "SELECT * FROM mtype 
          JOIN movie_type ON mtype.movie_type_id = mtype.movie_type_id
          WHERE movie_id = '$movieid' ";
  $result2 = mysqli_query($conn, $sql);
  $row2 = mysqli_fetch_assoc($result2);

  $tsql = "SELECT * FROM movie_type";
  $tresult = mysqli_query($conn, $tsql);
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

    <title>Edit Movie</title>
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
                          <a class="nav-link active" href="movie_page.php">
                            <span style="font-size: 22px;" class="ml-2">Movie</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="edit_showtime.php">
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
                <p><a href="movie_page.php" class="btn btn-primary">Back</a></p>

                <form class="form-group mt-4" action="edit_movie_db.php" method="post" enctype="multipart/form-data">
                  <label>Movie Id</label>
                  <p class="form-control form-control-lg"><?=$row['movie_id']?></p>
                  <label>Movie Name</label>
                  <input type="text" name="movie_name" class="form-control form-control-lg" value="<?=$row['movie_name']?>" placeholder="<?=$row['movie_name']?>"/>
                  <label class="mt-2">Lenght</label>
                  <input type="text" name="lenght" class="form-control form-control-lg" value="<?=$row['lenght']?>" placeholder="<?=$row['lenght']?>"/>

                  <?php
                    $tsql = "SELECT * FROM movie_type";
                    $tresult = mysqli_query($conn, $tsql);

                    $type_sql = "SELECT * FROM mtype JOIN movie_type ON mtype.movie_type_id = movie_type.movie_type_id WHERE movie_id = '$movieid' " ;
                    $type_query = mysqli_query($conn, $type_sql);
                    
                    $movie_type = [];
                    foreach ($type_query as $typerows) {
                      $movie_type[] = $typerows['movie_type_id'];
                    }
                  ?>

                  <label>Movie Type</label>
                  <select name="mtype[]" id="mtype" class="form-control form-control-lg" multiple>
                    <?php if(mysqli_num_rows($tresult) > 0) : ?>
                      <?php foreach($tresult as $rows) : ?>
                        <option value="<?=$rows['movie_type_id']?>" <?= in_array($rows['movie_type_id'],$movie_type) ? 'selected' : '' ?> > 
                          <?=$rows['movie_type']?>
                        </option>
                      <?php endforeach; ?>
                    <?php endif ?>
                  </select>
                  

                  <label class="mt-2">Image</label>
                  <input type="file" name="image" class="form-control form-control-lg" accept="image/jpeg, image/png" />

                  <button type="submit" name="edit_save" value="<?=$movieid?>" class="btn btn-success mt-3">บันทึก</button>
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