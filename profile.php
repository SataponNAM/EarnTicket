<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require('dbconnect.php');
    $email_in = $_SESSION['email'];
    $sql = "SELECT * FROM user WHERE uemail = '$email_in'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $name = $row['fname']." ".$row['lname'];
    $email = $row['uemail'];
    $phone = $row['phone'];
    $birthday = $row['birthday'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <title>Profile</title>
</head>
<body>

<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

    <!-- profile -->
    <div class="container">
    <div class="pro-content">
        <h3><p>ข้อมูลผู้ใช้</p></h3>
        <p><?php echo "ชื่อผู้ใช้ : ".$name."<br>"; ?></p>
        <p><?php echo "อีเมล : ".$email."<br>"; ?></p>
        <p><?php echo "เบอร์โทรศัพท์ : ".$phone."<br>"; ?></p>
        <p><?php echo "วันเกิด : ".$birthday."<br>"; ?></p>
    </div>

    <div class="edit">
            <a href="edit_profile.php?edit=<?php $_SESSION['email'] ?>">แก้ไขบัญชีผู้ใช้</a><br>
            <a href="profile_db.php?del=<?php $_SESSION['email'] ?>" class="del">ลบบัญชี</a><br>
        </div>
        
    </div>
    
</body>
</html>