<?php
    session_start();
    require('dbconnect.php');

    $errors = array();

    if (isset($_POST['msubmit'])) {

        $email = $_SESSION['email'];
        $showtimeID = $_SESSION['showtimeID'];
        $date = $_SESSION['date'];
        $time = $_SESSION['time'];
        $total = $_SESSION['total'];
        $seats = explode(',',$_SESSION['seats']);
        $l = count($seats);

        // Check PaymentID
        $payID = rand(1000000000,9999999999);
        $payID_check = "SELECT pay_id FROM payment WHERE pay_id = '$payID' ";
        $payID_check_query = mysqli_query($conn, $payID_check);
        
        while ((mysqli_num_rows($payID_check_query)) > 0) {
            $payID = rand(1000000000,9999999999);
            $payID_check = "SELECT pay_id FROM payment WHERE pay_id = '$payID' ";
            $payID_check_query = mysqli_query($conn, $payID_check);
        }

        if (count($errors) == 0) {
            // insert payment
            $sql_insert_pay = "INSERT INTO payment(pay_id,total_price,pay_method,pay_date,pay_time) VALUE ('$payID','$total','credit card','$date','$time') ";
            mysqli_query($conn, $sql_insert_pay);
            // inesrt payment

            // insert ticket
            // check ticketID
            $sql_ticketc = "SELECT ticket_id FROM ticket";
            $ticketID_check_query = mysqli_query($conn, $sql_ticketc);

            for ($i=0; $i < $l; $i++) { 
                $seatID = $seats[$i];

                do {
                    $ticketID = rand(1000000000,9999999999);
                } while ($ticketID == mysqli_fetch_array($ticketID_check_query));

                $sql_insert_ticket = "INSERT INTO ticket(ticket_id,uemail,showtime_id,seat_id,pay_id) VALUE ('$ticketID','$email','$showtimeID','$seatID','$payID')";
                mysqli_query($conn, $sql_insert_ticket);
            }
            
            header('location: user_ticket.php');
        } else {
            header('location: index.php');
        }
    }

    if (isset($_POST['mcancel'])) {
        header('location: movie_booking.php');
    }
?>