<?php 
    session_start();
    require('../dbconnect.php');

    $errors = array();

    //add showtime
    if (isset($_POST['add_showtime'])) {
        $date = mysqli_real_escape_string($conn, $_POST['showtimeDate']);
        $movie = mysqli_real_escape_string($conn, $_POST['movie']);
        $hall = mysqli_real_escape_string($conn, $_POST['hall']);
        $time1 = mysqli_real_escape_string($conn, $_POST['time']);
        $audio = mysqli_real_escape_string($conn, $_POST['audio']);
        $sub = mysqli_real_escape_string($conn, $_POST['sub']);

        // Check ShowtimeID
        $showtimeID = rand(10000,99999);
        $showtimeID_check = "SELECT showtime_id FROM showtime WHERE showtime_id = '$showtimeID' ";
        $showtimeID_check_query = mysqli_query($conn, $showtimeID_check);
        
        while ((mysqli_num_rows($showtimeID_check_query)) > 0) {
            $showtimeID = rand(10000,99999);
            $showtimeID_check = "SELECT showtime_id FROM showtime WHERE showtime_id = '$showtimeID' ";
            $showtimeID_check_query = mysqli_query($conn, $showtimeID_check);
        }
        
        if (count($errors) == 0) {
            $add_sql = "INSERT INTO showtime(showtime_id,showtime_date,theatre_id,movie_id,time_id,audio_id,sub_id) 
            VALUES ('$showtimeID','$date','$hall','$movie','$time1','$audio','$sub') ";
            $add_query = mysqli_query($conn, $add_sql);

            if ($add_query) {
                header("location: edit_showtime.php");
            } else {
                header("location: add_showtime.php");
            }
        }
    }

    //add time
    if (isset($_POST['add_time'])) {
        $timeid = mysqli_real_escape_string($conn, $_POST['timeid']);
        $time = mysqli_real_escape_string($conn, $_POST['atime']);

        $addtime_sql = "INSERT INTO time(time_id,start_time) VALUES ('$timeid', '$time') ";
        mysqli_query($conn, $addtime_sql);
        header("location: edit_showtime.php");
    }

    // delete showtime
    if (isset($_POST['del_showtime'])) {
        $showtimeID = $_POST['del_showtime'];
        $del_showtime = "DELETE FROM showtime WHERE showtime_id = '$showtimeID' ";
        $del_query = mysqli_query($conn, $del_showtime);

        header("location: edit_showtime.php");
    }

    // add type
    if (isset($_POST['add_type'])) {
        $movietypeid = mysqli_real_escape_string($conn, $_POST['movietypeid']);
        $movietype = mysqli_real_escape_string($conn, $_POST['movietype']);

        // check movie type id
        $check_type = "SELECT movie_type_id FROM movie_type";
        $check_type_query = mysqli_query($conn, $check_type);
        $result = mysqli_fetch_assoc($check_type_query);

        if ($result['movie_type_id'] === $movietypeid) {
            array_push($errors, "Movie type id นี้ถูกใช้แล้ว");
            $_SESSION['error'] = "Movie type id นี้ถูกใช้แล้ว";
        }

        if (count($errors) == 0) {
            $addtype = "INSERT INTO movie_type(movie_type_id,movie_type) VALUES ('$movietypeid', '$movietype') ";
            mysqli_query($conn, $addtype);
        }

        header("location: edit_showtime.php");
    }

    // edit showtime
    if (isset($_POST['edit_save'])) {
        $showtimeid = $_POST['edit_save'];
        $date = mysqli_real_escape_string($conn, $_POST['showtimeDate']);
        $hall = mysqli_real_escape_string($conn, $_POST['hall']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $audio = mysqli_real_escape_string($conn, $_POST['audio']);
        $sub = mysqli_real_escape_string($conn, $_POST['sub']);

        $update_showtime = "UPDATE showtime SET showtime_date='$date', theatre_id='$hall', time_id='$time', audio_id='$audio', sub_id='$sub' 
                            WHERE showtime_id='$showtimeid' " ;
        mysqli_query($conn, $update_showtime);

        header("location: edit_showtime.php");
    }

    mysqli_close($conn);
?>