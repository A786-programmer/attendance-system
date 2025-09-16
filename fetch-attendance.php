<?php 
    include 'config.php';
    if ($hasAdminRights) {
        if (isset($_SESSION['as_user'])) {
            $fetchAttendanceActive = 'active';
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
										<label>Select Month</label>
										<input type="user" name="user">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Month</label>
										<input type="month" name="month" value="<?= $month ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Month</label>
										<input type="month" name="month" value="<?= $month ?>">
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="fetch" class="btn btn-submit me-2">Fetch Salaries</button>
								</div>
                            </form>
						</div>
					</div>
                    <?php if ($month) { ?>
                    <div class="page-header">
						<div class="page-title">
							<h4><?= $month ?> Salaries</h4>
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
                                            <th>Hours Worked</th>
                                            <th>Hours Needed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sno = 1;
                                            $users = mysqli_query($con,"SELECT u_id, u_name FROM `users`");
                                            while ($fetchUsers = mysqli_fetch_assoc($users)) {
                                                $attendance = mysqli_query($con,"SELECT a_time_in, a_time_out, a_actual_time_in, a_actual_time_out FROM `attendance` WHERE a_user='$fetchUsers[u_id]' AND a_date LIKE '$month%'");
                                                while ($fetchAttendance = mysqli_fetch_assoc($attendance)) {
                                                    
                                                }
                                        ?>
                                        <tr>
                                            <td><?= $sno ?></td>
                                            <td><?= $fetchUsers['u_name'] ?></td>
                                            <td></td>
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
    include 'footer-files.php';
?>	
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>