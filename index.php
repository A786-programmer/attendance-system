<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if (isset($_SESSION['as_user'])) {
            $indexActive = 'active';

            // Handle Check-in
            if (isset($_POST['checkin'])) {
                try {
                    $userId = $_SESSION['as_user']; 
                    $date   = date("Y-m-d");
                    $timeIn = date("H:i:s");

                    $checkToday = mysqli_query($con, "SELECT * FROM attendance WHERE a_user='$userId' AND a_date='$date' AND a_time_in IS NOT NULL");
                    if (mysqli_num_rows($checkToday) > 0) {
                        $_SESSION['toastr_message'] = "You have already checked in today!";
                        $_SESSION['toastr_type'] = "info";
                        header("Location: index.php");
                        exit();
                    }

                    $user = mysqli_query($con,"SELECT u_time_in, u_time_out FROM `users` WHERE u_id='$userId'");
                    $fetchUser = mysqli_fetch_assoc($user);
                    $actualIn  = $fetchUser['u_time_in'];
                    $actualOut = $fetchUser['u_time_out'];

                    mysqli_query($con,"INSERT INTO attendance(a_date, a_time_in, a_user, a_actual_time_in, a_actual_time_out) 
                        VALUES('$date', '$timeIn', '$userId', '$actualIn', '$actualOut')");

                    $_SESSION['toastr_message'] = "Checked In at $timeIn";
                    $_SESSION['toastr_type'] = "success";
                    $_SESSION['checkin_time'] = "$date $timeIn";
                    header("Location: index.php");
                    exit();
                } catch (Exception $e) {
                    $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                    $_SESSION['toastr_type'] = "error";
                    header("Location: index.php");
                    exit();
                }
            }

            // Handle Check-out
            if (isset($_POST['checkout'])) {
                try {
                    $userId = $_SESSION['as_user'];
                    $timesheet = isset($_POST['timesheet']) ? $_POST['timesheet'] : '';
                    $date   = date("Y-m-d");
                    $timeOut = date("H:i:s");

                    mysqli_query($con,"UPDATE attendance SET a_time_out='$timeOut', a_timesheet='" . mysqli_real_escape_string($con, $timesheet) . "' WHERE a_user='$userId' AND a_date='$date' AND (a_time_out IS NULL OR a_time_out='')");

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
                } catch (Exception $e) {
                    $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                    $_SESSION['toastr_type'] = "error";
                    header("Location: index.php");
                    exit();
                }
            }

            $today = date("Y-m-d");
            $userId = $_SESSION['as_user'];
            $checkToday = mysqli_query($con,"SELECT * FROM attendance WHERE a_user='$userId' AND a_date='$today' AND (a_time_out IS NULL OR a_time_out='') ORDER BY a_id DESC LIMIT 1");
            $hasActiveCheckin = mysqli_num_rows($checkToday) > 0;

            $headerStartTs = null;
            if ($hasActiveCheckin) {
                $activeRow = mysqli_fetch_assoc($checkToday);
                $headerStartTs = strtotime($activeRow['a_date'] . ' ' . $activeRow['a_time_in']);
            } elseif (isset($_SESSION['checkin_time'])) {
                $headerStartTs = strtotime($_SESSION['checkin_time']);
            }

            $activeTimers = [];
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
                                        <button type="submit" name="checkin" class="btn btn-success w-100">Check In</button>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-4">
                                        <button type="submit" name="checkout" class="btn btn-danger w-100">Check Out</button>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h2 id="timer">00:00:00</h2>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <label class="col-form-label col-md-2">Progress</label>
                                        <div class="col-md-10">
                                            <textarea rows="5" cols="5" class="form-control" name="timesheet" placeholder="Enter Your Today's work here" required></textarea>
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
                                            <th>Hours Worked</th>
                                            <th>Actual Time In</th>
                                            <th>Actual Time Out</th>
                                            <th>Hours Needed</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $attendance = mysqli_query($con,"SELECT * FROM attendance WHERE a_user='$userId' ORDER BY a_date DESC");
                                            while ($fetchAttendance = mysqli_fetch_assoc($attendance)) {
                                                $hoursWorked = '';
                                                $timeIn = $fetchAttendance['a_time_in'] ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_time_in']) : null;
                                                $timeOut = ($fetchAttendance['a_time_out'] && $fetchAttendance['a_time_out'] !== '00:00:00')
                                                    ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_time_out']) : null;

                                                if ($timeOut && $timeIn) {
                                                    $diffInSeconds = $timeOut - $timeIn;
                                                    if ($diffInSeconds < 0) $diffInSeconds = 0;
                                                    $hoursWorked = sprintf('%02d:%02d:%02d',
                                                        floor($diffInSeconds / 3600),
                                                        floor(($diffInSeconds % 3600) / 60),
                                                        $diffInSeconds % 60
                                                    );
                                                } else if ($timeIn && !$timeOut) {
                                                    $timerId = "timer-row-" . $fetchAttendance['a_id'];
                                                    $hoursWorked = '<p id="'.$timerId.'" class="row-timer">00:00:00</p>';
                                                    $activeTimers[] = [
                                                        'id' => $timerId,
                                                        'start_ts' => $timeIn
                                                    ];
                                                } else {
                                                    $hoursWorked = '00:00:00';
                                                }
                                                $actualTimeIn  = $fetchAttendance['a_actual_time_in'] ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_actual_time_in']) : null;
                                                $actualTimeOut = $fetchAttendance['a_actual_time_out'] ? strtotime($fetchAttendance['a_date'] . ' ' . $fetchAttendance['a_actual_time_out']) : null;
                                                $actualDiffInSeconds = ($actualTimeIn && $actualTimeOut) ? max(0, $actualTimeOut - $actualTimeIn) : 0;
                                                $hoursNeeded = sprintf('%02d:%02d:%02d',
                                                    floor($actualDiffInSeconds / 3600),
                                                    floor(($actualDiffInSeconds % 3600) / 60),
                                                    $actualDiffInSeconds % 60
                                                );
                                                $status = '<span class="badges bg-lightyellow">On Time</span>';
                                                if ($timeIn && $actualTimeIn) {
                                                    if ($timeIn > $actualTimeIn + 900) { // more than 15 min late
                                                        $status = '<span class="badges bg-lightred">Late</span>';
                                                    } elseif ($timeIn < $actualTimeIn) {
                                                        $status = '<span class="badges bg-lightgreen">Before Time</span>';
                                                    }
                                                }
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $fetchAttendance['a_date'] ?></td>
                                            <td><?= $fetchAttendance['a_time_in'] ?></td>
                                            <td><?= $fetchAttendance['a_time_out'] ?></td>
                                            <td><?= $hoursWorked ?></td>
                                            <td><?= $fetchAttendance['a_actual_time_in'] ?></td>
                                            <td><?= $fetchAttendance['a_actual_time_out'] ?></td>
                                            <td><?= $hoursNeeded ?></td>
                                            <td><?= $status ?></td>
                                            <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view-progress-<?= $fetchAttendance['a_id'] ?>">View</a></td>
                                        </tr>
                                        <div id="view-progress-<?= $fetchAttendance['a_id'] ?>" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h6><?= $fetchAttendance['a_timesheet'] ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        <?php include 'footer-files.php' ?>
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js"></script>

        <script>
        const intervals = {};

        // Accept either epoch seconds (number) or an ISO-like string 'YYYY-MM-DD HH:MM:SS'
        function startTimerForElementById(elId, startTimestamp) {
            const el = document.getElementById(elId);
            if (!el) return;
            let startTime;
            if (startTimestamp === null || startTimestamp === undefined || startTimestamp === '') return;

            // if startTimestamp looks numeric, treat as epoch seconds
            if (!isNaN(startTimestamp) && String(startTimestamp).trim() !== '') {
                startTime = new Date(Number(startTimestamp) * 1000);
            } else {
                // fallback: convert "YYYY-MM-DD HH:MM:SS" -> "YYYY-MM-DDTHH:MM:SS"
                startTime = new Date(String(startTimestamp).replace(' ', 'T'));
            }
            if (isNaN(startTime)) {
                console.error('Invalid start time for', elId, startTimestamp);
                return;
            }

            function update() {
                const now = new Date();
                let diff = Math.floor((now - startTime) / 1000);
                if (diff < 0) diff = 0;
                const hours = String(Math.floor(diff / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
                const seconds = String(diff % 60).padStart(2, '0');
                el.innerText = `${hours}:${minutes}:${seconds}`;
            }

            update();
            intervals[elId] = setInterval(update, 1000);
        }

        function stopTimerForElementById(elId) {
            if (intervals[elId]) {
                clearInterval(intervals[elId]);
                delete intervals[elId];
            }
            const el = document.getElementById(elId);
            if (el) el.innerText = "00:00:00";
        }

        // Start header timer from DB-derived epoch if available (survives refresh)
        <?php if (!empty($headerStartTs)): ?>
            startTimerForElementById('timer', <?= (int)$headerStartTs ?>);
            <?php 
                // optional: we may still have stored session 'checkin_time', clear it server-side now to keep single source of truth
                if (isset($_SESSION['checkin_time'])) unset($_SESSION['checkin_time']);
            ?>
        <?php endif; ?>

        // If there's a checkout flag in session, stop header timer
        <?php if (isset($_SESSION['checkout_done'])): ?>
            stopTimerForElementById('timer');
            <?php unset($_SESSION['checkout_done']); ?>
        <?php endif; ?>

        // Row timers (DB epoch starts). We echo numeric epoch to JS to avoid parsing quirks.
        <?php
            if (!empty($activeTimers)) {
                foreach ($activeTimers as $t) {
                    $startTs = (int)$t['start_ts'];
                    echo "startTimerForElementById('{$t['id']}', {$startTs});\n";
                }
            }
        ?>
        </script>
    </body>
</html>
<?php 
        } else {
            $_SESSION['toastr_message'] = "Please Login First!";
            $_SESSION['toastr_type'] = "info";
            header("Location: login.php");
            exit();
        }
    } else {
        echo 'Invalid IP Access. Your IP Address is'.$yourIP;
    }
?>