<?php 
include 'config.php';
if (isset($_SESSION['as_user'])) {
    $indexActive = 'active';

    // Handle Check-in
    if (isset($_POST['checkin'])) {
        $userId = $_SESSION['as_user']; 
        $date   = date("Y-m-d");
        $timeIn = date("H:i:s");

        // Check if the user has already checked in today
        $checkToday = mysqli_query($con, "SELECT * FROM attendance WHERE a_user='$userId' AND a_date='$date' AND a_time_in IS NOT NULL");
        if (mysqli_num_rows($checkToday) > 0) {
            // User has already checked in today
            $_SESSION['toastr_message'] = "You have already checked in today!";
            $_SESSION['toastr_type'] = "info";
        } else {
            // User can check in
            $user = mysqli_query($con,"SELECT u_time_in, u_time_out FROM `users` WHERE u_id='$userId'");
            $fetchUser = mysqli_fetch_assoc($user);
            $actualIn  = $fetchUser['u_time_in'];
            $actualOut = $fetchUser['u_time_out'];

            mysqli_query($con,"INSERT INTO attendance(a_date, a_time_in, a_user, a_actual_time_in, a_actual_time_out) 
            VALUES('$date', '$timeIn', '$userId', '$actualIn', '$actualOut')");

            $_SESSION['toastr_message'] = "Checked In at $timeIn";
            $_SESSION['toastr_type'] = "success";
            $_SESSION['checkin_time'] = "$date $timeIn";
        }

        header("Location: index.php");
        exit();
    }

    // Handle Check-out
    if (isset($_POST['checkout'])) {
        $userId = $_SESSION['as_user'];
        $timesheet = $_POST['timesheet'];
        $date   = date("Y-m-d");
        $timeOut = date("H:i:s");

        mysqli_query($con,"UPDATE attendance SET a_time_out='$timeOut', a_timesheet='$timesheet' WHERE a_user='$userId' AND a_date='$date' AND (a_time_out IS NULL OR a_time_out='')");
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

    $today = date("Y-m-d");
    $userId = $_SESSION['as_user'];
    $checkToday = mysqli_query($con,"SELECT * FROM attendance WHERE a_user='$userId' AND a_date='$today' AND (a_time_out IS NULL OR a_time_out='') ORDER BY a_id DESC LIMIT 1");
    $hasActiveCheckin = mysqli_num_rows($checkToday) > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <?php include 'header-files.php' ?>
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <div class="main-wrapper">
        <?php include 'header.php' ?>
        <?php include 'sidebar.php' ?>
        <div class="page-wrapper">
            <div class="content">
                <?php if (!$hasAdminRights) { ?>
                <div class="page-header">
                    <div class="page-title">
                        <h4>Mark Attendance</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form class="row" method="post">
                            <?php if (!$hasActiveCheckin) { ?>
                                <div class="col-md-4">
                                    <button type="submit" name="checkin" class="btn btn-success w-100" <?php echo (mysqli_num_rows($checkToday) > 0) ? 'disabled' : ''; ?>>Check In</button>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-4">
                                    <button type="submit" name="checkout" class="btn btn-danger w-100">Check Out</button>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h2 id="timer">00:00:00</h2>
                                </div>
                                <div class="form-group row mt-3">
                                    <label class="col-form-label col-md-2">Time Sheet</label>
                                    <div class="col-md-10">
                                        <textarea rows="5" cols="5" class="form-control" name="timesheet" placeholder="Enter text here" required></textarea>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
                <div class="page-header">
                    <div class="page-title">
                        <h4>Attendance Details</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Date</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Actual Time In</th>
                                        <th>Actual Time Out</th>
                                        <th>Productivity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sno = 1;
                                        $showAttendance = mysqli_query($con,"SELECT * FROM `attendance` WHERE a_user='$userId' ORDER BY a_id DESC");
                                        while ($row = mysqli_fetch_assoc($showAttendance)) {
                                            $prod = "-";
                                            if ($row['a_time_in'] && $row['a_time_out']) {
                                                $t1 = strtotime($row['a_time_in']);
                                                $t2 = strtotime($row['a_time_out']);
                                                $diff = $t2 - $t1;
                                                $hours = floor($diff / 3600);
                                                $mins = floor(($diff % 3600) / 60);
                                                $prod = $hours . "h " . $mins . "m";
                                            }
                                    ?>
                                    <tr>
                                        <td><?= $sno ?></td>
                                        <td><?= $row['a_date'] ?></td>
                                        <td><?= $row['a_time_in'] ?></td>
                                        <td><?= $row['a_time_out'] ?></td>
                                        <td><?= $row['a_actual_time_in'] ?></td>
                                        <td><?= $row['a_actual_time_out'] ?></td>
                                        <td><?= $row['a_timesheet'] ?></td>
                                    </tr>
                                    <?php 
                                            $sno++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } ?>
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

    if ($hasActiveCheckin) {
        $row = mysqli_fetch_assoc($checkToday);
        if ($row && $row['a_time_in'] && !$row['a_time_out']) {
            $startTimeJs = date("Y-m-d H:i:s", strtotime($today . ' ' . $row['a_time_in']));
            echo "startTimer('$startTimeJs');";
        }
    }
?>
</script>
