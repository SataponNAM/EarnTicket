<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
include('dbconnect.php'); 
$email = '';
if (isset($_SESSION['login_email'])) {
    $email = $_SESSION['login_email'];
    unset($_SESSION['login_email']);
}

$password = '';
if (isset($_SESSION['login_pass'])) {
    $password = $_SESSION['login_pass'];
    unset($_SESSION['login_pass']);
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    
<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

<div class="container">
  <div class="form-container">
    <form action="login_db.php" method="post">
      <?php include('errors.php'); ?>
      <h2>เข้าสู่ระบบ</h2>
                  <!-- แจ้ง error -->
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

                  <?php if (isset($_SESSION['success'])) : ?>
                    <div class="success">
                        <h5>
                            <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                        </h5>
                    </div>
                  <?php endif ?>

                <!-- กรอกข้อมูล -->
                
                <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $email ?>" placeholder="อีเมล"  />
                <input type="password" name="password" class="form-control form-control-lg" value="<?php echo $password ?>" placeholder="รหัสผ่าน" />
                <button type="submit" value="Login" name="login" class="form-btn">เข้าสู่ระบบ</button>
                <p>ยังไม่มีบัญชี? <a href="register.php"><u>สร้างบัญชีใหม่</u></a></p>

              </form>        
  </div>
</div>
</body>
</html>