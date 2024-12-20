<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
include('dbconnect.php'); 

$fname = '';
if (isset($_SESSION['reg_fname'])) {
    $fname = $_SESSION['reg_fname'];
    unset($_SESSION['reg_fname']);
}

$lname = '';
if (isset($_SESSION['reg_lname'])) {
    $lname = $_SESSION['reg_lname'];
    unset($_SESSION['reg_lname']);
}

$email = '';
if (isset($_SESSION['reg_email'])) {
    $email = $_SESSION['reg_email'];
    unset($_SESSION['reg_email']);
}

$phone = '';
if (isset($_SESSION['reg_phone'])) {
    $phone = $_SESSION['reg_phone'];
    unset($_SESSION['reg_phone']);
}

$bod = '';
if (isset($_SESSION['reg_bod'])) {
    $bod = $_SESSION['reg_bod'];
    unset($_SESSION['reg_bod']);
}

$password_1 = '';
if (isset($_SESSION['reg_pass'])) {
    $password_1 = $_SESSION['reg_pass'];
    unset($_SESSION['reg_pass']);
}

$password_2 = '';
if (isset($_SESSION['reg_pass2'])) {
    $password_2 = $_SESSION['reg_pass2'];
    unset($_SESSION['reg_pass2']);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Index</title>
</head>
<body>

<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

<div class="container">
  <div class="form-container">
              <form action="register_db.php" method="POST">
              <h2>สร้างบัญชีใหม่</h2>
                <!-- แจ้ง error -->
                <?php include('errors.php'); ?>
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="error">
                        <h5>
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </h5>
                    </div>
                <?php endif ?>
                
                <!-- กรอกข้อมูล -->
                
                  <input type="text" name="fname" class="form-control form-control-lg" value="<?php echo $fname ?>" placeholder="ชื่อ" />
                  <input type="text" name="lname" class="form-control form-control-lg" value="<?php echo $lname ?>" placeholder="นามสกุล" />
                  <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $email ?>" placeholder="อีเมล"  />
                  <input type="tel" name="phone" class="form-control form-control-lg" value="<?php echo $phone ?>" placeholder="เบอร์โทรศัพท์"/>
                  <input placeholder="วันเกิด" type="text" class="form-control form-control-lg" name="birthday" value="<?php echo $bod ?>" onfocus="(this.type = 'date')" onblur="(this.type ='text')">
                  <input type="password" name="password" class="form-control form-control-lg" value="<?php echo $password_1 ?>" placeholder="รหัสผ่าน" />
                  <input type="password" name="cfpassword" class="form-control form-control-lg" value="<?php echo $password_2 ?>"placeholder="ยืนยันรหัสผ่าน" />
                  <button type="submit" name="reg" class="form-btn">สร้างบัญชี</button>

                <p>มีบัญชีแล้ว? <a href="login.php"><u>เข้าสู่ระบบ</u></a></p>

              </form>
  </div>
</div>
</body>
</html>