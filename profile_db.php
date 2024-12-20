<?php
    session_start();
    require('dbconnect.php');

    $errors = array();
    
    if (isset($_GET['del'])) {
        $email = $_SESSION['email'];

        $sql = "DELETE FROM user WHERE uemail = '$email'";
        $result = mysqli_query($conn,$sql);

        if ($result) {
            //$_SESSION['user_delete'] = "Account deleted successfully";
            session_destroy();
            unset($_SESSION['name']);
            header('location: index.php');
        }

    }
    mysqli_close($conn);
?>