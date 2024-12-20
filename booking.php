<?php 
    session_start();
    require('dbconnect.php');

    $errors = array();

    if (isset($_POST['seats'])) {

        if (count($errors) == 0) {
            $s = $_POST['seats'];
            $seats = explode(',',$s);
            $l = count($seats);

            $_SESSION['seats'] = $s;

            $email = $_SESSION['email'];
            $showtimeID = $_SESSION['showtimeID'];

            date_default_timezone_set("Asia/Bangkok");
            $date = date("Y-m-d");
            $time = date("H:i:s");

            $_SESSION['date'] = $date;
            $_SESSION['time'] = $time;

            $total=$_COOKIE['total'];

            $_SESSION['total'] = $total;
            
            
        }
    }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css\booking.css">

    <title>ฺBooking</title>
</head>
<body>
    <?php include 'menubar.php'; ?>
    
    <main class="page payment-page container">
    <section class="payment-form dark">
      <div class="container">
        <form method="post" action="payment.php">
          <div class="products">
            <h3 class="title">Checkout</h3>

            <div class="item">
              <span class="price"><?=$total?> บาท</span>
              <p class="item-name"><?= $s ?></p>
            </div>
          </div>

          <div class="card-details">
            <h3 class="title">Credit Card Details</h3>
            <div class="row">
              <div class="form-group col-sm-7">
                <label for="card-holder">Card Holder</label>
                <input id="card-holder" type="text" class="form-control" placeholder="Card Holder" aria-label="Card Holder" aria-describedby="basic-addon1">
              </div>
              <div class="form-group col-sm-5">
                <label for="">Expiration Date</label>
                <div class="input-group expiration-date">
                  <input type="text" class="form-control" placeholder="MM" aria-label="MM" aria-describedby="basic-addon1">
                  <span class="date-separator">/</span>
                  <input type="text" class="form-control" placeholder="YY" aria-label="YY" aria-describedby="basic-addon1">
                </div>
              </div>
              <div class="form-group col-sm-8">
                <label for="card-number">Card Number</label>
                <input id="card-number" type="text" class="form-control" placeholder="Card Number" aria-label="Card Holder" aria-describedby="basic-addon1">
              </div>
              <div class="form-group col-sm-4">
                <label for="cvc">CVC</label>
                <input id="cvc" type="text" class="form-control" placeholder="CVC" aria-label="Card Holder" aria-describedby="basic-addon1">
              </div>
              <div class="form-group">
                <button type="submit" name="msubmit" class="btn btn-success">ยืนยัน</button>
                <button type="submit" name="mcancel" class="btn btn-danger" value="<?=$_SESSION['showtimeID']?>">ยกเลิก</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>

</body>
</html>