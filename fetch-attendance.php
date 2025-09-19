<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if ($hasAdminRights) {
            if (isset($_SESSION['as_user'])) {
                $showAttendanceSection = false;
                $fetchAttendanceActive = 'active';

                if (isset($_POST['fetch'])) {
                    $showAttendanceSection = true;
                    $user = $_POST['user'];
                    $start = $_POST['start'];
                    $end = $_POST['end'];
                    $attendance = mysqli_query($con,"SELECT * FROM attendance WHERE a_user='$user' AND a_date BETWEEN '$start' AND '$end' ORDER BY a_date ASC");
                }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Fetch Attendance</title>
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
							<h4>Fetch Attendance</h4>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<form class="row" method="post">
								<div class="col-md-4">
									<div class="form-group">
										<label>Employee Name</label>
                                        <select name="user" type="select">
                                            <option value="">Select User</option>
                                            <?php 
                                                $users = mysqli_query($con,"SELECT u_id, u_name FROM users WHERE u_role='User'");
                                                while ($fetchUsers = mysqli_fetch_assoc($users)) {
                                                    $selected = $fetchUsers['u_id'] == $user ? 'selected' : '';
                                            ?>
                                                <option value="<?= $fetchUsers['u_id'] ?>" <?= $selected ?>><?= $fetchUsers['u_name'] ?></option>
                                            <?php 
                                                } 
                                            ?>
                                        </select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Start Date</label>
										<input type="date" name="start" value="<?= $start ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>End Date</label>
										<input type="date" name="end" value="<?= $end ?>">
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="fetch" class="btn btn-submit me-2">Fetch Salaries</button>
								</div>
                            </form>
						</div>
					</div>
                    <?php if ($showAttendanceSection) { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Hours Worked</th>
                                            <th>Actual Time In</th>
                                            <th>Actual Time Out</th>
                                            <th>Hours Needed</th>
                                            <th>Hours Difference</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            while ($fetchAttendance = mysqli_fetch_assoc($attendance)) {
                                                $timeIn  = strtotime($fetchAttendance['a_time_in']);
                                                $timeOut = strtotime($fetchAttendance['a_time_out']);
                                                $diffInSeconds = $timeOut - $timeIn;
                                                $hoursWorked = sprintf('%02d:%02d:%02d',
                                                    floor($diffInSeconds / 3600),
                                                    floor(($diffInSeconds % 3600) / 60),
                                                    $diffInSeconds % 60
                                                );

                                                $actualTimeIn  = strtotime($fetchAttendance['a_actual_time_in']);
                                                $actualTimeOut = strtotime($fetchAttendance['a_actual_time_out']);
                                                $actualDiffInSeconds = $actualTimeOut - $actualTimeIn;
                                                $hoursNeeded = sprintf('%02d:%02d:%02d',
                                                    floor($actualDiffInSeconds / 3600),
                                                    floor(($actualDiffInSeconds % 3600) / 60),
                                                    $actualDiffInSeconds % 60
                                                );

                                                $timeDiffInSeconds = $actualDiffInSeconds - $diffInSeconds;
                                                if ($timeDiffInSeconds < 0) {
                                                    $timeDiffInSeconds *= -1;
                                                    $timeDiff = sprintf('%02d:%02d:%02d',
                                                        floor($timeDiffInSeconds / 3600),
                                                        floor(($timeDiffInSeconds % 3600) / 60),
                                                        $timeDiffInSeconds % 60
                                                    );
                                                } else if ($timeDiffInSeconds > 0) {
                                                    $timeDiff = sprintf('%02d:%02d:%02d',
                                                        floor($timeDiffInSeconds / 3600),
                                                        floor(($timeDiffInSeconds % 3600) / 60),
                                                        $timeDiffInSeconds % 60
                                                    );
                                                    $timeDiff = '-'.$timeDiff;
                                                } else {
                                                    $timeDiff = '00:00:00';
                                                }
                                                
                                                $status = '<span class="badges bg-lightyellow">On Time</span>';
                                                if ($timeIn+900 > $actualTimeIn) {
                                                    $status = '<span class="badges bg-lightred">Late</span>';
                                                } else if ($timeIn < $actualTimeIn) {
                                                    $status = '<span class="badges bg-lightgreen">Before Time</span>';
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
                                            <td><?= $timeDiff ?></td>
                                            <td><?= $status ?></td>
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
        } else {
            $_SESSION['toastr_message'] = "You don't have right to access the desired Resource!";
            $_SESSION['toastr_type'] = "info";
            header("Location: index.php");
            exit();
        }
    } else {
        echo 'Invalid IP Access. Your IP Address is'.$yourIP;
    }
    include 'footer-files.php';
?>	
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>