<?php 
    session_start();
    require('dbconnect.php');

    $errors = array();

    if (isset($_POST["login"])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($email) && empty($password)){
            array_push($errors, "กรุณากรอกอีเมลและรหัสผ่าน");
            $_SESSION['error'] = "กรุณากรอกอีเมลและรหัสผ่าน";
        }

        else if (empty($email)) {
            array_push($errors, "กรุณากรอกอีเมล");
            $_SESSION['error'] = "กรุณากรอกอีเมล";
            $_SESSION['login_pass'] = $password;
        }

        else if (empty($password)) {
            array_push($errors, "กรุณากรอกรหัสผ่าน");
            $_SESSION['error'] = "กรุณากรอกรหัสผ่าน";
            $_SESSION['login_email'] = $email;
        }

        if (count($errors) == 0) {
            $pass = md5($password);
            
            $sql = "SELECT * FROM user WHERE uemail = '$email' AND password = '$pass'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['name'] = $row['fname']." ".$row['lname'];
                $_SESSION['email'] = $row['uemail'];

                if ($_SESSION['email'] === 'admin1@email.com') {
                    header("location: admin/admin_page.php");
                } else {
                    header("location: index.php");
                }
            } else {
                array_push($errors, "อีเมลหรือรหัสผ่านไม่ถูกต้อง");
                $_SESSION['error'] = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
                $_SESSION['login_email'] = $email;
                $_SESSION['login_pass'] = $password;
                header("location: login.php");
            }
        } else {
            header("location: login.php");
        }
    }

    mysqli_close($conn);
?>