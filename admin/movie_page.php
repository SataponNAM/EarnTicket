<?php
  session_start();
  require('../dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

    <link rel="stylesheet" href="../css/admin_page.css">
    <link rel="stylesheet" href="../css/movie_page.css">
</head>

<body>
    <!-- nav bar -->
    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand " style="font-size: 26px;" href="#">
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
              <div class="row">
                <p class="col"><a href="add_movie.php" class="btn btn-primary">Add Movie</a></p>
                <div class="col"></div>
                <!--<div class="input-group col search">
                  <input type="search" name="search-bar" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                  <button type="button" class="btn btn-outline-primary">search</button>
                </div>-->
              </div>

              <div class="container mt-5">
              <div class="row">
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

                  ?>
                  <div class="col-md-4 mt-5" style="width: 18rem;">
                      <img src="../movie image/<?=$row['image']?>" width="100%" height="auto"class="card-img-top">
                          <div class="card" style="height: 20rem;">
                              <div class="card-body">
                                  <h5><?=$row['movie_name']?></h5>
                                  <p class="card-title"><?=$row['lenght']?> นาที</p>
                                  <?php 
                                  // แสดงประเภทหนัง
                                  while ($row2 = mysqli_fetch_array($query2)) {
                                  ?>
                                      <p class="card-title"><?=$row2['movie_type']?></p>
                                  <?php
                                  }
                                  ?>
                              </div>

                              <form class="card-footer" action="edit_movie_db.php" method="POST">
                                <a href="edit_movie.php?id=<?=$row['movie_id']?>" name="editmovie" class="btn btn-primary">Edit</a>
                                <button type="submit" name="delmovie" value="<?=$row['movie_id']?>" class="btn btn-danger">Delete</button>
                              </form>
                          </div>
                  </div>
                    <?php
                }
                mysqli_close($conn);
                ?>
                </div>       
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

    <script>
    new MultiSelectTag('mtype')  // id
    </script>
</body>
</html>