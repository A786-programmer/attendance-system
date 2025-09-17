<?php 
include 'config.php';

if (isset($_SESSION['as_user'])) {
    $index = 'active';

    if (isset($_POST['checkin'])) {
        $userId = $_SESSION['as_user']; 
        $date   = date("Y-m-d");
        $timeIn = date("H:i:s");

        $user = mysqli_query($con,"SELECT u_time_in, u_time_out FROM `users` WHERE u_id='$userId'");
        $fetchUser = mysqli_fetch_assoc($user);
        $actualIn  = $fetchUser['u_time_in'];
        $actualOut = $fetchUser['u_time_out'];

        $check = mysqli_query($con,"SELECT * FROM attendance WHERE a_user='$userId' AND a_date='$date' AND (a_time_out IS NULL OR a_time_out='')");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($con,"INSERT INTO attendance(a_date, a_time_in, a_user, a_actual_time_in, a_actual_time_out) VALUES('$date', '$timeIn', '$userId', '$actualIn', '$actualOut')");
            $_SESSION['toastr_message'] = "Checked In at $timeIn";
            $_SESSION['toastr_type'] = "success";
            $_SESSION['checkin_time'] = "$date $timeIn";
        } else {
            $_SESSION['toastr_message'] = "You already have an active check-in!";
            $_SESSION['toastr_type'] = "info";
        }

        header("Location: index.php");
        exit();
    }

    if (isset($_POST['checkout'])) {
        $userId = $_SESSION['as_user'];
        $date   = date("Y-m-d");
        $timeOut = date("H:i:s");

        mysqli_query($con,"UPDATE attendance SET a_time_out='$timeOut' WHERE a_user='$userId' AND a_date='$date' AND (a_time_out IS NULL OR a_time_out='')");
        if (mysqli_affected_rows($con) > 0) {
            $_SESSION['toastr_message'] = "Checked Out at $timeOut";
            $_SESSION['toastr_type'] = "success";
            $_SESSION['checkout_done'] = true;

        } else {
            $_SESSION['toastr_message'] = "No active check-in found!";
            $_SESSION['toastr_type'] = "info";
        }

        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Start Attendance</title>
        <?php include 'header-files.php' ?>
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    </head>
    <body>
        <div class="main-wrapper">
            <?php include 'header.php' ?>
            <?php include 'sidebar.php' ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="page-header">
                        <div class="page-title">
                            <h4>Attendance System</h4>
                        </div>
                    </div>
                    <form method="post">
                        <button type="submit" name="checkin" class="btn btn-success">Check In</button>
                        <button type="submit" name="checkout" class="btn btn-danger">Check Out</button>
                    </form>

                    <div style="margin-top:20px;">
                        <h5>Work Timer:</h5>
                        <span id="timer">00:00:00</span>
                    </div>
                </div>
            </div>
        </div>  
    </body>
</html>
<?php 
} else {
    $_SESSION['toastr_message'] = "Please Login First!";
    $_SESSION['toastr_type'] = "info";
    header("Location: login.php");
    exit();
}
include 'footer-files.php';
?>  

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>

<script>
    let timerInterval;
    let startTime;

    function startTimer(startTimestamp) {
        startTime = new Date(startTimestamp.replace(" ", "T")); 
        if (isNaN(startTime)) {
            console.error("Invalid Date:", startTimestamp);
            return;
        }
        timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    }

    function stopTimer() {
        clearInterval(timerInterval);
        document.getElementById("timer").innerText = "00:00:00";
    }

    function updateTimer() {
        let now = new Date();
        let diff = Math.floor((now - startTime) / 1000);
        let hours = String(Math.floor(diff / 3600)).padStart(2, '0');
        let minutes = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
        let seconds = String(diff % 60).padStart(2, '0');
        document.getElementById("timer").innerText = `${hours}:${minutes}:${seconds}`;
    }

    <?php
    if (isset($_SESSION['checkin_time'])) {
        echo "startTimer('" . $_SESSION['checkin_time'] . "');";
    }

    if (isset($_SESSION['checkout_done'])) {
        echo "stopTimer();";
        unset($_SESSION['checkout_done']);
    }

    $userId = $_SESSION['as_user'] ?? null;
    if ($userId) {
        $today = date("Y-m-d");
        $q = mysqli_query($con,"SELECT a_time_in, a_time_out FROM attendance WHERE a_user='$userId' AND a_date='$today' ORDER BY a_id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($q);
        if ($row && $row['a_time_in'] && !$row['a_time_out']) {
            $startTimeJs = date("Y-m-d H:i:s", strtotime($today . ' ' . $row['a_time_in']));
            echo "startTimer('$startTimeJs');";
        }
    }
    ?>
</script>
