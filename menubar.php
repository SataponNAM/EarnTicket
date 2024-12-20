<?php 
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    
    require('dbconnect.php');

    $linkPage = 'login.php';
    $linkName = 'เข้าสู่ระบบ';
    $linkPage2 = 'register.php';
    $linkName2 = 'สร้างบัญชีใหม่';
    $linkPage3 = 'index.php';
    $linkName3 = 'ภาพยนตร์';

    if (isset($_SESSION['name'])) {
        $linkPage = 'profile.php';
        $linkName = 'ข้อมูลผู้ใช้';
        $linkPage2 = "index.php?logout='1'";
        $linkName2 = 'ออกจากระบบ';
        $linkPage3 = 'user_ticket.php';
        $linkName3 = 'ตั๋วของฉัน';
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['name']);
        header('location: index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menubar</title>

    <link rel="stylesheet" href="css/menubar.css">
    <script src="javascript/menubar.js"></script>
</head>
<body>
<header>
    <nav>
    <img src="css/pic/logo.png">
      
        <?php if(isset($_SESSION['name'])) : ?>
          <ul>
            <li><a href="index.php">หน้าหลัก</a></li>
            <li><a href="<?php echo $linkPage3; ?>"><?php echo $linkName3; ?></a></li>
            <li><a href="<?php echo $linkPage; ?>"><?php echo $linkName; ?></a></li>
            <li><a href="<?php echo $linkPage2; ?>"><?php echo $linkName2; ?></a></li>
          </ul>
        <?php else : ?>
          <ul>
            <li><a href="index.php">หน้าหลัก</a></li>
            <li><a href="<?php echo $linkPage3; ?>"><?php echo $linkName3; ?></a></li>
            <li><a href="<?php echo $linkPage; ?>"><?php echo $linkName; ?></a></li>
            <li><a href="<?php echo $linkPage2; ?>"><?php echo $linkName2; ?></a></li>
          </ul>
        <?php endif ?>
      
    </nav>
  </header>
</body>
</html>