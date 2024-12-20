<?php 
    session_start();
    require('dbconnect.php');
    
    $errors = array();

    if (isset($_POST['reg'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $bod = mysqli_real_escape_string($conn, $_POST['birthday']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['cfpassword']);

        if (empty($fname) && empty($lname) && empty($email) && empty($bod) && empty($password_1)){
            array_push($errors, "กรุณากรอกข้อมูล");
            $_SESSION['error'] = "กรุณากรอกข้อมูล" ;
        }

        else if (empty($fname)) {
            array_push($errors, "กรุณากรอกชื่อ");
            $_SESSION['error'] = "กรุณากรอกชื่อ";
            $_SESSION['reg_lname'] = $lname;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_phone'] = $phone;
            $_SESSION['reg_bod'] = $bod;
            $_SESSION['reg_pass'] = $password_1;
            $_SESSION['reg_pass2'] = $password_2;
        }
        else if (empty($lname)) {
            array_push($errors, "กรุณากรอกนามสกุล");
            $_SESSION['error'] = "กรุณากรอกนามสกุล";
            $_SESSION['reg_fname'] = $fname;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_phone'] = $phone;
            $_SESSION['reg_bod'] = $bod;
            $_SESSION['reg_pass'] = $password_1;
            $_SESSION['reg_pass2'] = $password_2;
        }
        else if (empty($email)) {
            array_push($errors, "กรุณากรอกอีเมล");
            $_SESSION['error'] = "กรุณากรอกอีเมล";
            $_SESSION['reg_fname'] = $fname;
            $_SESSION['reg_lname'] = $lname;
            $_SESSION['reg_phone'] = $phone;
            $_SESSION['reg_bod'] = $bod;
            $_SESSION['reg_pass'] = $password_1;
            $_SESSION['reg_pass2'] = $password_2;
        }

        else if (empty($phone)) {
            array_push($errors, "กรุณากรอกเบอร์โทรศัพท์");
            $_SESSION['error'] = "กรุณากรอกเบอร์โทรศัพท์";
            $_SESSION['reg_fname'] = $fname;
            $_SESSION['reg_lname'] = $lname;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_bod'] = $bod;
            $_SESSION['reg_pass'] = $password_1;
            $_SESSION['reg_pass2'] = $password_2;
        }

        else if (empty($bod)) {
            array_push($errors, "กรุณากรอกวันเกิด");
            $_SESSION['error'] = "กรุณากรอกวันเกิด";
            $_SESSION['reg_fname'] = $fname;
            $_SESSION['reg_lname'] = $lname;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_phone'] = $phone;
            $_SESSION['reg_pass'] = $password_1;
            $_SESSION['reg_pass2'] = $password_2;
        }
        else if (empty($password_1)) {
            array_push($errors, "กรุณากรอกรหัสผ่าน");
            $_SESSION['error'] = "กรุณากรอกรหัสผ่าน";
            $_SESSION['reg_fname'] = $fname;
            $_SESSION['reg_lname'] = $lname;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_phone'] = $phone;
            $_SESSION['reg_bod'] = $bod;
            $_SESSION['reg_pass2'] = $password_2;
        }
        else if ($password_1 != $password_2) {
            array_push($errors, "รหัสผ่านไม่เหมือนกัน");
            $_SESSION['error'] = "รหัสผ่านไม่เหมือนกัน";
            $_SESSION['reg_fname'] = $fname;
            $_SESSION['reg_lname'] = $lname;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_phone'] = $phone;
            $_SESSION['reg_bod'] = $bod;
            $_SESSION['reg_pass'] = $password_1;
            $_SESSION['reg_pass2'] = $password_2;
        }

        $user_check_query = "SELECT * FROM user WHERE uemail = '$email'";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['uemail'] === $email) {
                array_push($errors, "อีเมลนี้ถูกใช้แล้ว");
                $_SESSION['error'] = "อีเมลนี้ถูกใช้แล้ว";
                $_SESSION['reg_fname'] = $fname;
                $_SESSION['reg_lname'] = $lname;
                $_SESSION['reg_email'] = $email;
                $_SESSION['reg_phone'] = $phone;
                $_SESSION['reg_bod'] = $bod;
                $_SESSION['reg_pass'] = $password_1;
                $_SESSION['reg_pass2'] = $password_2;
            }
        }

        if (count($errors) == 0) {
            $password = md5($password_1);

            $sql = "INSERT INTO user (uemail,fname,lname,phone,birthday,password) VALUES ('$email','$fname','$lname','$phone','$bod','$password')";
            mysqli_query($conn, $sql);

            $_SESSION['name'] = $row['fname']." ".$row['lname'];
            $_SESSION['success'] = "สร้างบัญชีสำเร็จ";
            header('location: login.php');
        } else {
            header("location: register.php");
        }
    }
    mysqli_close($conn);
?>