<?php
    session_start();
    require('../dbconnect.php');
    
    $errors = array();

    if (isset($_POST['add_hall'])) {
        $hall_name = mysqli_real_escape_string($conn, $_POST['hall_name']);
        $nseat = mysqli_real_escape_string($conn, $_POST['number_of_seat']);
        
        // Check ShowtimeID
        $hall_id = rand(100,999);
        $hall_id_check = "SELECT theatre_id FROM theatre_hall WHERE theatre_id = '$hall_id' ";
        $hall_id_check_query = mysqli_query($conn, $hall_id_check);
        
        while ((mysqli_num_rows($hall_id_check_query)) > 0) {
            $hall_id = rand(100,999);
            $hall_id_check = "SELECT theatre_id FROM theatre_hall WHERE theatre_id = '$hall_id' ";
            $hall_id_check_query = mysqli_query($conn, $hall_id_check);
        };

        if (count($errors) == 0) {
            $addhall_sql = "INSERT INTO theatre_hall(theatre_id,hall_name,number_of_seats) VALUE('$hall_id','$hall_name','$nseat') ";
            $addhall_query = mysqli_query($conn, $addhall_sql);

            header('location: edit_hall.php');
        } else {
            header('location: add_hall.php');
        }
    }


    if (isset($_POST['del_hall'])) {
        $hallid = mysqli_real_escape_string($conn, $_POST['del_hall']);
        $del_sql = "DELETE FROM theatre_hall where theatre_id = '$hallid' ";
        $del_query = mysqli_query($conn, $del_sql);

        header("location: edit_hall.php");
    }

    if (isset($_POST['save_edit_hall'])) {
        $hallid = $_POST['save_edit_hall'];
        $hall_name = mysqli_real_escape_string($conn, $_POST['hall_name']);
        $nseat = mysqli_real_escape_string($conn, $_POST['number_of_seat']);

        $uhall = "UPDATE theatre_hall SET hall_name = '$hall_name', number_of_seats = '$nseat' WHERE theatre_id = $hallid" ;
        mysqli_query($conn, $uhall);

        header("location: edit_hall.php");
    }

?>