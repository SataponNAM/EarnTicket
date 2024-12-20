<?php 
    session_start();
    require('../dbconnect.php');
    
    $errors = array();

    $targetDir = "movie image/";


    if (isset($_POST['save'])) {
        $moviename = mysqli_real_escape_string($conn, $_POST['movie_name']);
        $lenght = mysqli_real_escape_string($conn, $_POST['lenght']);
        $type = $_POST['mtype'];

        // Check MovieID
        $movieid = rand(10000,99999);
        $movieid_check = "SELECT movie_id FROM movie WHERE movie_id = '$movieid' ";
        $movieid_check_query = mysqli_query($conn, $movieid_check);
        
        while ((mysqli_num_rows($movieid_check_query)) > 0) {
            $movieid = rand(10000,99999);
            $movieid_check = "SELECT movie_id FROM movie WHERE movie_id = '$movieid' ";
            $movieid_check_query = mysqli_query($conn, $movieid_check);
        }

        if (empty($movieid)) {
            array_push($errors, "กรุณากรอก Movie ID");
            $_SESSION['error'] = "กรุณากรอก Movie ID";
        } elseif (empty($moviename)) {
            array_push($errors, "กรุณากรอก Movie Name");
            $_SESSION['error'] = "กรุณากรอก Movie Name";
        } elseif (empty($lenght)) {
            array_push($errors, "กรุณากรอกความยาวหนัง");
            $_SESSION['error'] = "กรุณากรอกความยาวหนัง";
        } elseif (empty($type)) {
            array_push($errors, "กรุณาเลือก type");
            $_SESSION['error'] = "กรุณาเลือก type";
        } 

        if (count($errors) == 0) {
            // insert
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir.$fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            //$allowTypes = array('jpg', 'png', 'jpeg');
            //if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            //$insert = mysqli_query($conn,("INSERT INTO movie(image) VALUES ('".$fileName."') "));
            //}
            

            $sql = "INSERT INTO movie(movie_id, movie_name, lenght, image) VALUES ('$movieid','$moviename', '$lenght', '".$fileName."')";
            $query = mysqli_query($conn, $sql);

            // insert movie type
            foreach ($type as $typeid) {
                $tsql = "INSERT INTO mtype(movie_id,movie_type_id) VALUES ($movieid,'".mysqli_real_escape_string($conn,$typeid)."')";
                mysqli_query($conn, $tsql);
            }

            header('location: movie_page.php');
        } else {
            header('location: edit_movie.php');
        }

    }

    if (isset($_POST['delmovie'])) {
        $movieID = $_POST['delmovie'];
        
        $del_sql = "DELETE FROM movie WHERE movie_id = '$movieID' ";
        $result = mysqli_query($conn,$del_sql);

        if ($result) {
            header("location: movie_page.php");
        }
    }

    if (isset($_POST['edit_save'])) {
        $movieid = $_POST['edit_save'];
        $moviename = mysqli_real_escape_string($conn, $_POST['movie_name']);
        $lenght = mysqli_real_escape_string($conn, $_POST['lenght']);

        $type = $_POST['mtype'];
        $type_sql = "SELECT * FROM mtype JOIN movie_type ON mtype.movie_type_id = movie_type.movie_type_id WHERE movie_id = '$movieid' " ;
        $type_query = mysqli_query($conn, $type_sql);

        $movie_type = [];

        $fileName  = $_FILES["image"]["name"];
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $image_temp=$_FILES["image"]["tmp_name"];

        if ($fileName == NULL) {
            $usql = "UPDATE movie SET movie_name='$moviename', lenght='$lenght'  WHERE movie_id = '$movieid' ";
        } else {
            move_uploaded_file($image_temp, $targetFilePath);

            $usql = "UPDATE movie SET movie_name='$moviename', lenght='$lenght', image='$fileName' WHERE movie_id = '$movieid' ";
            $uquery = mysqli_query($conn, $usql);   
        }
        $uquery = mysqli_query($conn, $usql);

        foreach ($type_query as $rows) {
            $movie_type[] = $rows['movie_type_id'];
        }

        //Insert Type
        foreach ($type as $typeInput) {
            if (!in_array($typeInput,$movie_type)) {
                $type_sql = "INSERT INTO mtype (movie_id,movie_type_id) VALUES ('$movieid','$typeInput')" ;
                mysqli_real_query($conn, $type_sql);
            }
        }

        //Delete
        foreach ($movie_type as $typedrows) {
            if (!in_array($typedrows,$type)) {
                $delete_sql = "DELETE FROM mtype WHERE movie_id = '$movieid' AND movie_type_id = '$typedrows' " ;
                mysqli_real_query($conn, $delete_sql);
            }
        }

        header('location: movie_page.php');
        exit();
    }

    mysqli_close($conn);
?>
