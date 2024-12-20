<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit_profile.css">
    <title>Profile</title>
</head>
<body>
    
<div class="menubar-container">
<?php include 'menubar.php'; ?>
</div>

<div class="container">
    <div class="form-container">
        <form action="edit_profile_db.php" method="POST">
        <h2>แก้ไขบัญชีผู้ใช้</h2>
            <input type="text" name="fname"  placeholder="ชื่อ" />
            <input type="text" name="lname" placeholder="นามสกุล" />
            <input type="tel" name="phone" placeholder="เบอร์โทรศัพท์"/>
            <input type="password" name="password" placeholder="รหัสผ่าน" />
            <button type="submit" name="edit" class="form-btn">บันทึก</button>
        </form>
    </div>

    
</div>
    
</body>
</html>