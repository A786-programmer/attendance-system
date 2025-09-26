<?php 
    include 'config.php';
    if(in_array($yourIP, $ipArray)) {
        if ($hasAdminRights) {
            if (isset($_SESSION['as_user'])) {
                $addAttendanceActive = 'active';

                if (isset($_POST['add'])) {
                    try {
                        $userId   = $_POST['user'];
                        $date     = $_POST['date'];
                        $clockIn  = $_POST['clockIn'];
                        $clockOut = $_POST['clockOut'];
                        $user = mysqli_query($con,"SELECT u_time_in, u_time_out FROM `users` WHERE u_id='$userId'");
                        $fetchUser = mysqli_fetch_assoc($user);
                        mysqli_query($con,"INSERT INTO attendance(a_date, a_time_in, a_time_out, a_user, a_actual_time_in, a_actual_time_out) 
                        VALUES('$date', '$clockIn', '$clockOut', '$userId', '$fetchUser[u_time_in]', '$fetchUser[u_time_out]')");
                        $_SESSION['toastr_message'] = "Attendance Added Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: add-attendance.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: add-attendance.php");
                        exit();
                    }
                }

                $attendanceId = $_GET['attenadanceId'];
                if ($attendanceId) {
                    $attendanceQuery = mysqli_query($con,"SELECT * FROM attendance WHERE a_id='$attendanceId'");
                    if (mysqli_num_rows($attendanceQuery) == 0) {
                        $_SESSION['toastr_message'] = "Invalid Access!";
                        $_SESSION['toastr_type'] = "error";
                        header("Location: index.php");
                        exit();
                    }
                    $fetchAttendance = mysqli_fetch_assoc($attendanceQuery);
                }

                if (isset($_POST['update'])) {
                    try {
                        $userId   = $_POST['user'];
                        $date     = $_POST['date'];
                        $clockIn  = $_POST['clockIn'];
                        $clockOut = $_POST['clockOut'];
                        $attendanceId = $_POST['attendanceId'];
                        mysqli_query($con,"UPDATE attendance SET a_date='$date', a_time_in='$clockIn', a_time_out='$clockOut', a_user='$userId' WHERE a_id='$attendanceId'");
                        $_SESSION['toastr_message'] = "Attendance Updated Successfully!";
                        $_SESSION['toastr_type'] = "success";
                        header("Location: add-attendance.php");
                        exit();
                    } catch (Exception $e) {
                        $_SESSION['toastr_message'] = "Something went wrong: " . $e->getMessage();
                        $_SESSION['toastr_type'] = "error";
                        header("Location: add-attendance.php");
                        exit();
                    }
                }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Add Attendance</title>
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
							<h4>Add Attendance Record</h4>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<form class="row" method="post">
                                <input type="hidden" name="attendanceId" value="<?= isset($fetchAttendance['a_id']) ? $fetchAttendance['a_id'] : '' ?>">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <select name="user" class="form-control" required>
                                            <option value="">Select User</option>
                                            <?php 
                                            $users = mysqli_query($con,"SELECT u_id, u_name FROM users WHERE u_role='User'");
                                            while ($fetchUsers = mysqli_fetch_assoc($users)) {
                                                $selected = (isset($fetchAttendance['a_user']) && $fetchAttendance['a_user'] == $fetchUsers['u_id']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $fetchUsers['u_id'] ?>" <?= $selected ?>><?= $fetchUsers['u_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input style="width:100%" type="date" name="date" value="<?= isset($fetchAttendance['a_date']) ? $fetchAttendance['a_date'] : '' ?>" required>
                                    </div>
                                </div>  
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Clock In</label>
                                        <input style="width:100%" type="time" name="clockIn" value="<?= isset($fetchAttendance['a_time_in']) ? $fetchAttendance['a_time_in'] : '' ?>" required>
                                    </div>
                                </div>  
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Clock Out</label>
                                        <input style="width:100%" type="time" name="clockOut" value="<?= isset($fetchAttendance['a_time_out']) ? $fetchAttendance['a_time_out'] : '' ?>" required>
                                    </div>
                                </div>  
                                <div class="col-lg-12">
                                    <?php if (isset($fetchAttendance['a_id'])) { ?>
                                        <button type="submit" name="update" class="btn btn-submit me-2">Update Record</button>
                                    <?php } else { ?>
                                        <button type="submit" name="add" class="btn btn-submit me-2">Add Record</button>
                                    <?php } ?>
                                </div>
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
                                            <th>Employee</th>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Hours Worked</th>
                                            <th>Actual Time In</th>
                                            <th>Actual Time Out</th>
                                            <th>Hours Needed</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $attendance = mysqli_query($con,"SELECT a.*, u.u_name FROM attendance a LEFT JOIN users u ON a.a_user = u.u_id");
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
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $fetchAttendance['u_name'] ?></td>
                                            <td><?= $fetchAttendance['a_date'] ?></td>
                                            <td><?= $fetchAttendance['a_time_in'] ?></td>
                                            <td><?= $fetchAttendance['a_time_out'] ?></td>
                                            <td><?= $hoursWorked ?></td>
                                            <td><?= $fetchAttendance['a_actual_time_in'] ?></td>
                                            <td><?= $fetchAttendance['a_actual_time_out'] ?></td>
                                            <td><?= $hoursNeeded ?></td>
                                            <td>
                                                <a href="add-attendance.php?attenadanceId=<?= $fetchAttendance['a_id'] ?>"><img src="assets/img/icons/edit.svg" alt="img" data-bs-toggle="tooltip" title="Edit"></a>
                                                <a href="code.php?type=deleteAttendance&attenadanceId=<?= $fetchAttendance['a_id'] ?>"><img src="assets/img/icons/delete.svg" alt="img" data-bs-toggle="tooltip" title="Delete"></a>
                                            </td>
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
        echo 'Invalid IP Access. Your IP Address is '.$yourIP;
    }
    include 'footer-files.php';
?>	
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
