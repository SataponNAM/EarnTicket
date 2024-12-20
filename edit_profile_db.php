<?php 
    session_start();
    require('dbconnect.php');

    $errors = array();
    
    if (isset($_POST['edit'])) {
    
        $email = $_SESSION['email'];

        $sql = "SELECT * FROM user WHERE uemail = '$email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $pass = md5($password);

        if (empty($fname)) {
            $fname = $row['fname'];
        }
        if (empty($lname)) {
            $lname = $row['lname'];
        }
        if (empty($phone)) {
            $phone = $row['phone'];
        }
        if (empty($password)) {
            $pass = $row['password'];
        }

        $sql = "UPDATE user SET fname='$fname', lname='$lname', phone='$phone', password='$pass' WHERE uemail='$email'";
        $result = mysqli_query($conn,$sql);

        if ($result) {
            header('location:profile.php');
        } else {
            array_push($errors, "บันทึกไม่สำเร็จ");
            $_SESSION['error'] = "บันทึกไม่สำเร็จ";
            header('location:edit_profile.php');
        }
    }
    
    mysqli_close($conn);
?>